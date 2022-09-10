<?php

namespace LogDataChanges\Event;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use LogDataChanges\Model\Table\LogDataChangesChangesTable;

class LogDataChangesEventListener implements EventListenerInterface
{

    public function implementedEvents(): array
    {
        return [
            'Model.afterSave' => 'modelAfterSave',
            'Model.afterDelete' => 'modelAfterDelete',
        ];
    }

    public function modelAfterSave(Event $event, EntityInterface $entity): void
    {
        $table = get_class($event->getSubject());
        $changes_table = TableRegistry::getTableLocator()->get('LogDataChanges.LogDataChangesChanges');

        if (
            $table === get_class($changes_table)
            || strpos($table, 'DebugKit\\') !== false
        ) {
            return;
        }

        $new_data = $entity->toArray();
        $old_data = array_merge($new_data, $entity->extractOriginal($entity->getDirty()));

        $data = $changes_table->newEntity([
            'table' => $table,
            'entity' => get_class($entity),
            'entity_id' => $entity->get('id') ?: null,
            'model_event' => $entity->isNew() ? 'create' : 'update',
            'new_data' => json_encode($new_data),
            'old_data' => $entity->isNew() ? null : json_encode($old_data),
        ]);

        $changes_table->saveOrFail($data);
    }

    public function modelAfterDelete(Event $event, EntityInterface $entity): void
    {
        $table = get_class($event->getSubject());
        $changes_table = TableRegistry::getTableLocator()->get('LogDataChanges.LogDataChangesChanges');

        if (
            $table === get_class($changes_table)
            || strpos($table, 'DebugKit\\') !== false
        ) {
            return;
        }

        $new_data = $entity->toArray();
        $old_data = array_merge($new_data, $entity->extractOriginal($entity->getDirty()));

        $data = $changes_table->newEntity([
            'table' => $table,
            'entity' => get_class($entity),
            'entity_id' => $entity->get('id') ?: $entity->get($event->getSubject()->getPrimaryKey()),
            'model_event' => 'delete',
            'new_data' => json_encode($new_data),
            'old_data' => json_encode($old_data),
        ]);

        $changes_table->saveOrFail($data);
    }
}
