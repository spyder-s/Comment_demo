<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ChatController extends Controller
{
    public function count()
    {
        $chat = Chat::all();
        return response()->json(['status' => 'ok', 'data' => $chat], 200);
    }


    public function message_data(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($request->all(), [
            'sent_to_id' => 'required',
            'sender_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = '';
            foreach ($errors->all() as $message) {
                $error = $message;
            }
            return response()->json(['status' => 'error', 'error' => $error]);
        } else {
            $user_name = '';
            $chat = '';
            $sender_id = '';
            $sent_to_id = '';
            $user = '';
            $sent_to_id = $inputs['sent_to_id'];
            $sender_id = $inputs['sender_id'];

            $chat = Chat::whereIn('sender_id', [$sent_to_id, $sender_id])->whereIn('sent_to_id', [$sent_to_id, $sender_id])->get();

            $user = User::where('id', $sent_to_id)->first();
            $user_name = $user->name;

            $message_data = array(
                'chat' => $chat,
                'user_name' => $user_name,
                'sent_to_id' => $sent_to_id,
            );
            return response()->json(['status' => 'ok', 'data' => $message_data], 200);

        }
    }


}
