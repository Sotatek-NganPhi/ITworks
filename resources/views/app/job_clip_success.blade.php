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

        <div class="_form">
            <h4>Hoàn tất việc lưu công việc</h4>
            <h5>Bạn có thể xem thông tin tại My page!</h5><br>
            <a class="btn_login" href="{{route('member_clip_list')}}">Xem My page</a>
        </div>

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