<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Mail company</h2>
<div>
    <p><b>Company Name:</b> {{ $company["name"] }}</p>
    <p><b>Phonetic name:</b> {{ $company["name_phonetic"] }}</p>
    <p><b>Phone Number:</b> {{ $company["phone_number"] }}</p>
    <p><b>Expiration Date:</b>{{$company["expire_date"]}}</p>
    <p><b>Content:</b> {!! $company["content"] !!}</p>
</div>

</body>
</html>