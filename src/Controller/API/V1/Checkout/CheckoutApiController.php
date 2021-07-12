<?php

namespace App\Controller\API\V1\Checkout;

use App\Controller\AbstractApiController;
use App\Service\Cart\CartService;
use App\Service\Validation\ValidationService;
use App\Transformer\TransformerInterface;
use App\Validator\Constraint\CheckoutConstraint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/checkout", name="checkout_")
 */
class CheckoutApiController extends AbstractApiController
{
    /**
     * @Route("", name="list", methods={"POST"})
     */
    public function index(
        Request $request,
        ValidationService $validationService,
        CartService $cartService,
        TransformerInterface $cartTransformer
    ): JsonResponse {
        $input = json_decode($request->getContent(), true) ?? [];
        $validationService->validateByConstraint($input, CheckoutConstraint::getConstraint());

        $cart = $cartService->handleCart($input['product']);

        return $this->respondWithSuccess($cartTransformer->transformModel($cart));
    }
}
