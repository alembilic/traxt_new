<?php

namespace App\Core;

use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Contracts\Queue\QueueableCollection;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

trait DoctrineRestoreEntitiesHelper
{
    use EntityManagerFresher;
    use SerializesModels;

    /**
     * {@inheritDoc}
     */
    protected function getSerializedPropertyValue($value)
    {
        if ($value instanceof QueueableCollection) {
            return new ModelIdentifier(
                $value->getQueueableClass(),
                $value->getQueueableIds(),
                $value->getQueueableRelations(),
                $value->getQueueableConnection()
            );
        }

        if ($value instanceof QueueableEntity) {
            return new ModelIdentifier(
                get_class($value),
                $value->getQueueableId(),
                $value->getQueueableRelations(),
                $value->getQueueableConnection()
            );
        }

        if ($value instanceof Collection && $value->count() === 1) {
            $entity = $value->first();

            if ($entity instanceof QueueableEntity) {
                return new ModelIdentifier(
                    get_class($entity),
                    [$entity->getQueueableId()],
                    $entity->getQueueableRelations(),
                    $entity->getQueueableConnection()
                );
            }
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function restoreModel($value)
    {
        $entityManager = $this->getEntityManager();

        $entity = $entityManager->find($value->class, $value->id);

        if ($entity) {
            $entityManager->refresh($entity);
        }

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    protected function restoreCollection($value)
    {
        if (!$value->class || count($value->id) === 0) {
            return collect();
        }

        $entityManager = $this->getEntityManager();

        return collect($entityManager->getRepository($value->class)->findBy(['id' => $value->id]));
    }
}
