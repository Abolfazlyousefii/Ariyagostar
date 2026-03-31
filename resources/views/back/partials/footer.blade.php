<footer class="footer footer-static footer-light">
</footer>

@if(isset($help_videos) && $help_videos && (option('enable_help_videos', 'true') == 'true'))
    <button id="page-help-button" data-toggle="modal" data-target="#video-helpe-modal" class="btn btn-info btn-lg waves-effect waves-light" type="button">
        <i class="feather icon-help-circle"></i> راهنمای تصویری
    </button>

    <!-- Modal -->
    <div class="modal fade" id="video-helpe-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">آموزش تصویری مربوط به این صفحه</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body aparat-div">
                    <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                        <div class="card collapse-icon accordion-icon-rotate">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="accordion-default collapse-bordered">
                                        @foreach ($help_videos as $help_video)
                                            @if ($help_video['type'] == 'creator' && !auth()->user()->isCreator())
                                                @continue
                                            @endif

                                            <div class="card collapse-header">
                                                <div id="heading1" class="card-header collapse-header" data-toggle="collapse" role="button" data-target="#accordion{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="accordion{{ $loop->index }}">
                                                    <span class="lead collapse-title">
                                                        {{ $help_video['title'] }}
                                                    </span>
                                                </div>
                                                <div id="accordion{{ $loop->index }}" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse {{ $loop->first ? 'show' : '' }}">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            {!! aparat_iframe($help_video['link']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
