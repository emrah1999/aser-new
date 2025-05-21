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
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px 20px 25px;
        z-index: 10000;
        font-family: 'Segoe UI', Arial, sans-serif;
        border-top: 1px solid #e0e0e0;
        animation: slideUp 0.3s ease-out;
        text-align: center;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }

    #appPopup h3 {
        margin-top: 0;
        color: #00b0F0; /* Mavi rəng */
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    #appPopup p {
        color: #666;
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 15px;
    }

    .open-app-btn {
        display: block;
        width: 90%;
        max-width: 300px;
        margin: 0 auto;
        padding: 14px 20px;
        background-color: #00b0F0; /* Mavi rəng */
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .open-app-btn:hover {
        background-color: #0090D0;
        transform: translateY(-2px);
    }

    .close-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 20px;
        height: 20px;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.2s;
        stroke: #F2C516; /* Sarı rəng */
    }

    .close-icon:hover {
        opacity: 1;
    }

    .popup-header {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .popup-header:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 4px;
        background-color: #F2C516; /* Sarı rəng */
        border-radius: 2px;
    }
</style>

<div id="appPopup" style="display: none;">
    <div class="popup-header">
        <h3>Mobil tətbiqimiz mövcuddur!</h3>
        <svg class="close-icon" id="closePopupBtn" xmlns="http://www3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </div>
    <p>Daha rahat istifadə üçün tətbiqdə açın</p>
    <button class="open-app-btn" id="openAppBtn">Tətbiqdə aç</button>
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
        var isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        var appUrlScheme = "asercargo://";
        var webUrl = "https://asercargo.az";

        if (isMobile && getCookie("popup_closed2") !== "true") {
            var popup = document.getElementById("appPopup");
            var openBtn = document.getElementById("openAppBtn");
            var closeBtn = document.getElementById("closePopupBtn");

            setTimeout(function() {
                popup.style.display = "block";
            }, 1000);

            openBtn.addEventListener("click", function () {
                window.location.href = appUrlScheme;

                setTimeout(function() {
                    if (!document.hidden) {
                        var isAndroid = /Android/i.test(navigator.userAgent);
                        var storeUrl = isAndroid ?
                            "https://play.google.com/store/apps/details?id=com.asercargo" :
                            "https://apps.apple.com/az/app/aser-cargo-express/id6670343932";
                        window.location.href = storeUrl;
                    }
                }, 300);

                setCookie("popup_closed2", "true", 1440);
            });

            closeBtn.addEventListener("click", function () {
                popup.style.display = "none";
                setCookie("popup_closed2", "true", 2);
            });
        }
    });
</script>