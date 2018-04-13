@extends('app.layout')

@section('title')
    パスワード再設定｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>パスワード再設定</span>
            </li>
        </ul>
        <div id="__component">
            <h3>パスワード再設定</h3>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <h5>ログインIDの確認および、パスワードの再設定を行います。</h5>
            <br>
            <p class="col-md-10 col-md-offset-1">
            以下のメールアドレス入力欄に、{{$configs["site_name"]}}に登録しているメールアドレスをご入力の上、【送信する】をクリックしてください。<br />
            メールアドレスの確認後、そのメールアドレス宛に以下を記載したメールが自動送信されます。<br />
            ・パスワード再設定用URL<br />
            </p>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">登録時のメールアドレス：</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary bg_orange">
                            送信する
                        </button>
                    </div>
                </div>
            </form>

        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>パスワード再設定</span>
            </li>
        </ul>

    </div>
@endsection
