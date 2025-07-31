
<form method="POST" action="https://testmpi.3dsecure.az/cgi-bin/cgi_link" id="secureForm">
    @foreach($data as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <noscript>
        <input type="submit" value="Click to proceed">
    </noscript>
</form>
<script>
    document.getElementById('secureForm').submit();
</script>