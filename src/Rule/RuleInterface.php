<?php

namespace App\Rule;

use App\Model\CartModel;

/**
 * Interface RuleMiddlewareInterface.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
interface RuleInterface
{
    public function handle(CartModel $cart);

    public function nextChain(RuleInterface $param);
}
