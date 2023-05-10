<?php

namespace App\Repositories;

use App\Http\Resources\V1\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProduct(Product $product): JsonResource
    {
        return ProductResource::make($product);
    }

    public function getProducts(): AnonymousResourceCollection
    {
        $products = DB::collection('products')
                        ->timeout(1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(50);


        return ProductResource::collection($products);
    }

    public function addNewProduct(array $productData): JsonResource
    {
        $product = Product::create($productData);
        return ProductResource::make($product);
    }

    public function updateProduct(Product $product, array $newProductData): JsonResource
    {
        $product->update($newProductData);
        return ProductResource::make($product->fresh());
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }

    public function searchProduct(string $keyword): JsonResource
    {
        $result = Product::where('title', 'like', '%'.$keyword.'%')
                        ->timeout(1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(50);

        return ProductResource::collection($result);
    }

    public function getProductWithHighQuanties(): Collection
    {
        return Product::where('quantity', '>', 0)
                    ->timeout(1)
                    ->orderBy('quantity', 'desc')
                    ->limit(10)
                    ->get();
    }
}
