<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SuperList;
use App\Models\Partner;
use Illuminate\Validation\Rule;
// use App\Models\Partner;


class SuperListController extends Controller
{
    public function createANewSuperList(Request $request) {
        $user = auth()->user();
        $validateReqData = Validator::make($request->all(), [
            'name' => 'required',
            //'partner_id' => 'nullable|numeric|exists:partners,partner_id' //edo na elegxei kai o user_id oti einai idios me ton loged in user
            'partner_id' => [
                'nullable',
                'numeric',
                Rule::exists('partners', 'partner_id')->where(function ($query) {
                    $query->where('user_id', auth()->id()); // Check if user_id matches the logged-in user
                }),
            ] 
        ]); 

        if ($validateReqData->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validateReqData->errors()
            ], 422);
        } else {
            $validateReqData = $validateReqData->validated();
            $validateReqData['user_id'] = $user->id;
            if($request->partner_id)
                $validateReqData['partner_id'] = $request->partner_id;
            $sList = SuperList::create($validateReqData);
            return response()->json([
                'status' => "success",
                'message' => 'The new super_list has succesfully created.',
                'data' => $validateReqData,
            ], 201);
        }
    }
}
