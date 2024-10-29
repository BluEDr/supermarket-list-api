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
        if ($partner && ($partnersMail !== $user->email)) {
            //TODO: edo stamatisa na synexiso me tis eisagoges stin basi
            $partner = Partner::create([
                'user_id' => $user->id,
                'partner_id' => $partner->id
            ]);
            return response()->JSON([
                'user_name' => $user->name,
                'user_mail' => $user->email,
                'partnersMail' => $partner->email
            ]);
        } else { //The email that sent is wrong
            return response()->JSON([
                'status' => $partnersMail
            ]);
        } 
    }
}
