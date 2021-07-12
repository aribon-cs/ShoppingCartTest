<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DiscountConstraint.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class DiscountUpdateConstraint implements ConstraintInterface
{
    final public static function getConstraint(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'number' => new Assert\Required(
                    [
                        new Assert\Type(['type' => 'integer', 'message' => 'number must be integer']),
                        new Assert\Positive(),
                    ],
                ),
                'price' => [
                    new Assert\Required(
                        [
                            new Assert\Type(['type' => 'integer', 'message' => 'price must be integer']),
                            new Assert\Positive(),
                        ]
                    ),
                ],
            ]
        );
    }
}
