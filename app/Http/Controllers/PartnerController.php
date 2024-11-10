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
                'message' => 'You already added this partner in your parners list!'
            ]);
        } elseif ($partner && ($partnersMail !== $user->email)) {
            $partner1 = Partner::create([
                'user_id' => $user->id,
                'partner_id' => $partner->id
            ]);
            return response()->JSON([
                'status' => 'ok',
                'user_name' => $user->name,
                'user_mail' => $user->email,
                'partnersMail' => $partner->email
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
        if ($partner) {
            $checkPartnership = Partner::where('partner_id',$partner->id)->where('user_id',$user->id)->first();
            if($checkPartnership)
                return response()->JSON([
                    'status' => 'success',
                    'partner' => $request->partnerMail,
                    'isPartner' => true
                ]);
            else    
                return response()->JSON([
                    'status' => 'fail',
                    'message' => 'There is no partnership with you.',
                    'isPartner' => false
                ]);
        } else {
            return response()->JSON([
                'status' => 'fail',
                'message' => 'There is no partner with this email',
                'isPartner' => false
            ]);
        }
    }
}
