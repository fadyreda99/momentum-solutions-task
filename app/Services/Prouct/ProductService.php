<?php

namespace App\Services\Prouct;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(private ProductRepository $productRepository){
    }

    public function index( $request)
    {
        $products = $this->productRepository->index($request);
        return ProductResource::collection($products);
    }

    public function store( $request)
    {
        $product = $this->productRepository->store($request);
        return new ProductResource($product);
    }

    public function show(ProductRequest $request)
    {
        $product = $this->productRepository->show($request);
        return new ProductResource($product);
    }

    public function update(ProductRequest $request)
    {
        $product = $this->productRepository->update($request);
        return new ProductResource($product);
    }

    public function destroy(ProductRequest $request)
    {
        $product = $this->productRepository->destroy($request);
        if ($product == true){
            return response()->json(['message'=>'product deleted successfully'], 200);
        }
        return response()->json(['error'=>'something went wrong'], 500);
    }
}
