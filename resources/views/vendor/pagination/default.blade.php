@if ($paginator->hasPages())
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span class="page-numbers style"><i class="far fa-angle-left"></i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="page-numbers style" rel="prev"><i class="far fa-angle-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a class="page-numbers current">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="page-numbers">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="page-numbers style" rel="next"><i class="far fa-angle-right"></i></a></li>
        @else
            <li class="disabled"><span class="page-numbers style"><i class="far fa-angle-right"></i></span></li>
        @endif
    </ul>
@endif
