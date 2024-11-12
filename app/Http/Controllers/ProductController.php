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
            'barcode' => 'nullable | numeric'
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validateData->errors() 
            ],422);
        }

        $product = Product::create([
            'name' => $name,
            'user_id' => $user->id
        ]);
        return response()->JSON([
            'success' => true,
            'message' => 'The product added succesfully.'
        ],201);

    }
}
