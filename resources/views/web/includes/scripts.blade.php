<script src="{{asset('web/js/library/jquery.min.js')}}"></script>
<script src="{{asset('web/js/library/jquery.validate.min.js')}}"></script>
<script src="{{asset('web/js/library/bootstrap.min.js')}}"></script>
<script src="{{asset('web/js/library/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/js/sweetalert2.min.js')}}"></script>
<script src="{{asset('web/js/validator.js')}}"></script>
<script src="{{asset('web/js/calculator.js?v=1.1')}}"></script>
<script src="{{asset('web/js/app.js?v=1.10')}}"></script>
@if(strpos(request()->fullUrl(), "special-order")!== false)
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
@endif
@if(strpos(request()->fullUrl(), "courier")!== false)
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
@endif
<script src="{{asset('web/js/ajax.js?ver=1.3.5')}}"></script>
<script src="{{asset('web/js/courier.js?v=1.2')}}"></script>
<script src="{{asset('web/js/main.js?v=1.26')}}"></script>
<script>

    
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
<style>
    #appPopup {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border: 2px solid #00b0F0;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        padding: 20px;
        width: 90%;
        max-width: 400px;
        z-index: 10000;
        text-align: center;
        font-family: sans-serif;
    }

    #appPopup h3 {
        margin-top: 0;
        color: #00b0F0;
        font-size: 18px;
    }

    #appPopupButtons {
        margin-top: 15px;
        display: flex;
        justify-content: space-around;
        gap: 10px;
        flex-wrap: wrap;
    }

    .popup-button {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        flex: 1;
    }

    .download-btn {
        background-color: #00b0F0;
        color: white;
    }

    .close-btn {
        background-color: #F2C516;
        color: black;
    }
</style>

<div id="appPopup" style="display: none;">
    <h3>Mobil tətbiqimiz mövcuddur!</h3>
    <p>İndi yükləyin və rahat şəkildə istifadə edin.</p>
    <div id="appPopupButtons">
        <button class="popup-button download-btn" id="downloadAppBtn">Yüklə</button>
        <button class="popup-button close-btn" id="closePopupBtn">Bağla</button>
    </div>
</div>

<script>
    function setCookie(name, value, minutes) {
        var expires = new Date();
        expires.setTime(expires.getTime() + minutes * 60 * 1000);
        document.cookie = name + "=" + value + ";expires=" + expires.toUTCString() + ";path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    document.addEventListener("DOMContentLoaded", function () {
        var isAndroid = /Android/i.test(navigator.userAgent);
        var isiOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);

        var androidUrl = "https://play.google.com/store/apps/details?id=com.asercargo";
        var iosUrl = "https://apps.apple.com/az/app/aser-cargo-express/id6670343932";

        if ((isAndroid || isiOS) && getCookie("popup_closed") !== "true") {
            var storeUrl = isAndroid ? androidUrl : iosUrl;
            var popup = document.getElementById("appPopup");
            var downloadBtn = document.getElementById("downloadAppBtn");
            var closeBtn = document.getElementById("closePopupBtn");

            popup.style.display = "block";

            downloadBtn.addEventListener("click", function () {
                window.location.href = storeUrl;
            });

            closeBtn.addEventListener("click", function () {
                popup.style.display = "none";
                setCookie("popup_closed", "true", 2);
            });
        }
    });
</script>
