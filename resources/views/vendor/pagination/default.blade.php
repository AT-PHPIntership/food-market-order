@if ($paginator->hasPages())
    <ul class="pagination pull-right">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                {{--{{dd($element)}}--}}
                @foreach ($element as $page => $url)
                    @if ($page == 1)
                        <li class="{{$paginator->currentPage() == $page ? 'active' : ''}}">
                            <a href="{{ $url }}">{{ $page }}</a></li>
                    @elseif ($page == $paginator->currentPage())
                        <li class="active">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>

                    @elseif ($page == $paginator->lastPage())
                        <li class="{{$paginator->currentPage() == $page ? 'active' : ''}}">
                            <a href="{{ $url }}">{{ $page }}</a></li>
                    @elseif ($page == $paginator->currentPage() - 2 || $page == $paginator->currentPage() + 2)
                        <li class="disabled"><a>...</a></li>
                    @endif

                    {{--@if ($page == $paginator->currentPage())--}}
                        {{--<li class="active"><span>{{ $page }}</span></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                    {{--@endif--}}
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
