<?php

namespace App\Rule;

use App\Entity\Product;
use App\Exceptions\RuleExceptions\NotExistRuleException;
use App\Model\CartModel;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CheckProductExistRule.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class CheckProductExistRule extends AbstractCartRule implements RuleInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(CartModel $cart): CartModel
    {
        $ids = array_keys($cart->getProductsIds());
        $result = $this->entityManager->getRepository(Product::class)->getExistIds($ids);
        $dbIds = array_map(fn ($input) => $input['id'], $result);

        $notExistProducts = array_diff($ids, $dbIds);
        if ($notExistProducts) {
            throw new NotExistRuleException('not exist products', 'data', ['ids' => $notExistProducts]);
        }

        return parent::handle($cart);
    }
}
