@if(Auth::check())
    <div class="logout">
        <div class="user-panel">
            <h4>こんにちは、{{Auth::user()->first_name}}さん！</h4>
            <p>マイページでは登録情報の変更やクリップボード機能などがご利用できます。</p>
            <p class="__btn btn_member_home"><a href="{{ route('member_home') }}">マイページへ</a></p>
        </div>
         <p class="__btn btn_logout"><a href="{{route('logout')}}">ログアウト</a></p>
    </div>
@else
    <div class="user-panel">
        <h4>会員登録がお済で無い方</h4>
        <p>あなたの希望条件を登録すると、条件に合った求人をメールでお届けします。</p>
        <p class="__btn"><a href="{{ route('register') }}">新規会員登録（無料）</a></p>
        <h4>会員登録がお済の方</h4>
        <p>ご縁会員の方は、こちらからログインできます。</p>
        <p class="__btn"><a href="{{route('login')}}">ログイン</a></p>
    </div>
@endif
<div class="banner">
    <ul>
        @foreach($links as $link)
            <li>
                <a href="{{$link['url']}}" target="_blank">
                    <img id="li1;" src="{{$link['image']}}" alt=""/>
                </a>
            </li>
        @endforeach
    </ul>
</div>
