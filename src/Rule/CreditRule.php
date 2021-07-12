<?php

namespace App\Rule;

use App\Model\CartModel;

/**
 * Class CreditRule.
 * check user has enough credit and check is user a creditor or not and apply it on checkout.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class CreditRule extends AbstractCartRule implements RuleInterface
{
    public function handle(CartModel $cart): CartModel
    {
        // too: implement you logic here

        return parent::handle($cart);
    }
}
