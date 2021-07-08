<?php

namespace App\Entity\Lifecycles;

use App\Entity\AbstractBaseEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseLifecycleListener.
 *
 * Implement all `Doctrine callback` such as :
 * PrePersist,PostPersist,PreUpdate,PostUpdate,PostRemove,PreRemove,PostLoad,PreFlush
 *
 * <strong>Important note:<strong>
 *
 * If you want to use below events you must `Subscribe Doctrine Events`
 * onFlush,loadClassMetadata,onClassMetadataNotFound,postFlush,onClear
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
abstract class BaseLifecycleCallback
{
    /**
     * The prePersist event occurs for a given entity before the respective EntityManager persist operation for that
     * entity is executed. It should be noted that this event is only triggered on initial persist of an entity (i.e.
     * it does not trigger on future updates).
     *
     * @ORM\PrePersist()
     */
    public function prePersistHandler(AbstractBaseEntity $entityObject, LifecycleEventArgs $event): void
    {
    }

    /**
     * The postPersist event occurs for an entity after the entity has been made persistent.
     * It will be invoked after the database insert operations.
     * Generated primary key values are available in the postPersist event.
     *
     * @ORM\PostPersist()
     */
    public function postPersistHandler(AbstractBaseEntity $entityObject, LifecycleEventArgs $event): void
    {
    }

    /**
     * The preUpdate event occurs before the database update operations to entity data.
     * It is not called for a DQL UPDATE statement nor when the computed changeset is empty.
     *
     * @ORM\PreUpdate()
     */
    public function preUpdateHandler(AbstractBaseEntity $entityObject, PreUpdateEventArgs $event): void
    {
    }

    /**
     * The postUpdate event occurs after the database update operations to entity data.
     * It is not called for a DQL UPDATE statement.
     *
     * @ORM\PostUpdate()
     */
    public function postUpdateHandler(AbstractBaseEntity $entityObject, LifecycleEventArgs $event): void
    {
    }

    /**
     * The postRemove event occurs for an entity after the entity has been deleted.
     * It will be invoked after the database delete operations.
     *
     * @ORM\PostRemove()
     */
    public function postRemoveHandler(AbstractBaseEntity $entityObject, LifecycleEventArgs $event): void
    {
    }

    /**
     * The preRemove event occurs for a given entity before the respective EntityManager remove operation for that
     * entity is executed.
     *
     * @ORM\PreRemove()
     */
    public function preRemoveHandler(AbstractBaseEntity $entityObject, LifecycleEventArgs $event): void
    {
    }

    /**
     * The postLoad event occurs for an entity after the entity has been loaded into the current EntityManager from the
     * database or after the refresh operation has been applied to it.
     *
     * @ORM\PostLoad()
     */
    public function postLoadHandler(AbstractBaseEntity $entityObject, LifecycleEventArgs $event): void
    {
    }

    /**
     * The preFlush event occurs at the very beginning of a flush operation.
     *
     * @ORM\PreFlush()
     */
    public function preFlushHandler(AbstractBaseEntity $entityObject, PreFlushEventArgs $event): void
    {
    }
}
