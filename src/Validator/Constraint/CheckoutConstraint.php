<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CheckoutConstraint.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class CheckoutConstraint implements ConstraintInterface
{
    final public static function getConstraint(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'fields' => [
                    'product' => new Assert\Required(
                        [
                            new Assert\Type('array'),
                            new Assert\Count(['min' => 1]),
                            new Assert\All([
                                new Assert\Collection(
                                    [
                                        'fields' => [
                                            // we could use `barcode` instead of `id` and its better!
                                            'id' => new Assert\Required([
                                                new Assert\Type('integer'),
                                                new Assert\Positive(),
                                            ]),
                                            'number' => new Assert\Required([
                                                new Assert\Type(['type' => 'integer']),
                                                new Assert\Positive(),
                                            ]),
                                        ],
                                        'allowExtraFields' => false,
                                    ]
                                ),
                            ]),
                        ]
                    ),
                ],
                'allowExtraFields' => false,
            ]
        );
    }
}
