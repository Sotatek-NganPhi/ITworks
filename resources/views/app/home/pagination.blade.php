@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="paginations">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;前の1ページ</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;前の1ページ</a></li>
            @endif

            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="disabled">[ <span>{{ $element }}</span> ]</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active my-active">[ <span>{{ $page }}</span> ]</li>
                        @else
                            <li><a href="{{ $url }}">[ {{ $page }} ]</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">>次の1ページ&raquo;</a></li>
            @else
                <li class="disabled"><span>次の1ページ&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif