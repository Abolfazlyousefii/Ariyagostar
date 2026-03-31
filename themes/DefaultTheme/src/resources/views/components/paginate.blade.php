@if ($paginator->hasPages())
    <div class="row">
        <div class="col-lg-12">
            <!-- Start Pagination -->
                <div class="pagination">
                    {{-- Previous Page Link --}}
                    @if (!$paginator->onFirstPage())
                        <a href="{{ $paginator->previousPageUrl() }}" class="prev"><i class="mdi mdi-chevron-double-right"></i></a>

                    @endif
                    
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <a href="javascript:void(0)">{{ $element }}</a>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <a href="javascript:void(0)" class="active-page">{{ $page }}</a>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="next"><i class="mdi mdi-chevron-double-left"></i></a>
                    @endif
                    
                </div>
            </nav>
            <!-- Ends: /pagination-default -->
        </div>
    </div>
@endif