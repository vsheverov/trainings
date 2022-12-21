<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class UserNamingBundle implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('oro_integration_transport');

        $table->addColumn('fki_url', 'string', [
            'length' => 120,
            'notnull' => false,
        ]);
    }
}
