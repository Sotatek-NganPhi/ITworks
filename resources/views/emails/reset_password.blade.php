<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>

	<p>{{ $user['name'] }} thân mến,</p>
	<p>Vui lòng nhấp vào URL sau để thay đổi mật khẩu.</p>
	<p><a href="{{ $url }}">{{ $url }}</a></p>
</body>
</html>