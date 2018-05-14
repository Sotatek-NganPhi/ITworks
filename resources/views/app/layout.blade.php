<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="masterdata-version" content="{{ $dataVersion }}">
    <title>@yield('title')</title>
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/home.css">
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
      })(window, document, 'script' , 'https://www.google-analytics.com/analytics.js', 'ga');

      ga('create', 'UA-101859229-2', 'auto');
      ga('send', 'pageview');
    </script>
    @yield('script')
</head>
<body>
<div class="container">
    @include('app.header')
    @yield('page_content')
    @include('app.footer')
</div>
@yield('vue-js')
</body>
</html>
