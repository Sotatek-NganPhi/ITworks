@extends('app.layout')

@section('title')
    Không có trang nào｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Không có trang nào</span>
            </li>
        </ul>
        <div id="__component">
            <h3>Không có trang nào</h3>
            <br/>
            <p class="text-center">Trang này không tồn tại.</p>
            <p class="text-center">Xin lỗi đã làm phiền bạn, <a href="/">Trang chủ</a> Vui lòng quay lại và thử lại sau.</p>
            <br/>
            <a href="/" class="confirm">Trở về trang chủ.</a>
            <p></p>
        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>Không có trang nào</span>
            </li>
        </ul>

    </div>
@endsection