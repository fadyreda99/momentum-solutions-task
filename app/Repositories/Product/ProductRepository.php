<?php

namespace App\Repositories\Product;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository
{
    public function index( $request)
    {
        $products = Product::query();
        if ($request->paginate) {
            $products = $products->paginate($request->paginate);
        } else {
            $products = $products->get();
        }
        return $products;
    }

    public function store( $request)
    {
        $product = Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'inventory'=>$request->inventory
        ]);
        return $product;
    }

    public function show( $request)
    {
        $product = Product::findOrFail($request->id);
        return $product;
    }

    public function update( $request)
    {
        $product = $this->show($request);
        $product->update($request->all());
        return $product;
    }

    public function destroy( $request)
    {
        $product = Product::destroy($request->id);
        return true;
    }
}
