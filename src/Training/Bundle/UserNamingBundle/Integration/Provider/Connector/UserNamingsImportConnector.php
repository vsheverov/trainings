<?php

namespace Training\Bundle\UserNamingBundle\Integration\Provider\Connector;

use Oro\Bundle\IntegrationBundle\Provider\AbstractConnector;
use Training\Bundle\UserNamingBundle\Entity\FakeTransportSettings;

class UserNamingsImportConnector extends AbstractConnector
{
    const JOB_NAME = 'user_namings_import_job';
    public function getLabel(): string
    {
        return 'training.integration.fake.connectors.import_user_namings.label';
    }

    public function getImportEntityFQCN(): string
    {
        return FakeTransportSettings::class;
    }

    public function getImportJobName(): string
    {
        return self::JOB_NAME;
    }

    public function getType(): string
    {
        return 'user_namings_import';
    }

    protected function getConnectorSource(): \ArrayIterator
    {
        return $this->transport->getUserNamings();
    }
}
