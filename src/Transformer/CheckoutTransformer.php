<?php

namespace App\Transformer;

use App\Model\ProductModel;

/**
 * Class CheckoutTransformer.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class CheckoutTransformer extends AbstractTransformer implements TransformerInterface
{
    /** @var ProductModel */
    public function simpleTransformModel($item): array
    {
        return [
            'id' => $item->getProductObject()->getId(),
            'name' => $item->getProductObject()->getName(),
            'total' => number_format($item->getTotalPrice()),
            'discounted price' => number_format($item->getDiscountTotalPrice()),
            'total number' => $item->getTotalCounter(),
            'number with discounts' => $item->getDiscountCounterItems(),
        ];
    }

    public function simpleTransformArray($item): array
    {
        return [
            'id' => $item['productObject']['id'],
            'name' => $item['productObject']['name'],
            'total' => number_format($item['totalPrice']),
            'discounted price' => number_format($item['discountTotalPrice']),
            'total number' => $item['totalCounter'],
            'number with discounts' => $item['discountCounterItems'],
        ];
    }
}
