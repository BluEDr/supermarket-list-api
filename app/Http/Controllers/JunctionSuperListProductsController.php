<?php

namespace App\Http\Controllers;
use App\Models\SuperList;
use App\Models\Product;
use App\Models\Partner;
use Illuminate\Http\Request;

class JunctionSuperListProductsController extends Controller
{
    public function addProductToList(Request $request) {
        $user = auth()->user();
        $list = SuperList::find($request->superId);
        if($list) {
            $product = Product::find($request->productId);
            if(!$product) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'There is no product with the given id.'
                ], 404);
            } else {

                $data = $request->validate([
                    'superId' => 'required|exists:super_lists,id',
                    'productId' => 'required|exists:products,id',
                ]);

                // syncWithoutDetaching() anti gia attach() gia na min kanei eggrafes me ta idia stoixeia poy exoyn ginei ksana
                SuperList::find($data['superId'])->products()->syncWithoutDetaching($data['productId']);

                return response()->json([
                    'status' => 'success',
                    'list' => $list,
                    'product' => $product,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'There is no superlist with the given id.'
            ], 404);
        }
    }

    public function getProductsFromMyList(Request $request) {
        $user = auth()->user();
        $listId = intval($request->superListId);
        $list = SuperList::find($listId);
        if($list) {
            $isPartnerOfList = ($list->partner_id === $user->id);
            if(($list->user_id === $user->id) || $isPartnerOfList) { //here check out if the logged in user is the creator of list or the partner.

                $list->products; //kalei me apo to model tis superList tin product function kai etsi einai orato kai ektiponei poio kato sto return response kai to periexomeno toy ksenoy kleidioy me ta stoixeia apo ton sisxetizomeno pinaka
                $list->partner;
                $list->user;
 
                return response()->json([
                    'status' => 'success',
                    // 'partnersId' => optional($partner)->id, //the optional function used for protecting me from error in case that there is no partner data
                    'list' => $list,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You have no access to this list.'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'The values are wrong.'
            ], 404);
        }

    }
}
