@extends('front::user.layouts.master')

@section('user-content')
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="px-3 px-res-0">
            <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                <h2>{{ trans('front::messages.partials.register-new-ticket') }}</h2>
            </div>
            <div class="dt-sl dt-sn pt-4">
                <div class="col-12 col-md-10 offset-md-1">
                    <form class="form" id="ticket-create-form" data-redirect="{{ route('front.tickets.index') }}" action="{{ route('front.tickets.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('front::messages.partials.topic') }}</label>
                                        <input type="text" class="form-control" name="subject">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('front::messages.partials.priority') }}</label>
                                        <select name="priority" class="form-control">
                                            <option value="low">{{ trans('front::messages.partials.low') }}</option>
                                            <option value="medium">{{ trans('front::messages.partials.medium') }}</option>
                                            <option value="hight">{{ trans('front::messages.partials.much') }}</option>
                                        </select>
                                    </div>
                                </div>


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
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">{{ trans('front::messages.partials.create-ticket') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>

    <script src="{{ theme_asset('js/pages/tickets/create.js') }}"></script>
@endpush
