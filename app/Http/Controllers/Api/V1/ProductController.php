<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ){}

    public function index()
    {
        return $this->productRepository->getProducts();
    }

    public function store(ProductRequest $request)
    {
        return $this->productRepository->addNewProduct($request->validated());
    }

    public function show($id)
    {
        //
    }

    public function update(ProductRequest $request, Product $product)
    {
        return $this->productRepository->updateProduct($product, $request->validated());
    }

    public function destroy(Product $product)
    {
        return $this->productRepository->deleteProduct($product);
    }

    public function search (Request $request) {
        if ($request->keyword) {
            return $this->productRepository->searchProduct($request->keyword);
        }

        return response()->json([
            'data' => $request
        ]);
    }
}
