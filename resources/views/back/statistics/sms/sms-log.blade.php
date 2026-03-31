@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item active">اعلان ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">

                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">لاگ پیامک های ارسالی</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            @if($sms->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>شماره</th>
                                                <th>نوع</th>
                                                <th>زمان</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($sms as $s)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $s->mobile }}</td>
                                                    <td>{{ $s->type() }}</td>
                                                    <td title="{{ jdate($s->created_at)  }}">{{ jdate($s->created_at)->ago() }}</td>
                                                    <td class="text-center">
                                                        <button type="button" data-action="{{ route('admin.sms.show', ['sms' => $s]) }}" class="btn btn-info waves-effect waves-light show-sms">مشاهده</button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>چیزی برای نمایش وجود ندارد!</p>
                            @endif

                        </div>
                    </div>
                </section>

                {{ $sms->links() }}

            </div>
        </div>
    </div>

    <!-- show Modal -->
    <div class="modal fade text-left" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel21">جزئیات پیامک</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="sms-detail" class="modal-body"></div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/statistics/sms.js') }}"></script>
@endpush
