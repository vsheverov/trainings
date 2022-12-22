<?php

namespace Training\Bundle\UserNamingBundle\Async\Topic;

use Oro\Component\MessageQueue\Client\MessagePriority;
use Oro\Component\MessageQueue\Topic\AbstractTopic;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Training\Bundle\UserNamingBundle\Async\Topics;

/**
 * A topic to import new user namings from Fake integration
 */
class GenerateUserNamingExampleTopic extends AbstractTopic
{
    const IDENTITY_PROPERTY_KEY = 'userNamingId';

    public static function getName(): string
    {
        return Topics::GENERATE_USER_NAMING_EXAMPLE_TOPIC;
    }

    public static function getDescription(): string
    {
        return 'Generate example for User Naming';
    }

    public function getDefaultPriority(string $queueName): string
    {
        return MessagePriority::VERY_LOW;
    }

    public function configureMessageBody(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(self::IDENTITY_PROPERTY_KEY)
            ->setAllowedTypes(self::IDENTITY_PROPERTY_KEY, 'int');
    }
}
