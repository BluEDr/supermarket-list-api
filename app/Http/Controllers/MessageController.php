<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuperList;
use App\Models\Message;

class MessageController extends Controller
{
    public function addANewMessage(Request $request, $superListId) {
        $userId = auth()->id();
        $superList = SuperList::where('id', $superListId)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere(function ($subQuery) use ($userId) {
                        $subQuery->where('partner_id', $userId)
                                 ->where('partners_write_permition', 1);
                    });
            })
            ->first();
        if($superList) {
            if(!$request->message) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'You have to send a message, please try again.',    
                ], 404);
            } else {
                $title = $request->title ? $request->title : "No title.";
                $newMessage = new Message;
                $newMessage->super_list_id = $superListId;
                $newMessage->title = $title;
                $newMessage->message = $request->message;
                $newMessage->user_id = $userId;
                $newMessage->save();
                //TODO: na tsekaro an einai etoimo gia na pao sto epomeno
                return response()->json([
                    'status' => 'success', 
                    'message' => 'You have successfully added a new message!',
                ], 201);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'You have to access for writing a message in the selected list.',
            ], 404);
        }
    }

    public function update(Request $request, $id) {
        $userId = auth()->id();
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string|max:255'
        ]);

        $message = Message::where('id',$id)->where('user_id',$userId)->first();

        if(!$message){
            return response()->json([
                'status' => 'fail',
                'message' => 'There is no message to update with the given values.'
            ], 404);
        }

        $message->update($validatedData);
        return response()->json([
            'status' => 'success',
            'message' => 'The message has succeccfully updated.'
        ], 200);
    }

    public function delete($id) {
        $userId = auth()->id();
        $message = Message::where('id',$id)->where('user_id',$userId)->first();
        if(!$message) {
            return response()->json([
                'status' => 'success',
                'message' => 'There is no message to delete with the given values.'
            ], 404);
        }

        $message->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'The message has successfully deleted.'
        ], 200);
    }
}
