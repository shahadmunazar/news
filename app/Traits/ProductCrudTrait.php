<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;  // Add this import

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ProductCrudTrait
{
    /**
     * Create a new product.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createProduct(Request $request)
    {
       
        try {
        $validator  = Validator::make($request->all(), ['name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', ]);
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products');
            $product->image = $imagePath;
        }
        $product->save();
        return response()->json([
            'message' => 'Product created successfully!',
            'product' => $product
        ], 201);
    } catch (\Throwable $th) {
        dd($th);
    }
    }

    /**
     * Get all products.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProducts()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ], 200);
    }

    /**
     * Get a single product by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductById($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'product' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * Update a product by ID.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Validate request data
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            ]);

            // Update product
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;

            // Handle image upload if exists
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/products');
                $product->image = $imagePath;
            }

            $product->save();

            return response()->json([
                'message' => 'Product updated successfully!',
                'product' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

    /**
     * Delete a product by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully!'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }
}
