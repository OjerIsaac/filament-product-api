<?php

namespace App\Http\Controllers\Common;

use App\Models\Product;
use App\Classes\Responsr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductStoreRequest;
use App\Services\Controllers\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Controller constuctor method
     * @param ProductService $service
     */
    public function __construct(protected ProductService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return Responsr::send("Products fetched Successfully", [
            'data' =>
            ProductResource::collection(
                $this->service->getAllProducts($request)
            )->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductStoreRequest  $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $this->service->addProduct($request);
        return Responsr::send("Product added Successfully", statusCode: Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        return Responsr::send("Product fetched Successfully", [
            'data' =>
            ProductResource::make(
                Product::query()->where('id', $id)->firstOrFail()
            )->response()->getData(true)
        ]);
    }
}
