@extends('app.layout')

@section('title')
    検索条件管理
@endsection

@section('vue-js')
    <script src="/js/app/member/list_search_condition.js"></script>
@endsection

@section('page_content')
    <div>
        <div id="page_content">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <a href="{{route('member_home')}}"><span>MY PAGE TOP</span></a>　≫
                </li>
                <li>
                    <a href="#"><span>検索条件管理</span></a>
                </li>
            </ul>
            @include('app.member.header')
            <div id="__component">
                <h3 class="bg_orange">検索条件管理</h3>
                <p></p>
                <p>以前に登録した、検索条件を管理します。よく使う項目は、まとめて管理すると便利ですよ！</p>
                <div id="list_search_condition">
                    <template>
                        <form class="inquiry">
                            <template v-for="(row, index) in rows">
                                <h5>検索条件 @{{ index + 1 }}</h5>
                                <search-condition-item
                                        :free_word="row.free_word"
                                        :category_id="row.category_id"
                                        :prefecture_id="row.prefecture_id"
                                        :ward_id="row.ward_id"
                                        :line_id="row.line_id"
                                        :station_id="row.station_id"
                                        :employment_mode_id="row.employment_mode_id"
                                        :merits="row.merits">
                                </search-condition-item>
                                <div align="center">
                                    <input type="button" class="confirm" value="　　上記の条件で検索する　　"
                                           @click="openPageSearch(row.url)">　
                                    <input type="button" class="cancel" value="この条件を削除"
                                           @click="removeSearchCondition(row.id)">
                                </div>
                            </template>
                        </form>
                        <template v-if="!rows.length && isLoading">
                        <h5 class="text-left">登録されている検索条件はございません</h5>
                        </template>
                    </template>
                </div>
            </div>
            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
                </li>
                <li>
                    <a href="{{route('member_home')}}"><span>MY PAGE TOP</span></a>　≫
                </li>
                <li>
                    <a href="#"><span>検索条件管理</span></a>
                </li>
            </ul>
        </div>
    </div>
@endsection