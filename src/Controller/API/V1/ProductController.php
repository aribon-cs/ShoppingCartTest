<?php

namespace App\Controller\API\V1;

use App\Entity\Product;
use App\Service\ProductService;
use App\Traits\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product_")
 */
class ProductController extends AbstractController
{
    use ApiResponseTrait;

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function index(ProductService $productService): JsonResponse
    {
        return $this->respondWithSuccess($productService->applyFilterWithPaginate('list'));
    }

    /**
     * @Route("/{id}", name="detail", methods={"GET"})
     */
    public function detail(Product $product,ProductService $productService): JsonResponse
    {
        return $this->respondWithSuccess($productService->getProductTransformer()->transformModel($product,'list'));
    }
}
