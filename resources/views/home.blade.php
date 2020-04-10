@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="row pl-3">
                    {{--                    <a href="{{ route('posts-create') }}" class="btn btn-info mb-2" style="float: right">Create--}}
                    {{--                                                    Group</a>--}}
                    <form class="form-inline my-2" method="post" action="{{route('create-group')}}">
                        @csrf
                        <input class="form-control mr-sm-2 mb-3" type="text" placeholder="Group Name"
                               aria-label="Search"
                               name="name">
                        <button class="btn btn-info my-2 my-sm-0" type="submit">Create</button>
                    </form>
                </div>
                <div class="user-wrapper">
                    <ul class="users">
                        @foreach($users as $user)
                            <li class="user" id="{{ $user->id }}">
                                {{--will show unread count notification--}}
                                @if($user->unread)
                                    <span class="pending">{{ $user->unread }}</span>
                                @endif

                                <div class="media">
                                    <div class="media-left">
                                        @if(!empty($user->avatar))
                                            <img src="{{ $user->avatar }}" alt="" class="media-object">
                                        @endif
                                    </div>

                                    <div class="media-body">
                                        <p class="name">{{ $user->name }}</p>
                                        <p class="email">{{ $user->email }}</p>
                                    </div>
                                    @if($user->role === 'group')
                                        <a href="{{ url('member-list/'.$user->id) }}"
                                           class="btn-sm btn-success mb-3 mr-3"
                                           style="float: right;text-decoration: none">Add Member</a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8" id="messages"></div>


        </div>
    </div>

@endsection
