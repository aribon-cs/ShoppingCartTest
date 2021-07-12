<?php

namespace App\Rule;

use App\Model\CartModel;

/**
 * Class RoundDiscountRule.
 * round discount for total price of checkout.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class RoundDiscountRule extends AbstractCartRule implements RuleInterface
{
    public function handle(CartModel $cart): CartModel
    {
        // too: implement you logic here

        return parent::handle($cart);
    }
}
