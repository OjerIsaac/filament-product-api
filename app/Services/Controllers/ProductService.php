<?php

namespace App\Services\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Classes\QueryFilters;
use Illuminate\Pipeline\Pipeline;
use App\Classes\Utils\RequestUtility;
use App\Http\Requests\ProductStoreRequest;

class ProductService
{
    /**
     * Product Service function to get All products
     * @param Request $request
     * @return mixed
     */
    public function getAllProducts(Request $request): mixed
    {
        return app(Pipeline::class)
            ->send(Product::query())
            ->through([
                QueryFilters\Sort::class
            ])->thenReturn()
            ->paginate(RequestUtility::limit($request));
    }

    /**
     * Product Service function to add product
     * @param ProductStoreRequest $request
     */
    public function addProduct(ProductStoreRequest $request)
    {
        $payload = collect($request->validated());

        Product::create($payload->toArray());
    }
}
