<?php

namespace App\Transformer;

use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Class PaginateTransformer.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class PaginateTransformer extends AbstractTransformer implements TransformerInterface
{
    /**
     * {@inheritDoc}
     *
     * @var PaginationInterface
     */
    public function simpleTransformArray($item): array
    {
        return [
            'pagination' => [
                'current' => intval($item['currentPageNumber']),
                'perPage' => intval($item['itemNumberPerPage']),
                'lastPage' => intval(ceil($item['totalItemCount'] / $item['itemNumberPerPage'])),
                'totalItem' => intval($item['totalItemCount']),
                'number' => intval(sizeof($item['items'])),
            ],
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @var PaginationInterface
     */
    public function simpleTransformModel($item): array
    {
        return [
            'pagination' => [
                'current' => intval($item->getCurrentPageNumber()),
                'perPage' => intval($item->getItemNumberPerPage()),
                'lastPage' => intval(ceil($item->getTotalItemCount() / $item->getItemNumberPerPage())),
                'total' => intval($item->getTotalItemCount()),
                'number' => intval(sizeof($item->getItems())),
            ],
        ];
    }
}
