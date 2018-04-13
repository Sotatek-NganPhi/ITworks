<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="masterdata-version" content="{{ $dataVersion }}">
    <meta name="description" content="{{ $configs['pc_meta_description'] }}">
    <meta name="keywords" content="{{ $configs['pc_meta_keywords'] }}">
    <title>代理店募集</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/home.css">
    <link rel="stylesheet" type="text/css" href="/css/lp.css">
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-101859229-2', 'auto');
        ga('send', 'pageview');
    </script>
    @yield('script')
</head>
<body>
<div class="container">
    <div class="contentsArea">

        <!-- Panel -->
        <div class="panelArea">
            <div class="txtArea">
                <h1 class="logo"><img src="/images/head_logo.svg" alt="50歳からの求人サイト はたらくご縁job"></h1>
                <div class="text">生涯現役 いつまでも働ける環境を<br>~週1日勤務や短期求人多数~</div>
                <div class="btnArea"><a href="/register">無料会員登録はコチラ</a></div>
                <div class="link"><a href="/login">既に会員の方はコチラ</a></div>
            </div>
        </div>
        <!-- /Panel -->

        <!-- About -->
        <div class="aboutArea">
            <div class="about">
                <div class="textArea">
                    <h2 class="catch">50歳からの求人サイト<br>はたらくご縁とは？</h2>
                    <div class="txt">
                        <p>少子高齢化の日本の「働く」を変える！<br>皆様のこれまで培ってきた「ご経験」「技術」「ノウハウ」等を活かして、<br>日本を盛り上げていきたい！</p>
                        <p>そのような想いを「はたらくご縁」は実現します。</p>
                        <p>週1日の勤務や、短期勤務も含め、生涯現役・社会との繋がりを作りましょう。</p>
                        <p>会員登録は無料ですので、今すぐ職をお探しの方以外でも登録しておくと様々な求人情報を閲覧することができます。</p>
                    </div>
                </div>
            </div>
            <div class="merit">
                <div class="meritUnit">
                    <div class="catch">希望の求人情報が<br>定期的に手に入る</div>
                    <div class="img"><img src="/images/lp_personal/img_merit_01.jpg" alt="希望の求人情報が定期的に手に入る"></div>
                    <div class="txt">
                        <p class="emphasis">掲載される求人情報は、今後全国的に増えてまいります。</p>
                        <p>求人条件をご登録いただければ新着情報を定期的にお届けいたします。</p>
                    </div>
                </div>
                <div class="meritUnit">
                    <div class="catch">非公開求人情報！<br>スカウトメールが届く</div>
                    <div class="img"><img src="/images/lp_personal/img_merit_02.jpg" alt="非公開求人情報！スカウトメールが届く"></div>
                    <div class="txt">
                        <p>求人企業や提携人材会社よりスカウトメールが届きます。</p>
                        <p class="emphasis">役員経験者や有資格者の方々等、ハイスキルの求職者もぜひご登録ください！</p>
                    </div>
                </div>
                <div class="meritUnit">
                    <div class="catch">50歳以上を積極採用する<br>企業ばかり</div>
                    <div class="img"><img src="/images/lp_personal/img_merit_03.jpg" alt="50歳以上を積極採用する企業ばかり"></div>
                    <div class="txt">
                        <p>はたらくご縁に掲載される50歳以上のベテランの方々を求める企業ばかりです。</p>
                        <p class="emphasis">もう年齢を理由に、お断りされる心配はありません！</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /About -->

        <!-- Search -->
        <div class="searchArea">
            <h2 class="catch">求人を見てみる！</h2>
            <div class="sub">ご希望のエリアをお選びください</div>
            <div class="map"><img src="/images/lp_personal/map.png" alt="" usemap="#Map">
                <map name="Map">
                    <area shape="poly"
                          coords="454,303,424,305,413,288,401,289,400,297,386,297,386,290,393,290,414,257,455,162,466,99,498,80,533,36,537,14,588,3,732,2,732,57,635,58,633,86,618,95,618,116,627,123,612,130,596,135,587,126,578,126,558,145,558,153,545,160,511,120,494,132,494,142,502,162,504,226"
                          href="/hokkaido_tohoku/home" target="_blank" alt="北海道・東北">
                    <area shape="poly" coords="517,339" href="#">
                    <area shape="poly"
                          coords="523,340,522,397,452,397,409,360,408,346,395,346,389,351,384,349,384,339,359,317,359,300,376,297,382,294,386,300,398,299,402,291,412,290,423,307,446,305"
                          href="/kanto/home" target="_blank" alt="関東">
                    <area shape="poly"
                          coords="276,189,278,248,309,312,315,328,315,362,380,368,396,358,382,350,383,340,357,321,357,301,385,291,412,257,401,240,376,239,383,270,368,280,364,260,346,246,346,191"
                          href="/chubu/home" target="_blank" alt="中部">
                    <area shape="poly"
                          coords="255,303,255,337,293,337,293,344,282,351,274,371,282,382,281,393,252,393,251,445,321,445,321,395,301,394,300,381,313,364,314,329,309,314,295,307"
                          href="/kansai/home" target="_blank" alt="関西">
                    <area shape="poly"
                          coords="91,235,91,294,155,295,159,332,194,340,196,374,207,383,266,369,267,345,251,344,253,295,222,294,202,286,203,233"
                          href="/chugoku_shikoku/home" target="_blank" alt="中国・四国">
                    <area shape="poly"
                          coords="142,332,160,341,189,347,189,382,156,429,123,426,118,400,3,395,3,341,103,341,103,315,2,263,2,143,35,126,85,66,99,67,103,106,35,155,6,146,5,260"
                          href="/kyushu_okinawa/home" target="_blank" alt="九州・沖縄">
                </map>
            </div>
            <div class="sp_list">
                <div class="mapImg"><img src="/images/lp_personal/sp_map.png" alt="日本地図"></div>
                <ul class="linkList">
                    <li class="list"><a class="hokkaido_tohoku" href="/hokkaido_tohoku/home"
                                        target="_blank">北海道・東北</a></li>
                    <li class="list"><a class="kanto" href="/kanto/home" target="_blank">関東</a>
                    </li>
                    <li class="list"><a class="chubu" href="/chubu/home" target="_blank">中部</a>
                    </li>
                    <li class="list"><a class="kansai" href="/kansai/home"
                                        target="_blank">関西</a></li>
                    <li class="list"><a class="chugoku_shikoku" href="/chugoku_shikoku/home"
                                        target="_blank">中国・四国</a></li>
                    <li class="list"><a class="kyushu_okinawa" href="/kyushu_okinawa/home"
                                        target="_blank">九州・沖縄</a></li>
                </ul>
            </div>
        </div>
        <!-- /Search -->

        <!-- Contents End -->
    </div>

    <div class="footer">
        <div class="menu">
            <ul>
                <li><a href="/company">会社概要</a></li>
                <li><a href="/kanto/videos">お役立ちコンテンツ</a></li>
                <li><a href="/kanto/interview/cat/all">企業インタビュー</a></li>
                <li><a href="/kanto/lp-business">代理店募集</a></li>
                <li><a href="/rules">利用規約</a></li>
                <li><a href="/privacy">個人情報保護方針</a></li>
                <li><a href="/sitemap">サイトマップ</a></li>
                <li><a href="/contact">お問い合わせ</a></li>
            </ul>
        </div>
        <div class="logo_page">
            <h2><img src="/images/head_logo.svg" width="260" height="80" alt="ロゴ"></h2>
        </div>
        <div class="copyright"><p>©株式会社ご縁. All Rights Reserved.</p></div>
    </div>
</div>
</body>
</html>
