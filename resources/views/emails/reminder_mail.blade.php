<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>{{ $user->name }} からの未読メッセージがあります</p>

    <p>{!!  $notify->content !!}</p>

    <p>
        @php($path = $notify->from === 'user'
        ? 'member/mail/mail_box/' .  $notify->applcant_id
        : 'manage#/application/inbox/conversations?applicant_id=' . $notify->applcant_id)
        <a href="{{ url($path) }}">
            応答
        </a>
    </p>

</div>

</body>
</html>