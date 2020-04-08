<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Chat;
use App\Model\Comment;
use App\Model\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class ChatController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contact_list()
    {
        $user_id = Auth::user()->id;
        $my_array = array("red", "green", "blue", "yellow", "purple");
        shuffle($my_array);
        $user_list = User::where('id', '!=', $user_id)->get();
        return view('posts.contact', compact('user_list', 'my_array'));
    }

//    public function index(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'sent_to_id' => 'required',
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors([$validator->messages()->first()]);
//        } else {
//            $user_name = '';
//            $chat = '';
//            $sender_id = '';
//            $sent_to_id = '';
//            $user = '';
//
//            $inputs = $request->all();
//            $sent_to_id = $inputs['sent_to_id'];
//            $user = User::where('id', $sent_to_id)->first();
//            $user_name = $user->name;
//
//            $sender_id = Auth::user()->id;
//            $chat = Chat::where('sender_id', $sender_id And 'sent_to_id', $sender_id)->orwhere('sent_to_id', $sent_to_id And 'sender_id', $sent_to_id)->get();
//
//            return view('posts.chat', compact('chat', 'sent_to_id', 'user_name'));
//        }
//
//    }
    public function index($id)
    {
        if (!empty($id)) {
            $user_name = '';
            $chat = '';
            $sender_id = '';
            $sent_to_id = '';
            $user = '';

            $sent_to_id = $id;
            $sender_id = Auth::user()->id;

            $chat = Chat::whereIn('sender_id', [$sent_to_id, $sender_id])->whereIn('sent_to_id', [$sent_to_id, $sender_id])->get();

            $user = User::where('id', $sent_to_id)->first();
            $user_name = $user->name;

            return view('posts.chat', compact('chat', 'sent_to_id', 'user_name'));
        } else {
            return redirect()->route('contact-list');
        }
    }


    public function chat_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sent_to_id' => 'required',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors([$validator->messages()->first()]);
        } else {
            $sender_id = Auth::user()->id;
            if (!empty($sender_id)) {
                $inputs = $request->all();
                $sent_to_id = $inputs['sent_to_id'];
                $body = $inputs['body'];

                $chat = Chat::chat_create([
                    'sent_to_id' => $sent_to_id,
                    'body' => $body,
                    'sender_id' => $sender_id,
                ]);

                if ($chat['status'] === 'error') {
                    return redirect()->back()->withErrors([$chat['data']]);
                } else {
                    return redirect()->back();
                }
            } else {
                Session::flash('error', 'Invalid User !!!');
                return redirect()->back();
            }

        }

    }

}
