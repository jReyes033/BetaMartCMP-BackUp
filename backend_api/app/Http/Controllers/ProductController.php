<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        if ($products->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $products
            ],200);
        } 
        else
        {
            return response()->json([
                'status' => 404,
                'Message' => 'No Records Found'
            ],404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required | string | max:191',
            'description' => 'required | string | max:191', 
            'category' => 'required | string | max:191',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => 'required | integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->messages()
            ], 400);
        } else {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]); 

            if ($product) {
                return response()->json([
                    'status' => 200,
                    'message' => "Product Created Succesfully"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong"
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($productID)
    {
        $product = Product::find($productID);

        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Product found."
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($productID)
    {
        $product = Product::find($productID);

        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Product found."
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $productID)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required | string | max:191',
            'description' => 'required | string | max:191', 
            'category' => 'required | string | max:191',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => 'required | integer'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->messages()
            ], 400);
        } else {
            $product = Product::find($productID);

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]); 

            if ($product) {
                return response()->json([
                    'status' => 200,
                    'message' => "Product updated succesfully"
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No valid product found"
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $productID)
    {
        $product = Product::find($productID);

        if ($product) {
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => "Product deleted succesfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No valid product to delete."
            ], 404);
        }
    }
}
