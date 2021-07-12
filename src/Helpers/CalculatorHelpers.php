<?php

namespace App\Helpers;

use App\Model\ProductModel;
use App\Traits\CallMethodStaticAndDynamicTrait;

/**
 * Class CalculatorHelpers.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 *
 * @method static int getTotalPriceOfCheckoutsStatic(array $checkouts)
 */
class CalculatorHelpers
{
    use CallMethodStaticAndDynamicTrait;

    public function getTotalPriceOfCheckouts(array $checkouts): int
    {
        $sum = 0;
        /** @var ProductModel $checkout */
        foreach ($checkouts as $checkout) {
            $sum += intval($checkout->getTotalPrice());
        }

        return $sum;
    }

}
