@extends('app.layout')

@section('title')
    IT works
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
                <span>Đăng ký</span>
            </li>
        </ul>

        <div id="__component">
            <h3>Đăng ký</h3>
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
                        <th class="required">Email:</th>
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
                        <th class="required">Mật khẩu:</th>
                        <td>
                            <input class="form-control" name="password" type="password" size="40" value="{{ old('password') }}">
                            (Mật khẩu phải lớn hơn 6 ký tự)
                            @if ($errors->has('password'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">Xác nhận lại mật khẩu</th>
                        <td>
                            <input class="form-control" name="password_confirmation" type="password" size="40" value="{{ old('password_confirmation') }}">
                            (Mật khẩu phải lớn hơn 6 ký tự)
                            @if ($errors->has('password-confirm'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('password-confirm') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">Họ và tên</th>
                        <td>
                            <input placeholder="Họ" class="form-control" name="first_name" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                            <br>
                            <input placeholder="Tên" class="form-control" name="last_name" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">Giới tính: </th>
                        <td>
                            <input type="radio" value="male" name="gender" id="gender-male"
                                {{ old('gender') === 'male' ? 'checked' : '' }}
                            >
                            <label for="gender-male">Nam</label><br>
                            <input type="radio" value="female" name="gender" id="gender-female"
                            {{ old('gender') === 'female' ? 'checked' : '' }}
                            >
                            <label for="gender-female">Nữ</label><br>
                            @if ($errors->has('gender'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="required">Ngày sinh</th>
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
                        <th class="required">Địa chỉ</th>
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
                        <th class="required">Số điện thoại</th>
                        <td>
                            <input class="form-control" name="phone_number" value="{{ old('phone_number') }}" size="40"></input>
                            <!-- @if ($errors->has('phone_number'))
                                <span class="small text-danger show">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif -->
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="hidden" name="provider" value="{{ old('provider') }}">
                <input type="hidden" name="provider_id" value="{{ old('provider_id') }}">
                <input type="submit" value="Gửi" name="submit">
            </form>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Đăng ký</span>
            </li>
        </ul>

    </div>
@endsection
