@extends('app.layout')

@section('title')
    会員登録｜{{$configs["pc_site_title"]}}
@endsection

@section('vue-js')
    <script src="/js/app/home/register_form.js"></script>
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>会員登録</span>
            </li>
        </ul>

        <div id="__component">
            <h3>会員登録</h3>

            <p class="text">マイページ作成に必要な、基本情報のご登録となります。<br> ご希望のID、パスワードをご入力下さい。</p>
            @if (session('messages'))
                <div class="alert alert-success">
                    {{ session('messages') }}
                </div>
            @endif
            <form class="app_form" id="register_from" role="form" method="POST" action="{{ route($formAction) }}">
                {{ csrf_field() }}
                <table>
                    <tbody>
                    <tr>
                        <th class="required">ログインID</th>
                        <td>
                            <input  {{ $formAction === 'profile.update' ? 'disabled' : '' }} class="form-control" name="email" value="{{ old('email') }}" size="40">
                            @if ($errors->has('email'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">パスワード</th>
                        <td>
                            <input class="form-control" name="password" type="password" size="40" value="{{ old('password') }}">
                            (半角英数字6文字以上)
                            @if ($errors->has('password'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">パスワード(確認用)</th>
                        <td>
                            <input class="form-control" name="password_confirmation" type="password" size="40" value="{{ old('password_confirmation') }}">
                            (半角英数字6文字以上)
                            @if ($errors->has('password-confirm'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('password-confirm') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">氏名</th>
                        <td>
                            <input placeholder="姓" class="form-control" name="first_name" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                            <br>
                            <input placeholder="名" class="form-control" name="last_name" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">フリガナ</th>
                        <td>
                            <input placeholder="姓" class="form-control" name="first_name_phonetic" value="{{ old('first_name_phonetic') }}">
                            @if ($errors->has('first_name_phonetic'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('first_name_phonetic') }}</strong>
                                </span>
                            @endif
                            <br>
                            <input placeholder="名" class="form-control" name="last_name_phonetic" value="{{ old('last_name_phonetic') }}">
                            @if ($errors->has('last_name_phonetic'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('last_name_phonetic') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">性別</th>
                        <td>
                            <input type="radio" value="male" name="gender" id="gender-male"
                                {{ old('gender') === 'male' ? 'checked' : '' }}
                            >
                            <label for="gender-male">男性</label><br>
                            <input type="radio" value="female" name="gender" id="gender-female"
                            {{ old('gender') === 'female' ? 'checked' : '' }}
                            >
                            <label for="gender-female">女性</label><br>
                            @if ($errors->has('gender'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">生年月日</th>
                        <td>
                            <date-picker name="birthday" locale="ja" value="{{ old('birthday') }}" format="YYYY-MM-DD"></date-picker>
                            @if ($errors->has('birthday'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">郵便番号</th>
                        <td>
                            <postal-code name="postal_code" value="{{  old('postal_code') }}"></postal-code>
                            @if ($errors->has('postal_code'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('postal_code') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">住所</th>
                        <td>
                            <input class="form-control" name="address" value="{{ old('address') }}" size="40">
                            @if ($errors->has('address'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">電話番号</th>
                        <td>
                            <phone-input name="phone_number" value="{{ old('phone_number') }}" size="40"></phone-input>
                            @if ($errors->has('phone_number'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @if($formAction === 'register')
                        <tr>
                            <th class="norequired">当サイトをどこでお知りになりましたか？</th>
                            <td>
                                @foreach($referralSources as $referralSource)
                                    <label style="margin-right: 20px;">
                                        <input style="margin-top: 0;"
                                               type="checkbox"
                                               name="referral_sources[]"
                                               value="{{$referralSource['key']}}"
                                                {{ in_array($referralSource['key'], old('referral_sources', []))?  'checked' : '' }}
                                        >
                                        {{$referralSource['value']}}
                                    </label>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="norequired">紹介者のお名前または企業番号をご入力下さい（お友達や企業からのご紹介にチェックいただいた方）</th>
                            <td>
                                <input class="form-control" name="referral_code" value="{{ old('referral_code') }}" size="40">
                                @if ($errors->has('referral_code'))
                                    <span class="small text-danger show">
                                            <strong>{{ $errors->first('referral_code') }}</strong>
                                        </span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th class="norequired">LINE ID</th>
                        <td>
                            <input class="form-control" name="line_id" value="{{ old('line_id') }}" size="40">
                            @if ($errors->has('line_id'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('line_id') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">仕事情報メール(希望条件に合ったメルマガ)</th>
                        <td>
                            <input type="radio" value="1" name="mail_receivable" id="receive"
                                {{ old('mail_receivable') ? 'checked' : '' }}
                            >
                            <label for="receive">受け取る</label><br>
                            <input type="radio" value="0" name="mail_receivable" id="not-receive"
                                {{ !old('mail_receivable') ? 'checked' : '' }}
                            >
                            <label for="not-receive">受け取らない</label><br>
                            @if ($errors->has('mail_receivable'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('mail_receivable') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="hidden" name="provider" value="{{ old('provider') }}">
                <input type="hidden" name="provider_id" value="{{ old('provider_id') }}">
                <input type="submit" value="確認" name="submit">
                <div>
                    <a href="{{ route('auth.provider', 'google') }}" class="btn">
                        <i class="fa fa-google-plus"></i> Google
                    </a>
                    <a href="{{ route('auth.provider', 'facebook') }}" class="btn">
                        <i class="fa fa-facebook"></i> Facebook
                    </a>
                    <a href="{{ route('auth.provider', 'yahoojp') }}" class="btn">
                        <i class="fa fa-yahoo"></i> Yahoo! JAPAN
                    </a>
                </div>
            </form>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>会員登録</span>
            </li>
        </ul>

    </div>
@endsection
