<?php

namespace Training\Bundle\UserNamingBundle\Async\Processor;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Component\MessageQueue\Client\TopicSubscriberInterface;
use Oro\Component\MessageQueue\Consumption\MessageProcessorInterface;
use Oro\Component\MessageQueue\Job\JobRunner;
use Oro\Component\MessageQueue\Transport\MessageInterface;
use Oro\Component\MessageQueue\Transport\SessionInterface;
use Oro\Component\MessageQueue\Util\JSON;
use Psr\Log\LoggerAwareTrait;
use Training\Bundle\UserNamingBundle\Async\Topic\GenerateUserNamingExampleTopic;
use Training\Bundle\UserNamingBundle\Async\Topics;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;

class GenerateExampleColumnUserNamingByIdMessageProcessor implements MessageProcessorInterface, TopicSubscriberInterface
{
    use LoggerAwareTrait;

    private JobRunner $jobRunner;

    private ManagerRegistry $registry;

    private UserNameFormatter $userNameFormatter;

    public function __construct(JobRunner $jobRunner, ManagerRegistry $registry, UserNameFormatter $userNameFormatter)
    {
        $this->jobRunner = $jobRunner;
        $this->registry = $registry;
        $this->userNameFormatter = $userNameFormatter;
    }

    public function process(MessageInterface $message, SessionInterface $session): string
    {
        $messageBody = JSON::decode($message->getBody());

        if (false === is_array($messageBody)) {
            $this->logger->error(sprintf(
                'Expected array but got: "%s"',
                is_object($messageBody) ? get_class($messageBody) : gettype($messageBody)
            ));

            return self::REJECT;
        }

        if (!array_key_exists(GenerateUserNamingExampleTopic::IDENTITY_PROPERTY_KEY, $messageBody)) {
            $this->logger->error(sprintf(
                'Expected array with keys "class" and "context" but given: "%s"',
                implode('","', array_keys($messageBody))
            ));

            return self::REJECT;
        }

        $ownerId = $message->getMessageId();

        return $this->runUnique($messageBody, $ownerId) ? self::ACK : self::REJECT;
    }

    private function runUnique(array $messageBody, $ownerId)
    {
        $jobName = $this->buildJobNameForMessage($messageBody);

        $closure = function () use ($messageBody) {
            $userNamingId = $messageBody[GenerateUserNamingExampleTopic::IDENTITY_PROPERTY_KEY];

            /**
             * @var UserNamingType|null $userNaming
             */
            $userNaming = $this->registry->getRepository(UserNamingType::class)->find(
                $userNamingId
            );

            if (!$userNaming) {
                $this->logger->error(sprintf(
                    'Expected UserNamingType is not exists with id %s',
                    $userNamingId
                ));

                return false;
            }

            $userNaming->setExample(
                $this->userNameFormatter->formatExample($userNaming->getFormat())
            );

            $this->registry->getManager()->flush();

            return true;
        };

        return $this->jobRunner->runUnique($ownerId, $jobName, $closure);
    }

    public static function getSubscribedTopics(): array
    {
        return [
            Topics::GENERATE_USER_NAMING_EXAMPLE_TOPIC
        ];
    }

    private function buildJobNameForMessage(array $messageBody): string
    {
        return md5(serialize(
            UserNamingType::class . $messageBody[GenerateUserNamingExampleTopic::IDENTITY_PROPERTY_KEY]
        ));
    }
}
