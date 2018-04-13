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
                <a href="{{ route('home', $region['key']) }}"><span>{{ $region['name'] }}</span></a> ≫
            </li>
            <li>
                <a href="{{ route('video_list', $region['key']) }}"><span>お役立ちコンテンツ</span></a> ≫
            </li>
            <li>
                <span>{{ $video->name }}</span>
            </li>
        </ul>

        <div id="video-detail">
            <div class="page-title">
                <h1><strong>お役立ちコンテンツ</strong></h1>
                <div class="txt">50歳からの新たな仕事に就くために、役立つ情報盛りだくさん！</div>
            </div>
            <div class="page-detail">
                <div class="name-video">{{ $video->name }}</div>
                <div class="video-section">
                    <div class="thumbnail-section" style="position: relative">
                        <img class="play-button" src="/images/play.png">
                        <img class="thumbnail" src="{{ $video->thumbnail }}">
                    </div>
                    <iframe class="video-frame" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="description">
                    <p>{!! nl2br($video->description) !!}</p>
                </div>
            </div>
        </div>

            <ul class="breadcrumb">
                <li>
                    <a href="/"><span>{{$configs["site_name"]}}</span></a> ≫
                </li>
                <li>
                    <a href="{{ route('home', $region['key']) }}"><span>{{ $region['name'] }}</span></a> ≫
                </li>
                <li>
                    <a href="{{ route('video_list', $region['key']) }}"><span>お役立ちコンテンツ</span></a> ≫
                </li>
                <li>
                    <span>{{ $video->name }}</span>
                </li>
            </ul>

    </div>

    <script>
        $(document).ready(function() {
        $(".thumbnail-section").css("height", $(".video-frame").height());
        $(".thumbnail-section").css("width", $(".video-frame").width());
            $('.thumbnail-section').click(function(){
              $(".thumbnail-section").hide();
              $(".video-frame").show();
              $(".video-frame")[0].src += "?autoplay=1";
            });
          });
    </script>
@endsection