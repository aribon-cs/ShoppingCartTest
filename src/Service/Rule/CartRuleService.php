<?php

namespace App\Service\Rule;

use App\Model\CartModel;
use App\Rule\CheckProductExistRule;
use App\Rule\CreditRule;
use App\Rule\MajorDiscountRule;
use App\Rule\PriceOverDiscountRule;
use App\Rule\RoundDiscountRule;
use App\Rule\RuleInterface;
use App\Rule\WithoutDiscountRule;
use Doctrine\ORM\EntityManagerInterface;

class CartRuleService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function apply(CartModel $cart): CartModel
    {
        return $this->getRules()->handle($cart);
    }

    private function getRules(): RuleInterface
    {
        $rules = new CheckProductExistRule($this->entityManager);
        $rules
            ->nextChain(new MajorDiscountRule($this->entityManager))
            ->nextChain(new WithoutDiscountRule($this->entityManager))
            ->nextChain(new PriceOverDiscountRule())
            ->nextChain(new RoundDiscountRule())
            ->nextChain(new CreditRule());

        return $rules;
    }

//    public function deliver(CartModel $cart)
//    {
//    }
}
