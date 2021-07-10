<?php

namespace App\DataFixtures;

use App\Entity\Discount;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DiscountFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public const DISCOUNT_REFERENCE = 'discount';

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(
            200,
            self::DISCOUNT_REFERENCE,
            function (int $i) {
                $discount = new Discount();
                $discount->setNumber($this->faker->numberBetween(2, 100));
                $discount->setPrice($this->faker->numberBetween(1000, 2000000));
                $discount->setProduct($this->getReference(ProductFixtures::PRODUCT_REFERENCE.'_'.$i));

                return $discount;
            }
        );

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProductFixtures::class,
        );
    }

    public static function getGroups(): array
    {
        return [self::DISCOUNT_REFERENCE];
    }
}
