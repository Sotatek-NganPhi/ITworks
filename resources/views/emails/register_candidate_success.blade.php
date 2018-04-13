<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>{{ $user['name'] }} 様</p>
    <p>この度は、「はたらく　ご縁」にお申し込み頂きまして誠にありがとうございます。</p>
    <p>はたらくご縁　マイページの本登録が完了いたしました。</p>
    <p>下記URLよりはたらくご縁　マイページにログイン出来ます。</p>
    <p><a href="{{ url('login') }}">{{ url('login') }}</a></p>
    <p>もし、心当たりがない場合は、</p>
    <p><a href="{{ url('inquiry') }}">{{ url('inquiry') }}</a></p>
    <p>より、会員情報を削除してください。</p>

</div>

</body>
</html>