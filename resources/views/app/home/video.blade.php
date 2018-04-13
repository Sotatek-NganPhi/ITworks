@if(count($videos))
    <div class="__selection_area">
        <div class="kakko">
            <h3>お役立ちコンテンツ</h3>
        </div>
        <p class="title"><span>USEFUL</span></p>
    </div>
    <div class="row">
        @foreach($videos as $video)
            <div class="col-md-4" style="padding: 0px">
                <div class="thumbnail-section" style="position: relative" @click="playVideo">
                    <img class="play-button" src="{{ URL::to('/') }}/images/icon_play.png">
                    <img class="thumbnail" src="{{ $video->thumbnail }}">
                </div>
                <iframe class="video-frame" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>
                <p class="video-title">
                    <a href="{{ substr(Request::url(), 0, -5) . "/video/" . $video->id }}">{{ $video->name }}</a>
                </p>
            </div>
        @endforeach
    </div>
    <div class="button_wrap">
        <a href="{{ route('video_list', substr(Request::path(), 0, -5)) }}" class="button"><p>お役立ちコンテンツをもっと見る</p></a>
    </div>

@endif