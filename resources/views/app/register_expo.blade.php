@extends('app.layout')

@section('title')
    説明会入力｜{{$configs["pc_site_title"]}}
@endsection
@section('vue-js')
    <script src="/js/app/home/register_expo.js"></script>
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
                <a href="/expo/{{$expo->id}}/regist"><span>説明会名が入ります。に予約する</span></a>
            </li>
        </ul>
        <div class="form">
            <h4>説明会情報　詳細</h4>
            <table class="expo" border="0" align="center" cellpadding="0" cellspacing="0">
                <tbody>
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
                        <th>掲載終了日</th>
                        <td>{{ date_format(new DateTime($expo->end_date), 'Y-m-d') }}</td>
                    </tr>
                    
                    <tr>
                        <th>説明会名</th>
                        <td>{{ $expo->presentation_name }}</td>
                    </tr>
                    <tr>
                        <th>開催場所</th>
                        <td>{{ $expo->address }}<br><a href="https://goo.gl/maps/qwbJG3uqXf42" target="_blank">マップを確認</a></td>
                    </tr>
                    <tr>
                        <th>開催内容</th>
                        <td>{{ $expo->content }}</td>
                    </tr>
                    
                    <tr>
                        <th>PR</th>
                        <td> {{ $expo->pr }}</td>
                    </tr>
                    
                    
                    <tr>
                        <th>問い合わせ電話</th>
                        <td>{{ $expo->cs_phone }}</td>
                    </tr>
                </tbody>
            </table>
            <h5>説明会予約情報入力フォーム </h5>
            <form method="post" action="/api/expos/{{$expo->id}}/register">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <th class="required">姓　名</th>
                            <td>姓<input size="15" name="surname" value="{{ old('surname') }}"> 　 名<input size="15" name="name" value="{{ old('name') }}"></td>
                        </tr>
                        <tr>
                            <th class="required">フリガナ</th>
                            <td>姓<input size="15" name="surname_phonetic" value="{{ old('surname_phonetic') }}"> 　 名<input size="15" name="name_phonetic" value="{{ old('name_phonetic') }}"></td>
                        </tr>
                        <tr>
                            <th class="required">性　別</th>
                            <td><input type="radio" name="gender" value="0" id="s_5" @if(!old('gender')) checked @endif><label for="s_5">男性</label>　
                                <input type="radio" name="gender" value="1" id="s_6" @if(old('gender')) checked @endif><label for="s_6">女性</label>
                            </td>
                        </tr>
                        <tr>
                            <th class="required">メールアドレス</th>
                            <td>
                                <input size="30" name="email" value="{{ old('email') }}"><br>
                                <span class="small">※携帯メールアドレスの場合は、受信拒否設定は解除してください。<br>※メールアドレスはお間違いないよう、お気をつけください。</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="required">現在の状況</th>
                            <td><select name="current_situation_id" size="1">
                                    <option value="">--Please select--</option>
                                    @forelse ($currentSitation as $option)
                                        <option value="{{$option->id}}" @if(old('current_situation_id') == $option->id) {{ 'selected' }} @endif>{{ $option->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="required">電話番号</th>
                            <td>
                                <div id="register-expo">
                                    <phone-input name="phone_number" value="{{ old('phone_number') }}" size="40"></phone-input>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="required">個人情報保護方針</th>
                            <td>
                                <textarea name="textarea" cols="40" rows="7" readonly="">＜説明会情報の予約フォームに反映されるプライバシーポリシーを記載（UTF-8N、CR+LF）＞</textarea><br>
                                上記、個人情報保護方針に<br>
                                <input type="radio" name="privacy" value="1" id="p_3"  @if(old('privacy')) checked @endif>
                                <label for="p_3">同意する</label>
                                <input type="radio" name="privacy" value="0" id="p_4"  @if(!old('privacy')) checked @endif>
                                <label for="p_4">同意しない</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="expo_id" value="{{ $expo->id}}">
                <input type="hidden" name="dispmove_flg" value="1">
                <input type="submit" value="入力内容の確認">
            </form>
        </div>
        @if ($errors->any())
            <div id="errors" class="alert alert-danger" style="width: 385px; margin: 0 auto;">
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item" style="text-align: left;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection