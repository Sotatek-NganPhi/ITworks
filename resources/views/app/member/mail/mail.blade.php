@extends('app.layout')

@section('title', 'マイページトップ')

@section('page_content')
    <div>
        <div id="page_content">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>メールボックス</span>
                </li>
            </ul>

            @include('app.member.header')

            <div id="__component">

                <div id="form" class="mail-box">
                    <h4 class="bg_orange">メールボックス</h4>
                    <p class="mail-des">
                        <span>件名をクリックするとメールの内容が表示され、返信することができます。</span>
                        <br>
                        <span class="red"><strong>※3ヶ月以上前のメールは自動削除されます。</strong></span>
                        <br>
                        <span class="red">※保存したいメールがある場合、保存アイコンをクリックしてください。保存したメールは自動削除されません。</span>
                    </p>
                    <div class="list">
                        <ul class="nav nav-tabs">
                          <li class="{{ $isInbox ? 'active' : '' }}"><a href="{{ route('mail_inbox') }}">受信箱</a></li>
                          <li class="{{ !$isInbox ? 'active' : '' }}"><a href="{{ route('mail_outbox') }}">送信箱</a></li>
                        </ul>
                        <div class="mail-content">
                            @if($isInbox)
                                <ul class="sub-tab">
                                    <li><a href="{{ route('mail_inbox') }}" class="btn {{ \Request::route()->getName() === 'mail_inbox' ? 'active' : ''}}" >すべて</a></li>
                                    <li><a href="{{ route('mail_inbox_unread') }}" class="btn {{ \Request::route()->getName() === 'mail_inbox_unread' ? 'active' : ''}}" >未読</a></li>
                                    <li><a href="{{ route('mail_inbox_favorite') }}" class="btn {{ \Request::route()->getName() === 'mail_inbox_favorite' ? 'active' : ''}}" >お気に入り</a></li>
                                </ul>
                            @else
                                <ul class="sub-tab">
                                    <li><a href="{{ route('mail_outbox') }}" class="btn {{ \Request::route()->getName() === 'mail_outbox' ? 'active' : ''}}" >すべて</a></li>
                                    <li><a href="{{ route('mail_outbox_favorite') }}" class="btn {{ \Request::route()->getName() === 'mail_outbox_favorite' ? 'active' : ''}}" >お気に入り</a></li>
                                </ul>
                            @endif
                            @yield('mail_content')
                        </div>
                    </div>
                </div>
            </div>

            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>メールボックス</span>
                </li>
            </ul>
        </div>
    </div>
@endsection