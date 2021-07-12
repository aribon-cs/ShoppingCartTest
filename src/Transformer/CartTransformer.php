<?php

namespace App\Transformer;

use App\Helpers\CalculatorHelpers;
use App\Model\CartModel;

/**
 * Class CartTransformer.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class CartTransformer extends AbstractTransformer implements TransformerInterface
{
    /**
     * @var CartModel $item
     */
    public function simpleTransformModel($item): array
    {
        return [
            'title' => 'checkout',
            'total' => number_format(CalculatorHelpers::getTotalPriceOfCheckoutsStatic($item->getProductModels())),
            'items' => (new CheckoutTransformer())->transformArrayObject($item->getProductModels()),
        ];
    }

    public function simpleTransformArray($item): array
    {
        return [
            'title' => 'checkout',
            'total' => number_format(CalculatorHelpers::getTotalPriceOfCheckoutsStatic($item['checkouts'])),
            'items' => (new CheckoutTransformer())->transformArrayObject($item['checkouts']),
        ];
    }
}
