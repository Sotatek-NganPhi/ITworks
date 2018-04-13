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
                    <a title="インタビューへ移動" href="/{{$keyRegion}}/interview/cat/all" class="post post-interview-archive">
                        <span property="name">インタビュー</span>
                    </a>
                </span>
                @if(count($interviews))
                    &gt;
                    <span >
                        <a title="" href="/{{$keyRegion}}/interview/cat/{{ $interviews['category_interview_id'] }}" class="taxonomy interview_cat">
                            <span property="name">{{ $interviews['categoryInterview']['title'] }}</span>
                        </a>
                    </span>
                @endif
                @if(isset($interviews['title']))
                    &gt;
                    <span>
                        <span property="name">{{ $interviews['title'] }}</span>
                    </span>
                @endif
            </div>
        </div>
        <main id="main">
            @if(count($interviews))
                <article>
                    <section>
                        <h1>
                            <span class="cat">{{ $interviews['categoryInterview']['title'] }}</span>
                            {{ $interviews['title'] }}
                        </h1>
                        <div class="edit">
                            <figure class="clearfix">
                                <img width="795" height="518" src="{{ $interviews['picture'] }}" class="attachment-thumb_795-518 size-thumb_795-518" alt="">
                                <div class="text">
                                    <time>{{ $interviews['date'] }}</time>
                                    <p>{{ $interviews['company_name'] }}</p>
                                    <p>{{ $interviews['interviewer'] }}　インタビュー</p>
                                </div>
                            </figure>
                            <div class="edit">
                                {!! $interviews['content'] !!}
                            </div>
                            <div class="company_inner">
                                <h2>企業情報</h2>
                                <div class="text">
                                    <p>{{ $interviews['company_name'] }}<br>
                                    {{ $interviews['company_description'] }}</p>
                                    <a href="{{ $interviews['company_url'] }}" target="_blank">{{ $interviews['company_url'] }}</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
            @else
                <p style="color: red; font-size: 16px">No interview.</p>
            @endif
        </main>
    </div>
</div>
@endsection
