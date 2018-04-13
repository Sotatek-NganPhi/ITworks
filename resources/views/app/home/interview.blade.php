<div class="inner">
    <h2>企業インタビュー</h2>
    <ul>
        @foreach ($interviewHome as $key => $interview)
            <li>
                <a href="/{{$keyRegion}}/interview/{{ $interview['id'] }}">
                    <div class="img">
                        <img width="335" height="230" src="{{ $interview['thumbnail'] }}" class="attachment-thumb_335-200 size-thumb_335-200 wp-post-image" alt="">
                    </div>
                    <p class="cat">{{ $interview['cat_title'] }}</p>
                    <h3 class="title">{{ str_limit($interview['title'], '15', '...') }}</h3>
                    <p class="text">{!! str_limit($interview['sub_content'], 90, '…') !!}</p>
                    <p class="more">詳細はこちら</p>
                </a>
            </li>
        @endforeach
    </ul>
</div>
