<?php

namespace App\Rule;

use App\Entity\Discount;
use App\Model\CartModel;
use App\Model\ProductModel;

/**
 * Class AbstractCartRule.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class AbstractCartRule
{
    public ?RuleInterface $next = null;

    public ?array $rulesArray = [];

    public function nextChain(RuleInterface $next, object $referrer = null): RuleInterface
    {
        if (null == $referrer) {
            $referrer = $this;
        }
        $referrer->next = $next;

        return $next;
    }

    public function handle(CartModel $cart): CartModel
    {
        if (is_null($this->next) or !$this->next) {
            return $cart;
        }

        return $this->next->handle($cart);
    }

    /**
     * @param string $rule
     *
     * @return $this
     */
    public function addRule(RuleInterface $rule): self
    {
        $this->rulesArray[] = $rule;

        return $this;
    }

    /**
     * @return $this
     */
    public function prepare(): self
    {
        $startPoint = $this;
        foreach (array_unique($this->rulesArray) as $item) {
            $next = (new $item());
            $startPoint = $this->nextChain($next, $startPoint);
        }

        return $this;
    }

    /**
     * @param $requestedNumber
     */
    public function calcDiscountOnceProduct($requestedNumber, ProductModel $checkoutProduct): ProductModel
    {
        $product = $checkoutProduct->getProductObject();
        $discounts = $product->getDiscounts();
        /** @var Discount $discount */
        $discount = $discounts->filter(fn (Discount $discount) => $discount->getNumber() <= $requestedNumber)->first();
        if ($discount) {
            $packageNumber = intval($requestedNumber / $discount->getNumber());
            $remainNumber = $requestedNumber % $discount->getNumber();
            $checkoutProduct->addDiscount($discount, $packageNumber);

            return $this->calcDiscountOnceProduct($remainNumber, $checkoutProduct);
        }
        $checkoutProduct->addItem($requestedNumber, $product->getPrice());

        return $checkoutProduct;
    }
}
