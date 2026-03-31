@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">

        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                    <h2>{{ trans('front::messages.partials.list-of-tickets') }}</h2>
                    <a href="{{ route('front.tickets.create') }}" class="btn btn-info d-block">{{ trans('front::messages.partials.register-new-ticket') }}</a>
                </div>
            </div>
        </div>

        @if($tickets->count())

            <div class="row">
                <div class="col-12">
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('front::messages.partials.ticket-number') }}</th>
                                    <th>{{ trans('front::messages.partials.topic') }}</th>
                                    <th>{{ trans('front::messages.partials.date-ticket-registration') }}</th>
                                    <th>{{ trans('front::messages.partials.priority') }}</th>
                                    <th>{{ trans('front::messages.partials.condition') }}</th>
                                    <th>{{ trans('front::messages.partials.details') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td class="text-info">{{ $ticket->id }}</td>
                                            <td>{{ $ticket->subject }}</td>
                                            <td>{{ jdate($ticket->created_at)->format('%d %B %Y') }}</td>
                                            <td>{{ $ticket->priorityText() }}</td>
                                            <td>
                                                {{ $ticket->statusText() }}
                                            </td>
                                            <td class="details-link">
                                                <a href="{{ route('front.tickets.show', ['ticket' => $ticket]) }}">
                                                    <i class="mdi mdi-chevron-left"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="row">
                <div class="col-12">
                    <div class="page dt-sl dt-sn pt-3">
                        <p>{{ trans('front::messages.partials.there-is-nothing-to-show') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-3">
            {{ $tickets->links('front::components.paginate') }}
        </div>

    </div>
    <!-- End Content -->
@endsection
