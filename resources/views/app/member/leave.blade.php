@extends('app.layout')

@section('title', '退会する')

<?php
    $crumbs = [
        'crumbs' => [
            ['url' => route('index'), 'name' => $configs["site_name"]],
            ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
            ['name' => '退会する']
        ]
    ];
?>

@section('page_content')
    <div id="page_content">
        @include('app.common.breadcrumbs', $crumbs)
        @include('app.member.header')

        <div id="__component">
            <div id="form">
                <h4 class="bg_orange">退会確認</h4>
                <h5>本当に退会しますか？</h5>
            </div>

            <div align="center">
                <form action="{{ route('member_leave_ok') }}" method="post" >
                    {{ csrf_field() }}
                    <button type="submit" class="confirm">はい。退会します。</button>
                    <span class="cancel">
                        <a href="{{ route('member_home') }}">いいえ。元のページに戻る。</a>
                    </span>
                </form>
            </div>
        </div>

        @include('app.common.breadcrumbs', $crumbs)
    </div>
@endsection