@extends('app.layout')

@section('title')
    お役立ちコンテンツ｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="navi_video">
        <div class="menu_home_page">
            <div class="area">
                <ol>
                    @foreach($regions as $regionSub)
                        <li class="{{ preg_match('/' . $regionSub->key .'/i', Request::url()) ? 'active' : '' }}"
                            style="width: {{ 100/count($regions) }}%;">
                            <a href="{{ route('home', $regionSub->key) }}"
                               title="{{$regionSub->key}}">{{$regionSub->name}}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a> ≫
            </li>
            <li>
                <a href="{{ route('home',  $region['key']) }}"><span>{{  $region['name'] }}</span></a> ≫
            </li>
            <li>
                <span>お役立ちコンテンツ</span>
            </li>
        </ul>

        <div id="video-list">
            <div class="page-title">
                <h1><strong>お役立ちコンテンツ</strong></h1>
                <div class="txt">50歳からの新たな仕事に就くために、役立つ情報盛りだくさん！</div>
            </div>
            <div class="page-content">
                @foreach($videos as $video)
                    {{--<div class="container">--}}
                        <div class="row video-cell">
                            <div class="col-md-6 image">
                                <img class="video-thumbnail" src="{{ $video->thumbnail }}">
                            </div>
                            <div class="col-md-6 information">
                                <div class="name"><a href="{{ route('video', [$region['key'], $video->id]) }}">{{ $video->name }}</a></div>
                                <div class="description">{{ $video->description }}</div>
                                <div class="btnDetail">
                                    <a href="{{ route('video', [$region['key'], $video->id]) }}">詳細はこちら</a>
                                </div>
                            </div>
                        </div>
                    {{--</div>--}}
                @endforeach
            </div>
            <div class="control">
                <div class="pagination">
                    <p>
                        全{{$videos->currentPage()}}件/ {{$videos->lastPage()}}　

                        @if($videos->currentPage() < 2)
                            <span class="disable">&lt;&lt;前の1ページ</span>
                        @else
                            <span class="active"><a
                                        href="{{$videos->previousPageUrl()}}">&lt;&lt;前の1ページ</a></span>
                        @endif
                        @if($videos->lastPage() > 10)
                            @if($videos->currentPage() < $videos->lastPage() - 9)
                                @for($i = $videos->currentPage(); $i <= $videos->currentPage() + 9; $i ++)
                                    <span class="{{$videos->currentPage() == $i ? 'active' : 'disable'}}"><a
                                                href="{{$videos->url($i)}}">[<span
                                                    class="per-page">{{$i}}</span>]</a></span>
                                @endfor
                            @else
                                @for($i = $videos->total() - 9; $i<= $videos->total(); $i ++)
                                    <span class="{{$videos->currentPage() == $i ? 'active' : 'disable'}}"><a
                                                href="{{$videos->url($i)}}">[<span
                                                    class="per-page">{{$i}}</span>]</a></span>
                                @endfor
                            @endif
                        @else
                            @for($i = 1; $i <= $videos->lastPage(); $i ++)
                                <span class="{{$videos->currentPage() == $i ? 'active' : 'disable'}}"><a
                                            href="{{$videos->url($i)}}">[<span
                                                class="per-page">{{$i}}</span>]</a></span>
                            @endfor
                        @endif
                        @if($videos->currentPage() == $videos->lastPage())
                            <span class="disable">次の1ページ&gt;&gt;</span>
                        @else
                            <span class="active"><a
                                        href="{{$videos->nextPageUrl()}}">次の1ページ&gt;&gt;</a></span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a> ≫
                </li>
                <li>
                    <a href="{{ route('home',  $region['key']) }}"><span>{{  $region['name'] }}</span></a> ≫
                </li>
                <li>
                    <span>お役立ちコンテンツ</span>
                </li>
            </ul>

    </div>
@endsection