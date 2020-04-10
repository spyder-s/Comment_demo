<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Chat;
use App\Group;
use App\Message;
use App\Model\Comment;
use App\Model\Post;
use App\User;
use App\UserGroup;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Pusher\Pusher;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function chat()
    {
        $user_id = Auth::user()->id;
        $users = User::where('id', '!=', $user_id)->get();
        return view('home', ['users' => $users]);
    }

    public function getMessage($user_id)
    {
//        $users = User::find($user_id);
//        dd($users->role === 'group');
        $my_id = Auth::id();
        $group_id = '';
        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $users = User::find($user_id);
        if ($users->role === 'group') {
            $group_id = $user_id;
            $messages = Message::orwhere('from', $user_id)->orwhere('to', $user_id)->get();
            //    dd($messages);
        } else {
            // Get all message from selected user
            $messages = Message::whereIn('from', [$user_id, $my_id])->whereIn('to', [$user_id, $my_id])->get();
        }

        return view('messages.index', ['messages' => $messages, 'group_id' => $group_id]);
    }


    public
    function sendMessage(Request $request)
    {
        $from = Auth::id();
        //$from = 1;
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $users = User::find($to);
        if ($users->role === 'group') {
            $group_id = $request->receiver_id;
            $group_member = UserGroup::select('id')->where('group_id', $to)->get();
            foreach ($group_member as $member) {
                $to = $member->id;
                $data = ['from' => $group_id, 'to' => $to]; // sending from and to user id when pressed enter
                $pusher->trigger('my-channel', 'my-event', $data);
            }
        } else {
            $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
            $pusher->trigger('my-channel', 'my-event', $data);
        }

//        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
//        $pusher->trigger('my-channel', 'my-event', $data);

    }

    public
    function create_group(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors([$validator->messages()->first()]);
        } else {
            $user_id = Auth::id();
            if (!empty($user_id)) {
                $inputs = $request->all();
                $name = $inputs['name'];
                $data = User::group_create([
                    'user_id' => $user_id,
                    'name' => $name,
                    'role' => 'group'
                ]);

                if ($data['status'] === 'error') {
                    Session::flash('error', 'Something Is Wrong!!!');
                    return back();
                } else {
                    $data = UserGroup::add_member_group([
                        'user_id' => $user_id,
                        'group_id' => $data['data']->id,
                    ]);
                    Session::flash('success', 'Post Has Been Create!!');
                    return back();
                }
            } else {
                return redirect()->route('login');
            }
        }
    }

    public
    function member_list($id)
    {
        if (!empty($id)) {
            $group_id = $id;
            $check_group = User::where('role', 'group')->where('id', $id)->first();
            $user_id = Auth::user()->id;
            $exist_user = '';
            $a = [];
            if (!empty($check_group)) {
                $check_group_member = UserGroup::select('id')->where('group_id', $group_id)->get();

                foreach ($check_group_member as $group_member_data) {
                    array_push($a, $group_member_data['id']);
                }
                //array_push($a, $user_id);
                array_push($a, $group_id);
                $users = User::whereNotIn('id', $a)->get();
                //dd($users);
//                $users = User::where('id', '!=', $user_id)->get();
                return view('group.member_list', ['users' => $users, 'group_id' => $group_id]);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }


    public function add_member(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'member_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors([$validator->messages()->first()]);
        } else {
            $user_id = Auth::id();
            if (!empty($user_id)) {
                $inputs = $request->all();
                $group_id = $inputs['group_id'];
                $member_id = $inputs['member_id'];

                $user_check = UserGroup::where('group_id', $group_id)->where('user_id', $member_id)->first();
                if (empty($user_check)) {

                    $data = UserGroup::add_member_group([
                        'user_id' => $member_id,
                        'group_id' => $group_id,

                    ]);

                    if ($data['status'] === 'error') {
                        Session::flash('error', 'Something Is Wrong!!!');
                        return back();
                    } else {
                        Session::flash('success', 'Post Has Been Create!!');
                        return back();
                    }
                } else {
                    Session::flash('error', 'User Is Already Part Of This Group!!!');
                    return back();
                }
            } else {
                return redirect()->route('login');
            }
        }
    }

}
