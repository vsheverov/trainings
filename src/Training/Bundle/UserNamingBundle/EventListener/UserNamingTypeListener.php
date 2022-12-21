<?php

namespace Training\Bundle\UserNamingBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use Training\Bundle\UserNamingBundle\Async\Topic\GenerateUserNamingExampleTopic;
use Training\Bundle\UserNamingBundle\Async\Topics;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingTypeListener
{
    private MessageProducerInterface $producer;
    public function __construct(MessageProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    public function preUpdateHandler(UserNamingType $userNamingType, PreUpdateEventArgs $args): void
    {
        if (!$args->hasChangedField('format')) {
            return;
        }

        $this->sendToProducer($userNamingType);
    }

    public function postPersistHandler(UserNamingType $userNamingType): void
    {
        $this->sendToProducer($userNamingType);
    }

    private function sendToProducer(UserNamingType $userNamingType): void
    {
        $this->producer->send(Topics::GENERATE_USER_NAMING_EXAMPLE_TOPIC, [
            GenerateUserNamingExampleTopic::IDENTITY_PROPERTY_KEY => $userNamingType->getId()
        ]);
    }
}
