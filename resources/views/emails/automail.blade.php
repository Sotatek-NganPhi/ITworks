<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>{{ $header }}</h2>
<div>
    @foreach($jobs as $index => $job)
        <h4>#{{ $index }}</h4>
        <table>
            @foreach($properties as $fieldName => $displayName)
            <tr>
                <td>{{ $displayName }}</td>
                <td>{{ $job[$fieldName] }}</td>
            </tr>
            @endforeach
        </table>
    @endforeach
</div>
<div>
{{ $footer }}
</div>

</body>
</html>
