<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting to Bank Gateway</title>
</head>
<body onload="document.forms[0].submit();">
<form method="POST" action="https://testmpi.3dsecure.az/cgi-bin/cgi_link">
    @foreach($data as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <noscript>
        <input type="submit" value="Click to proceed">
    </noscript>
</form>
</body>
</html>