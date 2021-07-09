<?php


namespace App\Transformer;


use App\Entity\Discount;

class DiscountTransformer extends AbstractTransformer implements TransformerInterface
{
    /**
     * @param $item Discount
     */
    public function simpleTransformModel($item): array
    {
        return [
            'id' => intval($item->getId()),
            'productId' => intval($item->getProduct()->getId()),
            'number' => intval($item->getNumber()),
            'price' => intval($item->getPrice()),
        ];
    }

    /**
     * @param $item Discount
     */
    public function simpleTransformArray($item): array
    {
        return [
            'id' => intval($item['id']),
            'productId' => intval($item['product_id']),
            'number' => intval($item['number']),
            'price' => intval($item['price']),
        ];
    }

    public function listTransformModel($item): array
    {
        return [
            'number' => intval($item->getNumber()),
            'price' => intval($item->getPrice()),
        ];
    }
}