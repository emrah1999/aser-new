<script src="{{asset('web/js/library/jquery.min.js')}}"></script>
<script src="{{asset('web/js/library/jquery.validate.min.js')}}"></script>
<script src="{{asset('web/js/library/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/library/owl.carousel.min.js')}}"></script>
<script src="{{asset("frontend/js/sweetalert2.min.js")}}"></script>
<script src="{{asset('web/js/validator.js')}}"></script>
<script src="{{asset('web/js/calculator.js')}}"></script>
<script src="{{asset('web/js/app.js')}}"></script>
<script src="{{asset('web/js/ajax.js?ver=1.1.4"')}}"></script>
<script src="{{asset('web/js/courier.js')}}"></script>
<script src="{{asset('web/js/main.js')}}"></script>
<script>

    document.querySelector('.media-profile__left').addEventListener('mouseover', function() {
        document.querySelector('.logout-menu').style.display = 'block';
    });

    document.querySelector('.media-profile__left').addEventListener('mouseleave', function() {
        document.querySelector('.logout-menu').style.display = 'none';
    });
</script>

<script>

    document.querySelector('.nav-languages__link').addEventListener('click', function(e) {
        e.preventDefault();
        const languageDropdown = this.nextElementSibling; // Açılır listeyi al

        // Açıqsa, bağla
        if (languageDropdown.classList.contains('d-none')) {
            languageDropdown.classList.remove('d-none');
        } else {
            languageDropdown.classList.add('d-none');
        }
    });

    document.addEventListener('click', function(e) {
        const languageMenu = document.querySelector('.nav-languages');
        const isClickInside = languageMenu.contains(e.target);

        if (!isClickInside) {
            const languageDropdown = languageMenu.querySelector('.nav-languages-2');
            if (!languageDropdown.classList.contains('d-none')) {
                languageDropdown.classList.add('d-none');
            }
        }
    });
</script>