@extends('app.layout')

@section('title')
    ログイン｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>ログイン</span>
            </li>
        </ul>

        <div id="__component">
            <h3>ログイン</h3><br />
            @if (session('messages'))
                <div class="alert alert-success">
                    {{ session('messages') }}
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        @include('auth.resend_verification')
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-offset-2 col-sm-2">メールアドレス:</label>
                    <div class="col-sm-5">
                        <input name="email" class="form-control" type="email">
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-offset-2 col-sm-2">パスワード:</label>
                    <div class=" col-sm-5">
                        <input name="password" type="password" class="form-control">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-offset-2 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>  次回から自動でログインする
                            </label>
                            | <a href="{{ route('password.request') }}">パスワードを忘れた方はこちら</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
                        <input type="submit" style="background: #F15A24" class="btn btn-sm btn-warning" value="ログイン">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
                        <p>まだ会員でない方は<a href="{{ route('register') }}">こちら</a></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
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
                </div>
            </form>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>ログイン</span>
            </li>
        </ul>
    </div>
@endsection