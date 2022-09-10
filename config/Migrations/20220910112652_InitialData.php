<?php

use Migrations\AbstractMigration;

class InitialData extends AbstractMigration
{

    public function change()
    {
        $this->table('log_data_changes_changes')
            ->addColumn('table', 'string')
            ->addColumn('entity', 'string')
            ->addColumn('entity_id', 'integer', ['null' => true, 'default' => null])
            ->addColumn('model_event', 'string')
            ->addColumn('new_data', 'string', ['length' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
            ->addColumn('old_data', 'string', ['null' => true, 'default' => null, 'length' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_LONG])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addIndex(['table'])
            ->addIndex(['entity'])
            ->addIndex(['entity_id'])
            ->addIndex(['model_event'])
            ->save();
    }
}
