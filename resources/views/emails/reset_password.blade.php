<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>

	<p>{{ $user['name'] }} 様</p>
	<p>以下のURLをクリックして変更手続きを行ってください。</p>
	<p><a href="{{ $url }}">{{ $url }}</a></p>
	<p>今後ともよろしくお願い申し上げます。</p>

</body>
</html>