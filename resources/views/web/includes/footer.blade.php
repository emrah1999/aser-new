{{--<footer class="footer" id="footer">--}}
{{--    <div class="container-lg">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-9">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3">--}}
{{--                        <a href="#" class="logo">--}}
{{--                            <img class="logo__img" src="{{asset('web/images/logo/logo.png')}}" alt="Logo">--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">--}}
{{--                        <ul class="nav nav-menu-2 flex-column">--}}
{{--                            <li class="nav-menu-2__item">--}}
{{--                                <a href="{{route('faq_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Suallar və cavablar</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-menu-2__item">--}}
{{--                                <a href="{{asset('uploads/static/terms.pdf')}}" class="nav-menu-2__link">{!! __('menu.terms_new') !!}</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">--}}
{{--                        <ul class="nav nav-menu-2 flex-column">--}}
{{--                            <li class="nav-menu-2__item">--}}
{{--                                <a href="{{route('news_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Xəbərlər</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-menu-2__item">--}}
{{--                                <a href="{{route('video_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Video təlimatlar</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">--}}
{{--                        <ul class="nav nav-menu-2 flex-column">--}}
{{--                            <li class="nav-menu-2__item">--}}
{{--                                <a href="{{route('prohibited_items', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Qadağan olunmuş məhsullar</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-menu-2__item">--}}
{{--                                <a href="{{route('contact_footer_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Bizimlə əlaqə</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-3">--}}
{{--                <p class="footer__text">Bizi izləyin</p>--}}
{{--                <ul class="nav nav-socials">--}}
{{--                    <li class="nav-socials__item d-flex justify-content-center align-items-center">--}}
{{--                        <a href="#" class="nav-socials__link">--}}
{{--                            <img class="nav-socials__img" src="{{asset('web/images/content/social-facebook.png')}}" alt="Facebook">--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-socials__item d-flex justify-content-center align-items-center">--}}
{{--                        <a href="#" class="nav-socials__link">--}}
{{--                            <img class="nav-socials__img" src="{{asset('web/images/content/social-instagram.png')}}" alt="Instagram">--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-socials__item d-flex justify-content-center align-items-center">--}}
{{--                        <a href="#" class="nav-socials__link">--}}
{{--                            <img class="nav-socials__img" src="{{asset('web/images/content/social-youtube.png')}}" alt="Youtube">--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--                <p class="footer__text">Mobil tətbiqi yükləyin</p>--}}
{{--                <div class="d-flex">--}}
{{--                    <a href="#" class="google-apple__link">--}}
{{--                        <img class="google-apple__img d-none d-xxl-block" src="{{asset('web/images/content/other-google-play.png')}}" alt="Google Play">--}}
{{--                        <img class="google-apple__img d-block d-xxl-none" src="{{asset('web/images/content/other-google-play-2.png')}}" alt="Google Play">--}}
{{--                    </a>--}}
{{--                    <a href="#" class="google-apple__link">--}}
{{--                        <img class="google-apple__img d-none d-xxl-block" src="{{asset('web/images/content/other-apple-store.png')}}" alt="Apple Store">--}}
{{--                        <img class="google-apple__img d-block d-xxl-none" src="{{asset('web/images/content/other-apple-store-2.png')}}" alt="Apple Store">--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}
<footer class="footer footer-new" id="footer">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <a href="#" class="logo">
                            <img class="logo__img" src="{{asset('web/images/logo/logo.png')}}" alt="Logo">
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <p class="footer__text font-n-b">Şirkət</p>
                        <ul class="nav nav-menu-2 flex-column">
                            <li class="nav-menu-2__item">
                                <a href="{{route('about_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Haqqımızda</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('faq_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Suallar və cavablar</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('terms_and_conditions', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('menu.terms_new') !!}</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('promo_code', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Promokod</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('news_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Xəbərlər</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('video_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Video təlimatlar</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('prohibited_items', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Qadağan olunmuş məhsullar</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('sellers_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Mağazalar</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('contact_footer_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Bizimlə əlaqə</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="#" class="nav-menu-2__link">Bloq</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <p class="footer__text font-n-b">Tariflər</p>
                        <ul class="nav nav-menu-2 flex-column">
                            <li class="nav-menu-2__item">
                                <a href="{{route('tariffs_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Türkiyədən Azərbaycana kargo</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('tariffs_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Amerikadan Azərbaycana kargo</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('tariffs_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Almaniyadan Azərbaycana kargo</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('tariffs_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">İngiltərədən Azərbaycana kargo</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3">
                        <p class="footer__text font-n-b">Logistika  xidməti</p>
                        <ul class="nav nav-menu-2 flex-column">
                            <li class="nav-menu-2__item">
                                <a href="{{route('transport_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Hava nəqliyyatı</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('transport_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Avtomobil nəqliyyatı</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('transport_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Dəniz nəqliyyatı</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="{{route('transport_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">Dəmiryolu nəqliyyatı</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <p class="footer__text font-n-b">Faydalı məqalələr</p>
                        <ul class="nav nav-menu-2 flex-column">
                            <li class="nav-menu-2__item">
                                <a href="#" class="nav-menu-2__link">Trendyoldan necə sifariş edək?</a>
                            </li>
                            <li class="nav-menu-2__item">
                                <a href="#" class="nav-menu-2__link">Smart Customs</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>