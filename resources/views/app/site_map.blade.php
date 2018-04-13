@extends('app.layout')

@section('title')
サイトマップ｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>サイトマップ</span>
            </li>
        </ul>

        <div id="__component">
            @foreach($jobCounts as $key => $criterias)
            <div class="sitemap cf">
                <h5>{{ $key }}</h5>
                <ul>
                @foreach($criterias as $criteria)
                    <li><a href="{{$criteria['link']}}">{{$criteria['name']}}({{$criteria['jobCount']}})</a></li>
                @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>サイトマップ</span>
            </li>
        </ul>

    </div>
@endsection