<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addNewProduct(Request $request) {
        $user = auth()->user();
        $name = $request->input('name');
        $validateData = Validator::make($request->all(),[
            'name' => 'required',
            'unit' => 'nullable | in:pieces,gr,kg,ml,l,grams,kilograms,milliliters,liters',
            'barcode' => 'nullable | numeric',
            'description' => 'nullable'
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validateData->errors() 
            ],422);
        }
        $validateData = $validateData->validated();
        $validateData = array_filter($validateData, function ($value) {
            return $value !== null;
        });
        $validateData['user_id'] = $user->id;
        $product = Product::create($validateData);
        return response()->JSON([
            'status' => 'success',
            'message' => 'The product added succesfully.'
        ],201);

    }

    public function getAllProducts() {
        $user = auth()->user();
        $prod = Product::where('user_id',$user->id)->get();
        if($prod->isEmpty()) {
            return response()->json([
                'status' => "fail",
                'message' => 'there are no Product data from this search.'
            ], 404);
        } else {
            return response()->json([
                'status' => "success",
                'data' => $prod
            ], 200);
        }
    }

    public function deleteAProduct($id) {
        $user = auth()->user();
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'status' => 'fail',
                'message' => 'There is no product with this id.'
            ], 404);
        } else {
            if($product->user_id !== $user->id) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You have to access to delete this product.'
                ], 404);
            } else {
                $product->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'You have successfully deleted the product.'
                ], 200);
            }
        }
    }

    public function updateProduct(Request $request, $id) {
        $user = auth()->user();
        $prod = Product::find($id);
        if(!$prod) {
            return response()->json([
                'status' => 'fail',
                'message' => 'There is no product with this id.'
            ], 404);
        } else {
            $validatedData = $request->validate([
                'name' => 'sometimes',
                'unit' => 'sometimes|in:pieces,gr,kg,ml,l,grams,kilograms,milliliters,liters',
                'barcode' => 'sometimes|numeric',
                'description' => 'sometimes'
            ]);
            $prod->update($validatedData);
            return response()->json([
                'status' => 'success', 
                'message' => 'You have successfully update a product',
                'data' => $prod
            ], 200);
        }
    }
}
