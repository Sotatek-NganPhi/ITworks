@extends('app.layout')

@section('title', "キャンペーンページ｜{$configs['site_name']}")

@section('page_content')
<div id="home">
    <div class="menu_home_page">
        <div class="area">
            <ol>
                @foreach($regions as $region)
                    <li class="{{ preg_match('/' . $region->key .'/i', Request::url()) ? 'active' : '' }}"
                        style="width: {{ 100/count($regions) }}%;">
                        <a href="{{ route('home', $region->key) }}"
                           title="{{$region->key}}">{{$region->name}}</a>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
    <div class="content-interview">
        <div class="breadcrumbs">
            <div>
                <span>
                    <a title="{{$configs['pc_site_title']}}" href="/" class="home">
                        <span property="name">{{$configs['site_name']}}</span>
                    </a>
                </span> &gt;
                <span>
                    @if(!$isAll)
                       <a title="インタビューへ移動" href="/{{$keyRegion}}/interview/cat/all" class="post post-interview-archive">
                            <span property="name">インタビュー</span>
                        </a>
                    @else
                        <span property="name">インタビュー</span>
                    @endif
                </span>
                @if(!$isAll)
                    &gt;
                    <span >
                        <span property="name">{{ $interviewPage[0]['cat_title'] }}</span>
                    </span>
                @endif
            </div>
        </div>
        <main id="main">
            <article class="interview">
                <div class="inner archive">
                    <h1>インタビュー</h1>
                    <ul class="list">
                        @if(count($interviewPage))
                            @foreach($interviewPage as $key => $interview)
                                <li class="matchHeight" style="height: 486px;">
                                    <a href="/{{$keyRegion}}/interview/{{ $interview['id'] }}">
                                        <div class="img">
                                            <img width="335" height="230" src="{{ $interview['thumbnail'] }}" class="attachment-thumb_335-200 size-thumb_335-200 wp-post-image" alt="">
                                        </div>
                                        <p class="cat">{{ $interview['cat_title'] }}</p>
                                        <h3 class="title">{{ str_limit($interview['title'], 15, '...') }}</h3>
                                        <p class="text">{!! str_limit($interview['sub_content'], 90, '…') !!}</p>
                                        <p class="more">詳細はこちら</p>
                                    </a>
                                </li>
                            @endforeach
                            {{ $interviewPage->links('app.home.pagination') }}
                        @else
                            <p style="color: red; font-size: 16px;">No interview.</p>
                        @endif
                    </ul>
                </div>
            </article>
        </main>
    </div>
</div>
@endsection
