@extends('app.layout')

@section('title', $job->description . '（ID：'. $job->id . '）')

@section('page_content')
    <div id="search">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a><span>Chi tiết công việc</span></a>　≫
            </li>
            <li>
                <span>Lưu việc làm</span>
            </li>
        </ul>
        <div class="list-job">
            <div class="job-view">
                <div class="list_title">
                    <h2><a href="/job/{{$job->id}}">{{$job->description}}</a></h2>
                    <div class="detail"><a href="/job/{{$job->id}}">Chi tiết</a></div>
                </div>
                <div class="__sub_title">
                    <h3>{{$job->company_name}}</h3>
                </div>
                <div class="spec">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th>Điều kiện ứng tuyển</th>
                            <td>{{$job->application_condition}}</td>
                        </tr>
                        <tr>
                            <th>Thời gian nhận hồ sơ</th>
                            <td>{{$job->post_start_date}} - {{$job->post_end_date}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="clear-both"></div>
            </div>
        </div>

        @if(Auth::check())
            <div class="_form">
                <h4>Công việc đã lưu</h4>
                <h5>Công việc này sẽ được lưu vào hồ sơ cá nhân</h5><br>
                <form name="form_login" method="post" action="{{route('add_job_clips', $job->id)}}">
                    {{ csrf_field() }}
                    <input type="submit" class="btn_login" name="Submit" value="Lưu">
                </form>
            </div>
        @else
            <div class="_form">
                <h4>Công việc đã lưu</h4>
                <h5>Nếu bạn đã là thành viên, vui lòng đăng nhập !</h5>
                <div class="_form_action">
                    <form name="form_login" method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @if (session('messages'))
                            <div class="alert alert-success">
                                {{ session('messages') }}
                            </div>
                        @endif
                        <label for="email" class="area">Email：
                            <input name="email" type="email" maxlength="255"
                                   class="input-form {{ $errors->has('email') ? ' has-error' : '' }}" size="20">
                        </label>
                        <label for="password" class="area">Password：
                            <input name="password" type="password"
                                   class="input-form {{ $errors->has('password') ? ' has-error' : '' }}"
                                   maxlength="255" size="20">
                        </label>
                        <input type="submit" name="Submit" class="btn_login"
                               value="Đăng nhập">
                        <a href="#">&gt;&gt;Quên mật khẩu</a>
                        @if (count($errors) > 0)
                            <div>
                                <ul class="errors">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
                <h5>Nếu bạn chưa đăng ký?</h5>
                <div class="regist_box">
                    Nếu bạn đăng ký, bạn có thể lưu trữ thông tin công việc bạn quan tâm hoặc bạn có thể tạo trong hồ sơ cá nhân trước!<br>
                    <p class="center __btn">
                        <a class="btn_register" href="{{ route('register') }}">Đăng ký thành viên</a>
                    </p>
                </div>
            </div>
        @endif
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <a><span>Chi tiết công việc</span></a>　≫
            </li>
            <li>
                <span>Lưu việc làm</span>
            </li>
        </ul>
    </div>
@endsection