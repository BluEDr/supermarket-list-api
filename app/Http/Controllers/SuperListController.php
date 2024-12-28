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
            ],
            
            'partners_write_permition' => 'nullable|boolean',   //In case that the user does not add this value, i have add the false as a default value. 
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
    public function updateSuperList(Request $request, $id) {
        $user = auth()->user();
        $loggedInUserId = $user->id;
        $list = SuperList::where('id', $id) 
            ->where(function ($query) use ($loggedInUserId) {
                $query->where('user_id', $loggedInUserId) // Match user_id with logged-in user
                    ->orWhere(function ($query) use ($loggedInUserId) {
                        $query->where('partner_id', $loggedInUserId) // Match partner_id with logged-in user
                                ->where('partners_write_permition', true); // Check if write permission is true
                    });
            })
            ->first();
            if(!$list) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'There is no superList with this id or you do not have access to it.'
                ], 404);
            } else {
                $validatedData = $request->validate([
                    'name' => 'sometimes|nullable',
                ]);

                if($list->user_id === $loggedInUserId) {  //here only if the loged in user is the user that created the list can change the write permition
                    $additionalValidatedData = $request->validate([                 //TODO: Ayto to validation isos eprepe na to kano me rules, na to do gia na to matho. Doyleyei alla tha itan pio kathara grammeno me rule.
                        'partners_write_permition' => 'sometimes|nullable|boolean', //TODO: in this validation maybe i have to update and the partners_id
                    ]);
                    $validatedData = array_merge($validatedData,$additionalValidatedData);
                }
                
                $list->update($validatedData);   

                return response()->json([
                    'status' => 'success',
                    'message' => 'The entry has been successfully updated.',
                    'data' => $list,
                ], 200);
            }

            return response()->json($list, 200);
    }

    public function deleteSuperList($id) {
        $userId = auth()->id();
        $sList = SuperList::where('id',$id)->where('user_id',$userId)->first();
        if(!$sList) {
            return response()->json([
                'status' => 'fail',
                'message' => 'There is no superList with the given id or you have no access.'
            ], 404);
        }
        $sList->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'The super list has been successfully deleted.'
        ], 200);
    }
}



