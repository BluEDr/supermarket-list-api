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
            'success' => true,
            'message' => 'The product added succesfully.'
        ],201);

    }

    public function getAllProducts() {
        $user = auth()->user();
        $prod = Product::where('user_id',$user->id)->get();
        if(!$prod) {
            return response()->json([
                'success' => false,
                'message' => 'there are no Product data from this search.'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $prod
            ], 200);
        }
    }
}
