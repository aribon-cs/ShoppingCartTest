<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{
    public const PRODUCT_REFERENCE = 'product';

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(200, self::PRODUCT_REFERENCE,
            function (int $i) {
                $product = new Product();
                $product->setName($this->faker->randomElement(['A', 'B', 'C', 'D']));
                $product->setPrice($this->faker->numberBetween(1000, 2000000));

                return $product;
            }
            );

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['app', self::PRODUCT_REFERENCE];
    }
}
