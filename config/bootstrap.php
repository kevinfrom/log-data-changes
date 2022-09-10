<?php

use Cake\Event\EventManager;
use LogDataChanges\Event\LogDataChangesEventListener;

EventManager::instance()->on(new LogDataChangesEventListener());
