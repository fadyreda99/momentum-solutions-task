<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->paginate) {
            $products = $products->paginate($request->paginate);
        } else {
            $products = $products->get();
        }

        return ProductResource::collection($products);
    }


    public function store(ProductRequest $request)
    {


        $product = Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'inventory'=>$request->inventory
        ]);

        return new ProductResource($product);
    }

    public function show(ProductRequest $request)
    {
        $product = Product::findOrFail($request->id);

        return new ProductResource($product);
    }

    public function update(ProductRequest $request)
    {

        $product = Product::findOrFail($request->id);
        $product->update($request->all());

        return new ProductResource($product);
    }

    public function destroy(ProductRequest $request)
    {
       $product = Product::destroy($request->id);

        return response()->json('product deleted successfully', 200);
    }
}
