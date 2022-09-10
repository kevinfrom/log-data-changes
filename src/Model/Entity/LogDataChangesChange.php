<?php

namespace LogDataChanges\Model\Entity;

use Cake\ORM\Entity;

class LogDataChangesChange extends Entity
{

    protected $_accessible = [
        'id' => false,
        '*' => true,
    ];
}
