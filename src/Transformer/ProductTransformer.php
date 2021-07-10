<?php


namespace App\Transformer;


use App\Entity\Product;

class ProductTransformer extends AbstractTransformer implements TransformerInterface
{
    public function simpleTransformModel($item): array
    {
        return [
            'name'=> $item->getName(),
            'price'=> intval($item->getPrice()),
        ];
    }

    public function simpleTransformArray($item): array
    {
        return [
            'name'=> $item['name'],
            'price'=> intval($item['price']),
        ];
    }

    /**
     * @param $item Product
     * @return array
     */
    public function listTransformModel($item): array
    {
        return [
            'id'=> $item->getId(),
            'name'=> $item->getName(),
            'price'=> intval($item->getPrice()),
            'discounts' => (new DiscountTransformer())->transformCollection($item->getDiscounts(), 'list')
        ];
    }
}