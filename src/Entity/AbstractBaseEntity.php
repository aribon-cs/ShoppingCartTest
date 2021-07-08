<?php

namespace App\Entity;

use App\Traits\DynamicSetterTrait;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseEntity.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 * @ORM\MappedSuperclass()
 * @ORM\EntityListeners({"App\Entity\Lifecycles\BaseEntityLifecycleCallback"})
 */
abstract class AbstractBaseEntity
{
    use DynamicSetterTrait;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"})
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Version
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"})
     */
    private DateTimeInterface $updatedAt;

    /**
     * BaseEntity constructor.
     */
    public function __construct()
    {
        $time = new \DateTime('now');
        $this->createdAt = $time;
        $this->updatedAt = $time;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
