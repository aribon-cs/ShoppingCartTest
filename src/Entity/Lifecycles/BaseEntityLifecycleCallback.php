<?php

namespace App\Entity\Lifecycles;

use App\Entity\AbstractBaseEntity;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseEntityLifecycleCallback.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class BaseEntityLifecycleCallback extends BaseLifecycleCallback
{
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdateHandler(AbstractBaseEntity $entity, PreUpdateEventArgs $event): void
    {
        /* important ! Don't update this field (UpdatedAt) here because this handle by orm\version */
    }
}
