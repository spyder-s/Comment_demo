@extends('layouts.app')
@section('css')
    <style>
        div.ex3 {
            height: 300px;
            overflow: auto;
            padding-right: 20px;
        }
    </style>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Messages</div>
                    <div class="card-body">
                        <div class="form-group ex3">
                            @if(!empty($user_name))
                                <label class="label">{{$user_name}}: </label>
                                <br>
                            @endif
                            @if(!empty($chat))
                                @foreach($chat as $chat_data)
                                    <?php
                                    $sender_id = Auth::user()->id;
                                    ?>
                                    @if($chat_data->sender_id == $sender_id)
                                        <div style="float: right">
                                            {{$chat_data->body}}
                                        </div><br>
                                    @else
                                        <div style="float: left">
                                            {{$chat_data->body}}
                                        </div><br>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <form method="post" action="{{ route('chat-message') }}">
                        @csrf
                        <div class="form-group">
                            <label class="label">Send Title: </label>
                            <input type="hidden" name="sent_to_id" class="form-control" value="{{$sent_to_id}}"/>
                            <input type="text" name="body" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="send" style="float: right"/>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let userEmail;

        function selectUser(data) {
            localStorage.setItem("userEmail", data);
            var x = localStorage.getItem("userEmail");
            document.getElementById("demo").innerHTML = x;
            console.log(userEmail);
        }
    </script>
@stop
