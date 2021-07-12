<?php

namespace App\Controller\API\V1\Product;

use App\Controller\AbstractApiController;
use App\Entity\Product;
use App\Service\ProductService;
use App\Service\Validation\ValidationService;
use App\Validator\Constraint\ProductConstraint;
use App\Validator\Constraint\ProductUpdateConstraint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product_")
 */
class ProductApiController extends AbstractApiController
{
    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function index(ProductService $productService): JsonResponse
    {
        return $this->respondWithSuccess($productService->applyFilterWithPaginate('list'));
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(ProductService $productService, ValidationService $validationService, Request $request): JsonResponse
    {
        $input = json_decode($request->getContent(), true);
        $validationService->validateByConstraint($input ?? [], ProductConstraint::getConstraint());

        $product = $productService->insert($input);

        return $this->respondWithSuccess($productService->getTransformer()->transformModel($product));
    }

    /**
     * @Route("/{id}", name="detail", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function detail(Product $product, ProductService $productService): JsonResponse
    {
        return $this->respondWithSuccess($productService->getTransformer()->transformModel($product, 'list'));
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     */
    public function update(Product $product, ProductService $productService, ValidationService $validationService, Request $request): JsonResponse
    {
        $input = json_decode($request->getContent(), true);
        $validationService->validateByConstraint($input ?? [], ProductUpdateConstraint::getConstraint());

        $productService->update($product, $input);

        return $this->respondWithSuccess($productService->getTransformer()->transformModel($product));
    }
}
