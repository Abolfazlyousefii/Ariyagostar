
<div class="chat {{ !$own ? 'chat-left' : '' }}">
    <div class="chat-avatar">
        <a class="avatar m-0" data-toggle="tooltip" href="javascript:void(0)" data-placement="right" title="" data-original-title="">
            <img src="{{ $message->user->imageUrl }}" alt="avatar" height="40" width="40" title="{{ $message->user->fullname }}" />
        </a>
    </div>
    <div class="chat-body">
        <div class="chat-content">
            <p>{{ $message->message }}</p>
            <p class="text-muted pt-1 {{ !$own ? 'text-right' : 'text-left' }}">{{ jdate($message->created_at)->ago() }}</p>
        </div>

        <div class="message-files">
            @foreach ($message->files as $file)
                <a target="_blank" title="{{ asset($file->file) }}" href="{{ asset($file->file) }}">فایل {{ $loop->iteration }}</a>
            @endforeach
        </div>
    </div>
</div>
