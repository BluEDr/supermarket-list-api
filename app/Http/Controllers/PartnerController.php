<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function createPartnership(Request $request) {
        $user = auth()->user();
        $partnersMail = $request->input('partnersMail');
        $partner = User::where('email', $partnersMail)->first();
        $validateData = $request->validate([
            'partnersMail' => 'required | email'
        ]);
        if(!$partner) {
            return response()->JSON([
                'status' => 'fail',
                'message' => 'The partner email does not exist!'
            ]);
        }
        $checkPartnership = Partner::where('user_id',$user->id)->where('partner_id',$partner->id)->first();
        if ($checkPartnership) {
            return response()->json([
                'status' => 'ok',
                'message' => 'You have already added this partner in your parners list!'
            ]);
        } elseif ($partner && ($partnersMail !== $user->email)) {
            $partner1 = Partner::create([
                'user_id' => $user->id,
                'partner_id' => $partner->id
            ]);
            return response()->JSON([
                'status' => 'Success',
                'message' => 'You have successfully added a new partner!',
                'data' => [
                    'partnersName' => $partner->name,
                    'partnersMail' => $partner->email,
                    'partnersCreatedAccount' => $partner->created_at,
                ],
            ]);
        } elseif ($user->id === $partner->id) {
            return response()->JSON([
                'status' => 'fail',
                'message' => 'The email you sent is the same that you loged in.'
            ]);
        } else { //The email that sent is wrong
            return response()->JSON([
                'status' => $partnersMail
            ]);
        } 
    }

    public function checkPartnership(Request $request) {
        $user = auth()->user();
        $partner = User::where('email',$request->partnerMail)->first();
        if(!$partner) {
            return response()->json([
                'status' => 'fail',
                'message' => 'The email that you sent is not in your partner list.',
                'isPartner' => false,
            ], 404);
        }
        if ($partner && ($partner->id !== $user->id)) {
            $checkPartnership = Partner::where('partner_id',$partner->id)->where('user_id',$user->id)->first();
            if($checkPartnership)
                return response()->JSON([
                    'status' => 'success',
                    'partnersId' => $partner->id,
                    'partnersMail' => $request->partnerMail,
                    'isPartner' => true
                ], 200);
            else    
                return response()->JSON([
                    'status' => 'fail',
                    'message' => 'There is no partnership with you.',
                    'isPartner' => false
                ], 404);
        } elseif ($partner->id === $user->id) {
            return response()->JSON([
                'status' => 'fail',
                'message' => 'The email that you want to check is the same with the email from user that you loged in.',
                'isPartner' => false
            ], 404);
        } else {
            return response()->JSON([
                'status' => 'fail',
                'message' => 'There is no partner with this email',
                'isPartner' => false
            ], 404);
        }
    }

    public function deletePartner($id) {
        $user = auth()->user();
        $partner = Partner::where('user_id',$user->id)->where('partner_id',$id)->first();
        if(!$partner) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You are not partners with this user.'
            ], 404);    
        } else {
            $partner->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'The partnership with this user has successfully deleted.'
            ], 200);
        }
    }
}
