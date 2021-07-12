<?php

namespace App\Rule;

use App\Entity\Product;
use App\Helpers\CalculatorHelpers;
use App\Model\CartModel;
use App\Model\ProductModel;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MajorDiscountMiddleware.
 * add discount to the user when we have a special discount for buying x number of a product.
 * and we calculate the remaining number as the default price of the product.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class MajorDiscountRule extends AbstractCartRule implements RuleInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(CartModel $cart): CartModel
    {
        /** @var Product[] $selectedProducts */
        $selectedProducts = $this->entityManager->getRepository(Product::class)->findWithDiscounts(array_keys($cart->getProductsIds()));
        foreach ($selectedProducts as $product) {
            $requestedNumber = $cart->getProductsIds()[$product->getId()];
            $productModel = new ProductModel();
            $productModel->setProductObject($product);
            $productModel = $this->calcDiscountOnceProduct($requestedNumber, $productModel);
            $cart->addCheckouts($productModel);
        }

        return parent::handle($cart);
    }
}
