<?php

namespace App\Rule;

use App\Model\CartModel;

/**
 * Class PriceOverDiscountRule.
 * more discount when users bought more than x$.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class PriceOverDiscountRule extends AbstractCartRule implements RuleInterface
{
    public function handle(CartModel $cart): CartModel
    {
        // too: implement you logic here

        return parent::handle($cart);
    }
}
