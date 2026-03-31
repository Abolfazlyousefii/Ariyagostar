@extends('front::user.layouts.master')
@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 tickets">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                    <h2>{{ trans('front::messages.partials.view-ticket-number') }} {{ $ticket->id }}</h2>
                </div>
            </div>
            <div class="col-12 mb-2">
                <div class="dt-sl dt-sn">
                    <div class="row table-draught px-3">
                        <div class="col-md-3 col-sm-12">
                            <span class="title">{{ trans('front::messages.partials.ticket-subject') }}</span>
                            <span class="value">{{ $ticket->subject }}</span>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <span class="title">{{ trans('front::messages.partials.creation-date') }}</span>
                            <span class="value">{{ jdate($ticket->created_at)->format('%d %B %Y') }}</span>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <span class="title">{{ trans('front::messages.partials.priority') }}</span>
                            <span class="value">{{ $ticket->priorityText() }}</span>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <span class="title">{{ trans('front::messages.partials.condition') }}</span>
                            <span class="value">{{ $ticket->statusText() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="messaging">
                    <div class="inbox_msg">
                        <div class="mesgs">
                            <div class="msg_history">
                                @foreach ($ticket->messages()->oldest()->get() as $message)

                                    @if ($message->user->id == auth()->user()->id)
                                        @include('front::user.tickets.partials.message', ['own' => true])
                                    @else
                                        @include('front::user.tickets.partials.message', ['own' => false])
                                    @endif

                                @endforeach

                            </div>

                        </div>
                    </div>


                </div>
            </div>

            <div class="col-md-12">
                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                    <h2>{{ trans('front::messages.partials.register-new-message') }}</h2>
                </div>
            </div>
        </div>
        <div class="dt-sl dt-sn pt-4">
            <div class="col-12 col-md-10 offset-md-1">
                <form class="form" id="ticket-update-form" data-redirect="{{ route('front.tickets.show', ['ticket' => $ticket]) }}" action="{{ route('front.tickets.update', ['ticket' => $ticket]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-body">
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message">{{ trans('front::messages.partials.message') }}</label>
                                    <textarea id="message" class="form-control" rows="4" name="message"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ trans('front::messages.partials.attachments') }}</label>
                                    <input type="file" class="form-control" name="upload_files[]"  multiple>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">{{ trans('front::messages.partials.record-message') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <!-- End Content -->
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>

    <script src="{{ theme_asset('js/pages/tickets/show.js') }}"></script>
@endpush
