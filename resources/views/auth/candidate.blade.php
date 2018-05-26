@extends('app.layout')

@section('title')
    Đăng ký｜{{$configs["pc_site_title"]}}
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
            @if(Auth::check())
                <form method="get" action="{{route('logout')}}" class="form-logout">
                    <button type="submit" class="btn-logout">Đăng xuất</button>
                </form>
            @endif
        </ul>

        <div id="__component">
            <h3>Đăng ký</h3>
            @if (count($errors) > 0)
                <div>
                    <ul class="errors">
                        @foreach ($errors as $error)
                            @foreach($error as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="app_form" id="register_from" method="POST" action="{{ route(old('formAction')) }}">
                {{ csrf_field() }}
                <input hidden name="formAction" value="{{old('formAction')}}">
                <h4>Hồ sơ</h4>
                <table>
                    <tbody>
                    <tr>
                        <th class="required">Trình độ học vấn</th>
                        <td>
                            <input class="form-control" name="education" value="{{ old('education') }}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">Học tại</th>
                        <td>
                            <input class="form-control" name="final_academic_school" value="{{ old('final_academic_school') }}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">Thời gian tốt nghiệp</th>
                        <td>
                            <date-picker name="graduated_at" locale="ja" value="{{ old('graduated_at') }}" format="YYYY-MM-DD"></date-picker>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                    <tr>
                        <th class="norequired">Ngoại ngữ</th>
                        <td>
                            <input class="form-control" name="language" value="{{ old('language') }}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th class="norequired">Trình độ ngoại ngữ</th>
                        <td>
                            <input class="form-control" name="language_level" value="{{ old('language_level') }}" size="40">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" value="Cập nhật" name="submit">
                <input type="submit" value="Lưu bản nháp" class="draft" name="submit">
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