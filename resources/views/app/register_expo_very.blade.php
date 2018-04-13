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
                <span>説明会名が入ります。に予約する</span>
            </li>
        </ul>
        <div class="form">
            <h4>説明会情報 予約内容の確認</h4>
            <form method="post" action="/api/expos/{{$expo->id}}/register/ok">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="expo" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <th colspan="2" class="hd2">説明会内容</th>
                    </tr>
                    <tr>
                        <th>開催日</th>
                        <td>{{ date_format(new DateTime($expo->date), 'Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>主催</th>
                        <td>{{ $expo->organizer_name }}</td>
                    </tr>
                    <tr>
                        <th>時間</th>
                        <td>{{ $expo->time }}</td>
                    </tr>

                    <tr>
                        <th>説明会名</th>
                        <td>{{ $expo->presentation_name }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="hd2">予約内容</th>
                    </tr>
                    <tr>
                        <th class="required">姓　名</th>
                        <td>{{ $result['surname'] }}</td>
                    </tr>
                    <tr>
                        <th class="required">フリガナ</th>
                        <td>{{ $result['surname_phonetic'] }}</td>
                    </tr>
                    <tr>
                        <th class="required">性　別</th>
                        <td>{{ $result['gender']? '男性' : '女性' }}</td>
                    </tr>
                    <tr>
                        <th class="required">メールアドレス</th>
                        <td>
                            {{ $result['email'] }}
                        </td>
                    </tr>
                    <tr>
                        <th class="required">現在の状況</th>
                        <td>
                            {{ $result['current_situation_id'] }}
                        </td>
                    </tr>
                    <tr>
                        <th class="required">電話番号</th>
                        <td>
                            {{ $result['phone_number'] }}
                        </td>
                    </tr>

                    </tbody>
                </table>
                <input type="hidden" name="expo_id" value="{{ $expo->id }}">
                <input type="hidden" name="surname" value="{{ $result['surname']}}">
                <input type="hidden" name="name" value="{{ $result['name']}}">
                <input type="hidden" name="surname_phonetic" value="{{ $result['surname_phonetic']}}">
                <input type="hidden" name="name_phonetic" value="{{ $result['name_phonetic']}}">
                <input type="hidden" name="full_name_phonetic" value="{{ $result['full_name_phonetic']}}">
                <input type="hidden" name="gender" value="{{ $result['gender']}}">
                <input type="hidden" name="email" value="{{ $result['email']}}">
                <input type="hidden" name="current_situation_id" value="{{ $result['current_situation_id']}}">
                <input type="hidden" name="phone_number" value="{{ $result['phone_number']}}">
                <input type="hidden" name="agreed_to_policy" value="{{ $result['agreed_to_policy']}}">
                <input type="hidden" name="dispmove_flg" value="1">
                <input type="submit" value="予約する">
                <button type="button" onclick="history.go(-1)" class="btn">戻る</button>
                <br>
                ※予約内容について、メールでのご案内はいたしませんので
                <br>
                本内容が必要な方は、本画面を印刷して保存しておくことをおすすめします。
            </form>
        </div>
    </div>
@endsection