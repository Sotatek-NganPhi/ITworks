<div id="footer">
    <a href="#" class="page-top"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABQCAYAAADvCdDvAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAdFJREFUeNrs2tFtg0AQRVGX4BIowaVQCiW4k5TgEijBJaQESiAgOVKCkKIk2Htn5j4J+QckZnf2WCycTsYYY4wxpMzz3DkKnMnol2NajrOj0X4yzo/JWHNzRNpPyG3+nt5RaUvVNtIFoGob6QJQNUsXiyrpAlIlXUCqpAtGlXRBqJqki0PVuBwX6WJQNX1uLC6/V+lqT9WwOf8uXQ2p2jlfulpTtXOddLWmaud66WpJlXQBqZIuIFXSdfyEjP+hSrqOnYzhCKqk65jJ6I6kSrpgVEkXkCrpAlIlXTCqpAtIlXQBqZIuGFXSBaTqD3R1UvVkqn5J1yhVr7+fn+gapMr7qkcVfeWWL5jeMCVJKEFXtM5LT1e0AlPTFZWAlHRF77R0dEUvKBVdWZZ8ijqy/SmGpyubvaEbLOuDVci6sm89hFv52Z9wQzVcle3rEHWW2iWNIEG19wjoBiz5po1adzWq8DKUe+VJbsiqVCHHoTpVOCmqU4VqUD+9BNFV+gs/ohzlv4El0SVVILqkCkaXVIHokioQXVIFo0uqQHRJFYguqYLRJVUvp+sqVSy61lykikXXXarIdD1Wx7tUNaVr3Lug31laUvU8utZmf/va8B8CDAA8xeSAUmN7ygAAAABJRU5ErkJggg==" alt="" width="100" height="80">TOP</a>

    <div class="menu">
        <ul>
            <li><a href="{{route('rules')}}">Các điều khoản</a></li>
            <li><a href="{{route('privacy')}}">Chính sách bảo vệ thông tin cá nhân</a></li>
            <li><a href="{{route('contact')}}">Liên hệ</a></li>
        </ul>
    </div>
    <div class="prefectures">
        <div class="_prefectures">
            <div class="__prefectures">
                <ul class="ul_prefectures">
                    @foreach ($prefectures as $prefecture)
                        <li><a href="{{$prefecture['link']}}">{{$prefecture['name']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div id="mid_footer">
        <div class="logo_page">
            <h2><img src="/images/img_top.jpg" width="260" height="80" alt="footer"></h2>
        </div>
    </div>
    <div class="copyright"><p>&copy;IT works. All Rights Reserved.</p></div>
</div>
