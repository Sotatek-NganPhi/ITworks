@extends('app.layout')

@section('title')
    応募履歴管理｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div>
        <div id="page_content">
            @include('app.common.breadcrumbs', ['crumbs' => [
                ['url' => route('index'), 'name' => $configs["site_name"]],
                ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                ['url' => '#', 'name' => '応募履歴管理']
            ]])
            @include('app.member.header')
            <div id="__component">
                <h3 class="bg_orange">応募する</h3>
                <div class="applied-job">
                    <h5><span class="count">{{$jobs->total()}}</span>件のお仕事に応募しています。</h5>
                </div>
            </div>
            @if($jobs->total() > 0)
                <div id="search">
                    <div class="count-result">
                        <p class="text">該当の<span class="count">{{$jobs->total()}}</span>件を表示します。</p>
                    </div>
                    @include('app.member.job_list.pagination')
                </div>
            @endif
            <div>
                @foreach($jobs as $job)
                    <div class="job-view">
                        @include('app.member.job_list.job_cell')
                    </div>
                @endforeach
            </div>
            <div id="search">
                <div class="count-result">
                    <p class="text">該当の<span class="count">{{$jobs->total()}}</span>件を表示します。</p>
                </div>
                @if($jobs->total() > 0)
                    @include('app.member.job_list.pagination')
                @endif
            </div>
            @include('app.common.breadcrumbs', ['crumbs' => collect([
                ['url' => route('index'), 'name' => $configs["site_name"]],
                ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                ['url' => '#', 'name' => '応募履歴管理']
            ])])
        </div>
    </div>
@endsection