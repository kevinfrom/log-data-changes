<?php

namespace LogDataChanges\Model\Table;

use Cake\ORM\Table;

class LogDataChangesChangesTable extends Table
{

    public function initialize($config): void
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
    }
}
