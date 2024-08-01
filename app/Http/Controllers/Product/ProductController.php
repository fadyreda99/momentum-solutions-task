<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Services\Prouct\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        return $this->productService->index($request);
    }


    public function store(ProductRequest $request)
    {
        return $this->productService->store($request);
    }

    public function show(ProductRequest $request)
    {
        return $this->productService->show($request);
    }

    public function update(ProductRequest $request)
    {
            return $this->productService->update($request);
    }

    public function destroy(ProductRequest $request)
    {
        return $this->productService->destroy($request);
    }
}
