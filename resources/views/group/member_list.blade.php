@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($users as $user)
                <div class="col-3 user" id="{{ $user->id }}">
                    <div class="media card p-2 m-2">
                        <div class="media-body">
                            <p class="name">{{ $user->name }}</p>
                            <p class="email">{{ $user->email }}</p>
                            <form method="post" action="{{route('add-member')}}">
                                @csrf
                                <input type="hidden" name="group_id" value="{{$group_id}}">
                                <input type="hidden" name="member_id" value="{{$user->id}}">
                                <button class="btn-sm btn-info" type="submit">add</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
