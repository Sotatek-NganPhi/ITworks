<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<p>{{ $applicant['last_name'] . $applicant['first_name']  }} 様から、</p>

<p>【{{ $job['company_name'] }}】{{ $job['description'] }} に応募がありました。</p>

<p>仕事詳細: <a href="{{ url('/manage#/candidate/application_list/job?id=' . $job['id']) }}">{{ url('/manage#/application/job?id='. $job['id']) }}</a></p>

<p>応募者:
<div>
        <p>メールアドレス: {{$applicant['email']}}</p>
        <p>名:{{$applicant['first_name']}}</p>
        <p>名字: {{$applicant['last_name']}}</p>
        <p>名フリガナ: {{$applicant['furigana_first_name']}}</p>
        <p>名字フリガナ: {{$applicant['furigana_last_name']}}</p>
        <p>性別 : {{$applicant['gender']}}</p>
        <p>電話番号: {{$applicant['phone_number']}}</p>
        <p>生年月日: {{$applicant['birthday']}}</p>
        <p>住所: {{$applicant['address']}}</p>
        <p>詳細: <a href="{{ url('/manage#/application/applicant?id='. $applicant['id']) }}">{{ url('/manage#/application/applicant?id='. $applicant['id']) }}</a></p>
</div>

※応募者の詳細から直接メールでのやりとりをしてください。

</body>
</html>