<?php


namespace App\Transformer;

use Doctrine\Common\Collections\Collection;

interface TransformerInterface
{
    /**
     * Function transformArray by type.
     *
     * This function transforms a array object of items and return,
     * according to the abstract transform method.
     *
     * @param array $items
     * @param string $type <b>'simple'|'full'|'paginator'|...</b>
     * @return array
     */
    public function transformArrayObject(array $items, string $type = 'simple'): array;

    /**
     * Function transformArray by type.
     *
     * This function transforms a array of items and return,
     * according to the abstract transform method.
     *
     * @param array $items
     * @param string $type <b>'simple'|'full'|'paginator'|...</b>
     * @return array
     */
    public function transformArray(array $items, string $type = 'simple'): array;

    /**
     * Function transformCollection by type.
     *
     * This function transforms a collection of items and return simple,
     * according to the abstract transform method.
     *
     * @param Collection|null $items
     * @param string $type <b>'simple'|'full'|'paginator'|...</b>
     * @return array
     */
    public function transformCollection(?Collection $items, string $type = 'simple'): array;

    public function transformModel($item, string $type = 'simple'): array;

    public function simpleTransformModel($item): array;

    public function simpleTransformArray($item): array;
}