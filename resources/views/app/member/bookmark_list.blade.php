@extends('app.layout')

@section('title')
    Công việc đã lưu｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div>
        <div id="page_content">
            @include('app.common.breadcrumbs', ['crumbs' => [
                ['url' => route('index'), 'name' => $configs["site_name"]],
                ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                ['url' => '#', 'name' => 'Công việc đã lưu']
            ]])
            @include('app.member.header')
            <div id="__component">
                <h3 class="bg_orange">Danh sách công việc đã lưu</h3>
                <p>Thông tin công việc sau thời gian đăng tuyển sẽ tự động xóa.</p>
            </div>
            @if($jobs->total() > 0)
                <div id="search">
                    <div class="count-result">
                        <p class="text">Số lượng công việc là <span class="count">{{$jobs->total()}}</span></p>
                    </div>
                    @include('app.member.job_list.pagination')
                </div>
            @endif
            <div>
                @foreach($jobs as $job)
                    <div class="job-view">
                        @include('app.member.job_list.job_cell')
                        <div class="_form_delete">
                            <form method="POST" action="{{route('delete_bookmark', $job->id)}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="_btn_delete" value="Xóa
">
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="search">
                <div class="count-result">
                    <p class="text">Số lượng công việc là <span class="count">{{$jobs->total()}}</span></p>
                </div>
                @if($jobs->total() > 0)
                    @include('app.member.job_list.pagination')
                @endif
            </div>
            @include('app.common.breadcrumbs', ['crumbs' => [
                ['url' => route('index'), 'name' => $configs["site_name"]],
                ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                ['url' => '#', 'name' => 'Công việc đã lưu']
            ]])
        </div>
    </div>
@endsection