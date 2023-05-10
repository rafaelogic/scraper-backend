<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

interface ProductRepositoryInterface
{
    public function getProducts(): AnonymousResourceCollection;
    public function getProduct(Product $product): JsonResource;
    public function addNewProduct(array $productData): JsonResource;
    public function updateProduct(Product $product, array $newProductData): JsonResource;
    public function deleteProduct(Product $product): bool;
    public function searchProduct(string $keyword): JsonResource;
    public function getProductWithHighQuanties(): Collection;
}
