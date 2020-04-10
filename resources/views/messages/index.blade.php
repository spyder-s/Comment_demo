@php
    use App\User;
@endphp
<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)
            <li class="message clearfix">
            <?php
            $name = User::where('id', $message->from)->first();
            ?>
            <!--if message from id is equal to auth id then it is sent by logged in user -->
                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                    @if(!empty($group_id))
                        <p class="date">{{$name->name}}</p>
                    @endif
                    <p>{{ $message->message }}</p>
                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<div class="input-text">
    <input type="text" name="message" class="submit">
</div>
