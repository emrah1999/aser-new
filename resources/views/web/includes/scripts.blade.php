<script src="{{asset('web/js/library/jquery.min.js')}}"></script>
<script src="{{asset('web/js/library/jquery.validate.min.js')}}"></script>
<script src="{{asset('web/js/library/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/library/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/js/sweetalert2.min.js')}}"></script>
<script src="{{asset('web/js/validator.js')}}"></script>
<script src="{{asset('web/js/calculator.js')}}"></script>
<script src="{{asset('web/js/app.js')}}"></script>
<script src="{{asset('web/js/ajax.js?ver=1.1.4')}}"></script>
<script src="{{asset('web/js/courier.js')}}"></script>
<script src="{{asset('web/js/main.js')}}"></script>
<script>

    document.querySelector('.media-profile__left').addEventListener('mouseover', function() {
        document.querySelector('.logout-menu').style.display = 'block';
    });

    document.querySelector('.media-profile__left').addEventListener('mouseleave', function() {
        document.querySelector('.logout-menu').style.display = 'none';
    });
    $(document).ready(function() {
        $('#footer-tariff').click(function() {
            if ($('.footer-tariff-menus').hasClass('d-none')) {
                $('.footer-tariff-menus').addClass('d-block')
                $('.footer-tariff-menus').removeClass('d-none')
                $('.footer-tariff-icon').removeClass('fa-chevron-down')
                $('.footer-tariff-icon').addClass('fa-chevron-up')
            } else {
                $('.footer-tariff-menus').removeClass('d-block')
                $('.footer-tariff-menus').addClass('d-none')
                $('.footer-tariff-icon').removeClass('fa-chevron-up')
                $('.footer-tariff-icon').addClass('fa-chevron-down')
            }
        })
        $('#footer-company').click(function() {
            if ($('.footer-company-menus').hasClass('d-none')) {
                $('.footer-company-menus').addClass('d-block')
                $('.footer-company-menus').removeClass('d-none')
                $('.footer-company-icon').removeClass('fa-chevron-down')
                $('.footer-company-icon').addClass('fa-chevron-up')
            } else {
                $('.footer-company-menus').removeClass('d-block')
                $('.footer-company-menus').addClass('d-none')
                $('.footer-company-icon').removeClass('fa-chevron-up')
                $('.footer-company-icon').addClass('fa-chevron-down')
            }
        })
        $('#footer-logistic').click(function() {
            if ($('.footer-logistic-menus').hasClass('d-none')) {
                $('.footer-logistic-menus').addClass('d-block')
                $('.footer-logistic-menus').removeClass('d-none')
                $('.footer-logistic-icon').removeClass('fa-chevron-down')
                $('.footer-logistic-icon').addClass('fa-chevron-up')
            } else {
                $('.footer-logistic-menus').removeClass('d-block')
                $('.footer-logistic-menus').addClass('d-none')
                $('.footer-logistic-icon').removeClass('fa-chevron-up')
                $('.footer-logistic-icon').addClass('fa-chevron-down')
            }
        })
        $('#footer-blog').click(function() {
            if ($('.footer-blog-menus').hasClass('d-none')) {
                $('.footer-blog-menus').addClass('d-block')
                $('.footer-blog-menus').removeClass('d-none')
                $('.footer-blog-icon').removeClass('fa-chevron-down')
                $('.footer-blog-icon').addClass('fa-chevron-up')
            } else {
                $('.footer-blog-menus').removeClass('d-block')
                $('.footer-blog-menus').addClass('d-none')
                $('.footer-blog-icon').removeClass('fa-chevron-up')
                $('.footer-blog-icon').addClass('fa-chevron-down')
            }
        })
    })
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