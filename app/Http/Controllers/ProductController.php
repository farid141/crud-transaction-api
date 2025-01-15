<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        $validated = $request->validated();
        $validated['created_by_id'] = Auth::id();

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('images');
            }
        }
        DB::commit();

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product->setHidden(['media']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product['images'] = $product->getMedia('images')->map(function ($image) {
            return $image->getUrl();
        });
        return response()->json($product->makeHidden(['media']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        $validated = $request->validated();

        $product->getMedia('images')->each->delete();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('images');
            }
        }

        $product->update($validated);
        $product->save();
        DB::commit();

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->setHidden(['media']),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        $product->getMedia('images')->each->delete();
        $product->delete();
        DB::commit();

        return response()->json([
            'message' => 'Product deleted successfully',
            'product' => $product->setHidden(['media']),
        ], 201);
    }
}
