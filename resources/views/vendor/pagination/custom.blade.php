@if ($paginator->hasPages())
<div class="themesflat-pagination clearfix center">
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span class="page-numbers style"><i class="far fa-angle-left"></i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="page-numbers style"><i class="far fa-angle-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><span class="page-numbers">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="page-numbers current">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="page-numbers">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="page-numbers style"><i class="far fa-angle-right"></i></a></li>
        @else
            <li><span class="page-numbers style"><i class="far fa-angle-right"></i></span></li>
        @endif
    </ul>
</div>
@endif
