@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(count($user_list) != 0)
                    @if(!empty($user_list))
                        <?php $color = 0; ?>
                        @foreach($user_list as $user_list_data)
                            <?php
                            if ($color >= 5) {
                                $color = 0;
                            }
                            ?>
                            {{--                                style="background-color: {{$my_array[$color]}}"--}}
                            <div class="card p-3 mb-2">
                                <span>{{$user_list_data->name}}<a href="{{url('message-send/'.$user_list_data->id)}}"
                                                                  class="btn btn-info mb-3 mr-5"
                                                                  style="float: right">Send Message</a></span>
                                {{--                                <form action="{{ route('message-send') }}" method="post">--}}
                                {{--                                    {{$user_list_data->name}}--}}
                                {{--                                    @csrf--}}
                                {{--                                    <input type="hidden" name="sent_to_id" value="{{$user_list_data->id}}">--}}
                                {{--                                    <button type="submit" class="btn btn-info"--}}
                                {{--                                            style="float: right">Send Message--}}
                                {{--                                    </button>--}}
                                {{--                                </form>--}}
                            </div>
                            <?php $color++ ?>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
