<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>{{ $user['name'] }} thân mến,</p>
    <p>Cảm ơn bạn rất nhiều vì đã đăng ký thành viên.</p>
    <p>Bạn có thể đăng nhập bằng link bên dưới</p>
    <p><a href="{{ url('login') }}">{{ url('login') }}</a></p>
</div>

</body>
</html>