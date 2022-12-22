<?php

namespace Training\Bundle\UserNamingBundle\Integration\Provider\Transport;

use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Training\Bundle\UserNamingBundle\Entity\FakeTransportSettings;
use Training\Bundle\UserNamingBundle\Integration\Form\Type\TransportSettingsFormType;

class FakeTransport implements TransportInterface
{
    private ParameterBag $settings;

    public function init(Transport $transportEntity)
    {
        $this->settings = $transportEntity->getSettingsBag();
    }
    public function getLabel(): string
    {
        return 'training.zendesk.transport.rest.label';
    }

    public function getSettingsFormType(): string
    {
        return TransportSettingsFormType::class;
    }

    public function getSettingsEntityFQCN(): string
    {
        return FakeTransportSettings::class;
    }

    public function getUserNamings(): \ArrayIterator
    {
        return new \ArrayIterator([
            [
                'id' => 1,
                'title' => 'Official',
                'format' => 'TEST FORMAT'
            ]
        ]);
    }
}
