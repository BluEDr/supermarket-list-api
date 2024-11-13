<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SuperList;
// use App\Models\Partner;


class SuperListController extends Controller
{
    public function createANewSuperList(Request $request) {
        $user = auth()->user();
        $validateReqData = Validator::make($request->all(), [
            'name' => 'required',
            'partner_id' => 'nullable|numeric|exists:partners,id'
        ]);  //TODO: akribos apo pano exo problima me to partners id otan to stelno den to dexete. 

        if ($validateReqData->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validateReqData->errors()
            ], 422);
        } else {
            $validateReqData = $validateReqData->validated();
            $validateReqData['user_id'] = $user->id;
            $sList = SuperList::create($validateReqData);
            return response()->json([
                'success' => true,
                'message' => 'The new super_list has succesfully created.',
                'data' => $validateReqData
            ], 201);
        }
    }
}
