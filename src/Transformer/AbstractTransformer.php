<?php

namespace App\Transformer;

use Doctrine\Common\Collections\Collection;

/**
 * Class Transformer.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 *
 * This class abstracts responsibilities of transforming
 * JSON data for the API.
 */
abstract class AbstractTransformer
{

    public function transformArrayObject(array $items, string $type = 'simple'): array
    {
        if (empty($items) or is_null($items)) {
            return [];
        }

        return array_map([$this, $type.'TransformModel'], $items);
    }

    public function transformArray(array $items, string $type = 'simple'): array
    {
        if (empty($items) or is_null($items)) {
            return [];
        }

        return array_map([$this, $type.'TransformArray'], $items);
    }

    public function transformCollection(?Collection $items, string $type = 'simple'): array
    {
        if (is_null($items) or $items->isEmpty()) {
            return [];
        }

        return $items->map( fn($item) => call_user_func([$this, $type.'TransformModel'], $item))->toArray();
    }

    public function transformModel($item, string $type = 'simple'): array
    {
        if (is_null($item) or empty($item)) {
            return [];
        }

        return call_user_func([$this, $type.'TransformModel'], $item);
    }

}
