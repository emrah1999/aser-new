<script src="{{asset('web/js/library/jquery.min.js')}}"></script>
<script src="{{asset('web/js/library/jquery.validate.min.js')}}"></script>
<script src="{{asset('web/js/library/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/library/owl.carousel.min.js')}}"></script>
<script src="{{asset("frontend/js/sweetalert2.min.js")}}"></script>
<script src="{{asset('web/js/validator.js')}}"></script>
<script src="{{asset('web/js/calculator.js')}}"></script>
<script src="{{asset('web/js/app.js')}}"></script>
<script src="{{asset('web/js/ajax.js')}}"></script>
<script src="{{asset('web/js/courier.js')}}"></script>
<script src="{{asset('web/js/main.js')}}"></script>
<script>
    // Hover ile açma işlevi
    document.querySelector('.media-profile__left').addEventListener('mouseover', function() {
        document.querySelector('.logout-menu').style.display = 'block';
    });

    document.querySelector('.media-profile__left').addEventListener('mouseleave', function() {
        document.querySelector('.logout-menu').style.display = 'none';
    });
</script>