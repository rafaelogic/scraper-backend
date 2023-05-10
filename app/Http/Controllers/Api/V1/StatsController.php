<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;

class StatsController extends Controller
{
    public function __invoke(ProductRepositoryInterface $product)
    {
        return response()->json([
            'message' => 'success',
            'data' => $product->getProductWithHighQuanties()
        ]);
    }
}
