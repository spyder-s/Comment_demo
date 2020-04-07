@extends('layouts.app')

@section('content')

    @if(!empty($post))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-success">Comment Section Test</h3>
                            <br/>
                            @if(!empty($post->title))
                                <h2>{{ $post->title }}</h2>
                            @endif
                            @if(!empty($post->body))
                                <p>
                                    {{ $post->body }}
                                </p>
                            @endif
                            <hr/>
                            <h5>Display Comments</h5>

                            @if(!empty($post->comments))
                                @include('posts.commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
                            @endif

                            <hr/>
                            <h5>Add comment</h5>
                            @if(!empty($post->id))
                                <form method="post" action="{{ route('comments-store'   ) }}">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form-control" name="body"></textarea>
                                        <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="Add Comment"/>
                                    </div>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <h2>No Post Found...!!!</h2>
        </div>
    @endif

@endsection
