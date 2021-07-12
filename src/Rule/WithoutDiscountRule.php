<?php

namespace App\Rule;

use App\Entity\Product;
use App\Helpers\CalculatorHelpers;
use App\Model\CartModel;
use App\Model\ProductModel;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class WithoutDiscountRule.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class WithoutDiscountRule extends AbstractCartRule implements RuleInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(CartModel $cart): CartModel
    {
        /**
         * @var Product[] $selectedProducts
         *
         * @TODO its better to read product from first step that we check it they exist in db or not, or store them in
         *      in a cart object or etc
         */
        $selectedProducts = $this->entityManager->getRepository(Product::class)->findManyByIds(array_keys($cart->getRemainProductIds()));
        foreach ($selectedProducts as $product) {
            $requestedNumber = $cart->getProductsIds()[$product->getId()];
            $checkoutObject = new ProductModel();
            $checkoutObject->setProductObject($product);
            $checkoutObject = $this->calcDiscountOnceProduct($requestedNumber, $checkoutObject);
            $cart->addCheckouts($checkoutObject);
        }

        return parent::handle($cart);
    }
}
