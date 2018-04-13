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
    <link rel="stylesheet" type="text/css" href="/css/lp_business.css">
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
    @include('app.header')
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
            <div class="clear-both"></div>
        </div>
    </div>

    @include('app.common.breadcrumbs', ['crumbs' => [
              ['url' => route('index'), 'name' => $configs["site_name"]],
              ['url' => '#', 'name' => '代理店募集']
          ]])

    <div class="contentsArea">

        <!-- Panel -->
        <div class="panelArea">
            <div class="base">
                <div class="txtArea">
                    <h1 class="catch">代理店募集</h1>
                    <div class="text">
                        <span>株式会社 ご縁は、</span><span>50歳からの求人サイトはたらくご縁の代理店を募集しています。</span>
                    </div>
                    <div class="btnArea"><a href="/inquiry">お問い合わせはコチラ</a></div>
                </div>
            </div>
        </div>
        <!-- /Panel -->

        <!-- Recruitment -->
        <div class="recruitmentArea">
            <div class="base">
                <div class="catch"><span>全国の販売代理店を</span><span>募集中です!</span></div>
                <div class="txt">
                    <p><span>50歳からの求人サイトはたらくご縁の求人広告を</span><span>販売していただける販売代理店様を全国で募集しています。</span></p>
                    <p>シニア層に特化した求人広告を、弊社と共に販売展開してください！</p>
                </div>
            </div>
        </div>
        <!-- /Recruitment -->

        <!-- Merit -->
        <div class="MeritArea">
            <div class="base">
                <div class="meritUnit">
                    <div class="catch">代理店契約金はありません！<br>個人・法人問わず募集中です！</div>
                    <div class="img"><img src="/images/lp_business/img_merit_01.png" alt=""></div>
                    <div class="txt">
                        代理店販売をご希望される方は、お問い合わせフォームよりご連絡ください。弊社広告媒体を販売するにあたり、事前の代理店契約金は一切発生しませんのでご安心ください。個人の代理店様も業務委託として、ご契約をさせていただきます。
                    </div>
                </div><!--
         -->
                <div class="meritUnit">
                    <div class="catch">契約ノルマはありません！</div>
                    <div class="img"><img src="/images/lp_business/img_merit_02.png" alt=""></div>
                    <div class="txt">
                        販売ノルマもございません。御社にて取り組まれているサービスと自由に組み合わせてください。販売を行う上での必要サポートは適宜実施いたします。お困りの際には、都度弊社にお問い合わせください。
                    </div>
                </div>
            </div>
        </div>
        <!-- /Merit -->

        <!-- CV -->
        <div class="cvArea">
            <div class="base">
                <div class="catch">代理店ご希望の方・資料請求は<br>是非、お気軽にお問合せ下さい!</div>
                <div class="txt">問い合わせフォームより、弊社にご連絡ください。<br>追って弊社営業担当者よりご連絡致します。</div>
                <div class="btnArea"><a href="/inquiry">お問い合わせはコチラ</a></div>
            </div>
        </div>
    </div>
    @include('app.footer')
</div>
</body>
</html>