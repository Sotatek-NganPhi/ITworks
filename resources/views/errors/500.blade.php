@extends('app.layout')

@section('title')
    サーバが応答しません。｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>サーバが応答しません。</span>
            </li>
        </ul>
        <div id="__component">
            <h3>ページがありません</h3>
            <br/>
            <p class="text-center">サーバが応答しません。しばらくたってから、再度アクセスしてください。</p>
            <p class="text-center">お手数をおかけしますが、 <a href="/">ホーム</a> に戻ってから再度お試しください。</p>
            <br/>
            <a href="/" class="confirm">ホームへ戻る</a>
            <p></p>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>サーバが応答しません。</span>
            </li>
        </ul>

    </div>
@endsection