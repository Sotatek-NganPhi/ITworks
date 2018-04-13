@extends('app.layout')

@section('title')
    説明会入力｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div class="register">
        <ul class="breadcrumb">
            <li>
                <a href="/" title="{{$configs["pc_site_title"]}}">
                    <span>{{$configs["site_name"]}}</span>
                </a>　≫
            </li>
            <li>
                <span>予約完了</span>
            </li>
        </ul>
        @if (Session::has('msg'))
            <div class="alert alert-success">{{ Session::get('msg') }}</div>
            {{ Session::forget('msg')}}
        @endif
        <div class="form">
            <h4>ｓｓに予約完了。</h4>
            <p>説明会への予約が完了しました。</p>
        </div>
    </div>
@endsection