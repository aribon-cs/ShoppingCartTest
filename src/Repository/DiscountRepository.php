<?php

namespace App\Repository;

use App\Entity\Discount;
use App\Traits\FilterableTrait;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Discount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discount[]    findAll()
 * @method Discount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountRepository extends AbstractRepository implements FilterableRepositoryInterface
{
    use FilterableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discount::class);
    }

}
