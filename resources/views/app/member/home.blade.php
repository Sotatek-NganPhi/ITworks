@extends('app.layout')

@section('title', 'My page')

@section('page_content')
    <div>
        <div id="page_content">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>MY PAGE TOP</span>
                </li>
            </ul>

            @include('app.member.header')

            <div id="__component">

                <div id="form">
                    <h4 class="bg_orange">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
                    <h5>Tại đây bạn có thể chỉnh sửa mọi thông tin của mình.</h5>


                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th>
                                <a href="{{route('profile.edit')}}">Thông tin cá nhân</a>
                            </th>
                            <td>Bạn có thể thay đổi thông tin cơ bản đã đăng ký.</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('candidate.edit')}}">Hồ sơ cá nhân</a>
                            </th>
                            <td>Bạn có thể sửa đổi hồ sơ cá nhân của mình</td>
                        </tr>

                        <tr>
                            <th>
                                <a href="{{route('member_clip_list')}}">Công việc đã lưu</a>
                            </th>
                            <td>Bạn có thể nhìn thấy các công việc mình đã lưu.</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <span>MY PAGE TOP</span>
                </li>
            </ul>
        </div>
    </div>
@endsection