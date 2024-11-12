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
        //TODO: edo apo kato prepei na yparxei problima me tin kataxorisi toy user_id moy petaei ektos to name eno to stelno apo to post request
        $validateData = $validateData->validated();
        $validateData = array_filter($validateData, function ($value) {
            return $value !== null;
        });
        $filteredData['user_id'] = $user->id;
        //TODO: edo na kataxoro tis times poy exei dosei o xristis agnoontas ta nullable pedia poy den exei steilei
        $product = Product::create($filteredData);
        return response()->JSON([
            'success' => true,
            'message' => 'The product added succesfully.'
        ],201);

    }
}
