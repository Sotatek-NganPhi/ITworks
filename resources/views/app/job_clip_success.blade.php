@extends('app.layout')

@section('title', $job->description . '（ID：'. $job->id . '）｜ホーム')

@section('page_content')
    <div id="search">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a><span>求人詳細</span></a>　≫
            </li>
            <li>
                <span>携帯に送る</span>
            </li>
        </ul>

        <div class="_form">
            <h4>クリップ完了</h4>
            <h5>クリップした情報はマイページからご覧いただけます！</h5><br>
            <a class="btn_login" href="{{route('member_clip_list')}}">マイページを見る</a>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a><span>求人詳細</span></a>　≫
            </li>
            <li>
                <span>携帯に送る</span>
            </li>
        </ul>
    </div>
@endsection