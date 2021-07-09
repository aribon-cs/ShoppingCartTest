<?php

namespace App\Repository;

use App\Entity\Product;
use App\Traits\Filterable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractRepository implements FilterableRepositoryInterface
{
    use Filterable;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

}
