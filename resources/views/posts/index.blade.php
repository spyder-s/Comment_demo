@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Manage Posts</h3>
                <a href="{{ route('posts-create') }}" class="btn btn-success mb-3" style="float: right">Create Post</a>

                <a href="{{ route('contact-list') }}" class="btn btn-info mb-3 mr-5" style="float: right">Message</a>
                {{--                <a href="{{ route('message-send') }}" class="btn btn-info mb-3 mr-5" style="float: right">Send--}}
                {{--                    Message</a>--}}
                <table class="table table-bordered">
                    <thead>
                    <th width="80px">Id</th>
                    <th>Title</th>
                    <th width="150px">Action</th>
                    </thead>
                    <tbody>
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <a href="{{ route('posts-show', $post->id) }}" class="btn btn-primary">View Post</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
