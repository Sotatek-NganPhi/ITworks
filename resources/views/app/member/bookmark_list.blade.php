@extends('app.layout')

@section('title')
    クリップリスト｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div>
        <div id="page_content">
            @include('app.common.breadcrumbs', ['crumbs' => [
                ['url' => route('index'), 'name' => $configs["site_name"]],
                ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                ['url' => '#', 'name' => 'クリップ情報']
            ]])
            @include('app.member.header')
            <div id="__component">
                <h3 class="bg_orange">クリップボード</h3>
                <p></p>
                <p>検索結果からクリップ(保存)した情報を表示します。</p>

                <p>お仕事情報を検索して「クリップする」のリンクをクリックすると気に入ったお仕事情報を集めることが出来ます。</p>

                <p>掲載期間を過ぎた仕事情報は自動削除されます。</p>
            </div>
            @if($jobs->total() > 0)
                <div id="search">
                    <div class="count-result">
                        <p class="text">クリップ件数は<span class="count">{{$jobs->total()}}</span>件です。</p>
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
                                <input type="submit" class="_btn_delete" value="▲このクリップを削除する">
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="search">
                <div class="count-result">
                    <p class="text">クリップ件数は<span class="count">{{$jobs->total()}}</span>件です。</p>
                </div>
                @if($jobs->total() > 0)
                    @include('app.member.job_list.pagination')
                @endif
            </div>
            @include('app.common.breadcrumbs', ['crumbs' => [
                ['url' => route('index'), 'name' => $configs["site_name"]],
                ['url' => route('member_home'), 'name' => 'MY PAGE TOP'],
                ['url' => '#', 'name' => 'クリップ情報']
            ]])
        </div>
    </div>
@endsection