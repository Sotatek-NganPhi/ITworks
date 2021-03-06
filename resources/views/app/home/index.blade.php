@extends('app.layout')

@section('title')

@section('script')
    <script type="text/javascript">
      $(document).ready(function () {
        $('form').submit(function () {
          $('form *').filter(':input').each(function () {
            if ($(this).val() == '')
              $(this).prop('disabled', true)
          })
        })
      })
    </script>
@endsection

@section('vue-js')
    <script src="/js/app/home/main.js"></script>
@endsection

@section('page_content')
    <div id="home">
        <div class="menu_home_page">
        <div class="area">
            <ol>
                @foreach($regions as $region)
                    <li class="{{ preg_match('/' . $region->key .'/i', Request::url()) ? 'active' : '' }}"
                        style="width: {{ 100/count($regions) }}%;">
                        <a href="{{ route('home', $region->key) }}"
                           title="{{$region->key}}">{{$region->name}}</a>
                    </li>
                @endforeach
            </ol>
        </div>
        </div>
        <div class="bannerArea">
            <div id="bannerImage" class="bannerImage">
                <a href="#"><img src="/images/img_top.jpg"></a>
            </div>
        </div>
        <div class="home_bg">
            <div class="home_body" id="home_body">
                <div class="body">
                    <div class="content">
                        <div class="bg-topics">
                            <div class="topics">
                                <p class="title-topic">TOPICS</p>
                                <div class="area-content-topic">
                                    <span class="content-topic">
                                        <marquee direction="left" behavior="scroll" loop="1000">
                                            <span>
                                            Chào mừng các bạn đến với trang web tìm kiếm việc làm cho sinh viên công nghệ thông tin ITworks.
                                            </span>
                                        </marquee>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if(count($urgentJobs))
                        <div class="body-bottom body-odd">
                            <div class="conscription">
                                @include('app.home.hurry')
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="side">
                    @include('app.home.side')
                </div>
            </div>
        </div>
        @if(count($attentionJobs))
         <div class="body-bottom body-even">
            <div class="recommendation">
                @include('app.home.attention')
            </div>
        </div>
        @endif
    </div>
@endsection
