@if ($own)
    <div class="outgoing_msg message_div">
        <div class="sent_msg">
            <p class="message-body">{{ $message->message }}</p>
            <span class="time_date"> {{ jdate($message->created_at)->ago() }}</span>

            <div class="message-files">
                @foreach ($message->files as $file)
                    <a target="_blank" title="{{ asset($file->file) }}" href="{{ asset($file->file) }}">{{ trans('front::messages.partials.file') }} {{ $loop->iteration }}</a>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="incoming_msg message_div">
        <div class="incoming_msg_img">
            <img src="{{ $message->user->imageUrl }}" alt="{{ $message->user->fullname }}" title="{{ $message->user->fullname }}">
        </div>
        <div class="received_msg">
            <div class="received_withd_msg">
                <p class="message-body">{{ $message->message }}</p>
                <span class="time_date"> {{ jdate($message->created_at)->ago() }}</span>

                <div class="message-files">
                    @foreach ($message->files as $file)
                        <a target="_blank" title="{{ asset($file->file) }}" href="{{ asset($file->file) }}">{{ trans('front::messages.partials.file') }} {{ $loop->iteration }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
