@extends('app.layout')

@section('title')
    動作確認済環境｜{{$configs["pc_site_title"]}}
@endsection

@section('page_content')
    <div id="page_content">
        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>動作確認済環境</span>
            </li>
        </ul>

        <div id="__component">
            <h3>動作確認済環境</h3>

            <h5 class="clearfix">
                <span class="left_txt">動作確認済環境について</span>
                <span class="right_txt">【更新日：2016年5月12日】</span></h5>
            <p class="text">
                以下のブラウザにて動作確認をしております。<br>
                なお、端末やご利用環境により正常に機能・動作しない場合があります。<br>
                ご了承くださいませ。<br>
                <br>
                【PC】<br>
                ・Microsoft Internet Explorerバージョン11.0<br>
                ・Google Chrome（最新）<br>
                ・Firefox（最新）<br>
                ※モニターの解像度は1024×768ピクセル以上を推奨しています。<br>
                <br>
                【スマートフォン】<br>
                ◇iOS<br>
                バージョン：9.x<br>
                ブラウザ：Safari<br>
                <br>
                ◇Android<br>
                バージョン：4.2、4.3、4.4<br>
                ブラウザ：標準ブラウザ（地球儀アイコン4.4以降）、Chrome<br>
                <br>
                ※ 上記以外のブラウザにつきましては、正常に動作しない可能性があります。<br>
                ※ MacOS、WindowsVista、Windows10のブラウザにつきましては、正常に動作しない可能性があります。<br><br>

            </p>
            <h5>閲覧環境について</h5>
            <p class="text">
                スクリプト（JavaScript）を「有効」にしてください。多くの機能でJavaScriptを使用しています。<br>
                Cookieをブロックしないでください。会員ログイン機能にCookieを利用しています。
            </p>

            <h5>セキュアモードについて</h5>
            <p class="text">
                当サイトでは、ログインや企業への応募、登録情報の更新などの際に、情報が第三者から読み取られないようにインターネット上の通信を暗号化する技術「SSL（Secure Sockets
                Layer）」を用いております。 SSLを利用できない場合は、株式会社　ご縁事務局にご確認下さい。
            </p>

        </div>

        <ul class="breadcrumb">
            <li>
                <a href="/"><span>{{$configs["site_name"]}}</span></a>　≫
            </li>
            <li>
                <span>動作確認済環境</span>
            </li>
        </ul>

    </div>
@endsection