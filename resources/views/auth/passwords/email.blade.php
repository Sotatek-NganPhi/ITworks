@extends('app.layout')

@section('title')
    Đặt lại mật khẩu｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Đặt lại mật khẩu</span>
            </li>
        </ul>
        <div id="__component">
            <h3>Đặt lại mật khẩu</h3>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <h5>Xác nhận ID đăng nhập và đặt lại mật khẩu.</h5>
            <br>
            <p class="col-md-10 col-md-offset-1">
            Vui lòng nhập địa chỉ email đăng ký trong {{$configs["site_name"]}} trong hộp email và click Submit.<br />
            Một email có chứ URL đặt lại mật khẩu sẽ được gửi đến email đó.<br />
            </p>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Email đăng ký :</label>

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
                            Submit
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
                <span>Đặt lại mật khẩu</span>
            </li>
        </ul>

    </div>
@endsection
