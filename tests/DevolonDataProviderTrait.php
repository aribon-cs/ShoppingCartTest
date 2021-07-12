<?php

namespace App\Tests;

trait DevolonDataProviderTrait
{
    public function devolonDataProvider()
    {
        return [
            // A, B
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                ],
                80,
            ],
            [
                [
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                80,
            ],
            // A, A
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                100,
            ],
            // A, A, A
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                130,
            ],
            // C, D, B, A
            [
                [
                    ['id' => 4, 'number' => 1],
                    ['id' => 3, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                115,
            ],
            [
                [
                    ['id' => 2, 'number' => 1],
                    ['id' => 3, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 4, 'number' => 1],
                ],
                115,
            ],
            // B, A, B
            [
                [
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                ],
                95,
            ],
            //extra test
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                230,
            ],
            [
                [
                    ['id' => 1, 'number' => 3],
                    ['id' => 1, 'number' => 2],
                ],
                230,
            ],
            [
                [
                    ['id' => 1, 'number' => 5],
                ],
                230,
            ],
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                260,
            ],
            [
                [
                    ['id' => 1, 'number' => 6],
                ],
                260,
            ],
            [
                [
                    ['id' => 1, 'number' => 6],
                    ['id' => 2, 'number' => 5],
                ],
                380,
            ],
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                380,
            ],
            [
                [
                    ['id' => 1, 'number' => 8],
                    ['id' => 2, 'number' => 5],
                ],
                480,
            ],
            [
                [
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 2, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                    ['id' => 1, 'number' => 1],
                ],
                480,
            ],
        ];
    }

    public function getRequestProductDataProvider()
    {
        return [
            [
                [
                    'product' => [
                        ['id' => 1, 'number' => 10],
                        ['id' => 2, 'number' => 2],
                        ['id' => 3, 'number' => 3],
                        ['id' => 1, 'number' => 10],
                        ['id' => 2, 'number' => 2],
                    ],
                ],
                [
                    ['id' => 1, 'sum' => 20],
                    ['id' => 2, 'sum' => 4],
                    ['id' => 3, 'sum' => 3],
                ],
            ],
            [
                [
                    'product' => [
                        ['id' => 1, 'number' => 10],
                        ['id' => 1, 'number' => 10],
                        ['id' => 1, 'number' => 10],
                        ['id' => 1, 'number' => 10],
                        ['id' => 1, 'number' => 10],
                        ['id' => 2, 'number' => 2],
                        ['id' => 2, 'number' => 2],
                        ['id' => 2, 'number' => 2],
                        ['id' => 3, 'number' => 3],
                        ['id' => 3, 'number' => 3],
                        ['id' => 3, 'number' => 3],
                    ],
                ],
                [
                    ['id' => 1, 'sum' => 50],
                    ['id' => 2, 'sum' => 6],
                    ['id' => 3, 'sum' => 9],
                ],
            ],
        ];
    }
}
