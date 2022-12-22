<?php

namespace Training\Bundle\UserNamingBundle\Async\Topic;

use Oro\Component\MessageQueue\Client\MessagePriority;
use Oro\Component\MessageQueue\Topic\AbstractTopic;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Training\Bundle\UserNamingBundle\Async\Topics;

/**
 * A topic to import new user namings from Fake integration
 */
class ImportNewUserNamingsTopic extends AbstractTopic
{
    public static function getName(): string
    {
        return Topics::IMPORT_NEW_USER_NAMINGS_WITH_INTEGRATION;
    }

    public static function getDescription(): string
    {
        return 'Import new User Namings from Fake Integration.';
    }

    public function getDefaultPriority(string $queueName): string
    {
        return MessagePriority::VERY_LOW;
    }

    public function configureMessageBody(OptionsResolver $resolver): void
    {
        //$resolver
          //  ->setRequired('integrationId')
            //->setAllowedTypes('integrationId', 'int');
    }
}
