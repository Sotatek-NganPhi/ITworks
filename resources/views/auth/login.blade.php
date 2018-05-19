@extends('app.layout')

@section('title')
    Đăng nhập
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Đăng nhập</span>
            </li>
        </ul>

        <div id="__component">
            <h3>Đăng nhập</h3><br />
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
                    <label class="control-label col-sm-offset-2 col-sm-2">Email:</label>
                    <div class="col-sm-5">
                        <input name="email" class="form-control" type="email">
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label col-sm-offset-2 col-sm-2">Mật khẩu:</label>
                    <div class=" col-sm-5">
                        <input name="password" type="password" class="form-control">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-offset-2 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>  Ghi nhớ đăng nhập.
                            </label>
                            | <a href="{{ route('password.request') }}">Quên mật khẩu</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
                        <input type="submit" style="background: #F15A24" class="btn btn-sm btn-warning" value="Đăng nhập">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
                        <p>Nếu bạn chưa là thành viên, xin đăng ký<a href="{{ route('register') }}"> ở đây</a></p>
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
                    </div>
                </div>
            </form>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Đăng nhập</span>
            </li>
        </ul>
    </div>
@endsection