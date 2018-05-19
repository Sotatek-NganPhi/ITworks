<ul class="breadcrumb">
    @foreach($crumbs as $crumb)
    <li>
        @if(isset($crumb['url']))
            <a href="{{$crumb['url']}}">
        @endif
            <span>{{$crumb['name']}}</span>
        @if(isset($crumb['url']))
            </a>
        @endif
        @unless($loop->last)
            ≫
        @endunless
    </li>
    @endforeach
</ul>