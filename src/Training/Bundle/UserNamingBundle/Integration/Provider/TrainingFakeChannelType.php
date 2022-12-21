<?php

namespace Training\Bundle\UserNamingBundle\Integration\Provider;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;

class TrainingFakeChannelType implements ChannelInterface
{
    const TYPE = 'training_fake';

    public function getLabel(): string
    {
        return 'training.integration.fake.title.label';
    }
}
