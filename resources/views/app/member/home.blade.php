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
                    <span>MY PAGE TOP</span>
                </li>
            </ul>

            @include('app.member.header')

            <div id="__component">

                <div id="form">
                    <h4 class="bg_orange">{{Auth::user()->first_name}}様のマイページ</h4>
                    <h5>マイページでは、 下記の各種設定が出来ます。是非ご活用ください。</h5>


                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th>
                                <a href="{{route('profile.edit')}}">基本情報の確認・修正</a>
                            </th>
                            <td>ご登録いただいている基本情報を設定･変更します。</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('candidate.edit')}}">詳細情報の確認・修正</a>
                            </th>
                            <td>ご希望メール配信を、希望条件で絞り込むことができます。</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('member_clip_list')}}">クリップ情報</a>
                            </th>
                            <td>気になる情報をクリップしておけば、保存された情報を一覧で表示・管理できます。</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('resume_register')}}">WEB履歴書の確認</a>
                            </th>
                            <td>WEB履歴書の確認であらかじめ情報を入力しておけば、エントリー時の入力の手間が省けます。<br>
                                複数応募をしたい時になんども同じ情報が手間という方におすすめです。<br>
                                WEB履歴書は詳細情報の確認・修正から更新することができます
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('member_application_list')}}">応募履歴管理</a>
                            </th>
                            <td>過去に応募した情報を表示・管理します。</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('mail_inbox')}}">メールボックス</a>
                            </th>
                            <td>応募後、担当者からのメールを確認、返信できます。</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('member_leave_confirm')}}">退会する</a>
                            </th>
                            <td>当サイトの退会手続きを行います。</td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>

            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>MY PAGE TOP</span>
                </li>
            </ul>
        </div>
    </div>
@endsection