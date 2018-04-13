<div class="control">
    <div class="pagination">
        <p>
            全{{$jobs->currentPage()}}件/ {{$jobs->lastPage()}}　

            @if($jobs->currentPage() < 2)
                <span class="disable">&lt;&lt;前の1ページ</span>
            @else
                <span class="active"><a
                            href="{{$jobs->previousPageUrl()}}">&lt;&lt;前の1ページ</a></span>
            @endif
            @if($jobs->lastPage() > 10)
                @if($jobs->currentPage() < $jobs->lastPage() - 9)
                    @for($i = $jobs->currentPage(); $i <= $jobs->currentPage() + 9; $i ++)
                        <span class="{{$jobs->currentPage() == $i ? 'active' : 'disable'}}"><a
                                    href="{{$jobs->url($i)}}">[<span
                                        class="per-page">{{$i}}</span>]</a></span>
                    @endfor
                @else
                    @for($i = $jobs->total() - 9; $i<= $jobs->total(); $i ++)
                        <span class="{{$jobs->currentPage() == $i ? 'active' : 'disable'}}"><a
                                    href="{{$jobs->url($i)}}">[<span
                                        class="per-page">{{$i}}</span>]</a></span>
                    @endfor
                @endif
            @else
                @for($i = 1; $i <= $jobs->lastPage(); $i ++)
                    <span class="{{$jobs->currentPage() == $i ? 'active' : 'disable'}}"><a
                                href="{{$jobs->url($i)}}">[<span
                                    class="per-page">{{$i}}</span>]</a></span>
                @endfor
            @endif
            @if($jobs->currentPage() == $jobs->lastPage())
                <span class="disable">次の1ページ&gt;&gt;</span>
            @else
                <span class="active"><a
                            href="{{$jobs->nextPageUrl()}}">次の1ページ&gt;&gt;</a></span>
            @endif
        </p>
    </div>
</div>