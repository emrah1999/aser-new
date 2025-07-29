<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NH2BLDGS"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header class="header nm" id="header">

    <div class="header-bottom">
        <div class="container-lg">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <a href="{{ route('home_page', ['locale' => App::getLocale()]) }}" class="logo">
                        <img class="logo__img" src="{{asset('web/images/logo/logo2.png')}}" height="68px" width=162px" alt="Logo">
                    </a>
                </div>
                <div class="col-auto d-none d-xl-block">
                    <ul class="nav nav-menu mr-40">
                        <li class="nav-menu__item">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(), optional($menu['tariff'])->{'slug_' . App::getLocale()}]) }}" class="nav-menu__link">
                                {{ optional($menu['tariff'])->{'name_' . App::getLocale()} }}
                                <span class="dropdown-arrow"></span>
                            </a>
                            <ul class="dropdown-menu-nav">
                                @foreach ($tariffs as $tariff)
                                <li>
                                    <a href="{{ route('menuIndex',['locale' => App::getLocale(),$tariff['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}">
                                        {{ $tariff['name_'. \Illuminate\Support\Facades\App::getLocale()] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(), optional($menu['logistics'])->{'slug_' . App::getLocale()}]) }}" class="nav-menu__link">
                                {{ optional($menu['logistics'])->{'name_' . App::getLocale()} }}
                                <span class="dropdown-arrow"></span>
                            </a>
                            <ul class="dropdown-menu-nav">
                                @foreach ($logistics as $logistic)
                                <li>
                                    <a href="{{ route('menuIndex',['locale' => App::getLocale(),$logistic['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}">
                                        {{ $logistic['name_'. \Illuminate\Support\Facades\App::getLocale()] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['services'])->{'slug_' . App::getLocale()}]) }}"
                                class="nav-menu__link">{{ optional($menu['services'])->{'name_' . App::getLocale()} }}</a>

                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['branch'])->{'slug_' . App::getLocale()}]) }}"
                                class="nav-menu__link">{{ optional($menu['branch'])->{'name_' . App::getLocale()} }}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['contact'])->{'slug_' . App::getLocale()}]) }}"
                                class="nav-menu__link">{{ optional($menu['contact'])->{'name_' . App::getLocale()} }}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['trackingSearch'])->{'slug_' . App::getLocale()}]) }}"
                                class="nav-menu__link">{{ optional($menu['trackingSearch'])->{'name_' . App::getLocale()} }}</a>
                        </li>
                        @if(!Auth::check())
                        <li class="nav-menu__item">
                            <a href="{{route("register", ['locale' => App::getLocale()])}}" class="btn btn-yellow header-top__btn font-n-b">{!! __('auth.register1') !!}</a>
                            <a href="{{route("login", ['locale' => App::getLocale()])}}" class="btn btn-trns-black header-top__btn font-n-b">{!! __('auth.login') !!} </a>
                        </li>
                        @endif
                        <li>
                            @if(Auth::check())
                            <div class="col-auto d-none d-lg-block">
                                <div class="media media-profile d-flex justify-content-center align-items-center">
                                    <div class="media-profile__left" style="position: relative;top:20px">
                                        <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}">
                                            <h6 class="media-profile__title font-n-b">
                                                {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                                            </h6>
                                        </a>
                                        <p class="media-profile__desc">ID: AS{{ Auth::user()->suite() }}</p>

                                        <!-- <div class="logout-menu" style="display: none; position: absolute; top: 100%; left: 0; background-color: #FFCC00; padding: 5px; width: 100%; text-align: center; border-radius: 4px;">
                                            <a href="{{route("logout", ['locale' => App::getLocale()])}}" class="logout-link" style="color: black; font-weight: bold; text-decoration: none;">{!! __("labels.logout") !!}</a>

                                        </div> -->
                                    </div>
                                    <!-- <div class="media-profile__right">
                                        <div class="media-profile__img" style="background-image: url('{{Auth::user()->image}}')"></div>
                                    </div> -->
                                </div>
                            </div>
                            @endif
                        </li>

                    </ul>

                </div>



                <div class="col-auto language-col ">
                    <ul class="nav nav-languages">
                        <li class="nav-languages__item">
                            <a href="#" class="nav-languages__link">
                                <span class="nav-languages__link-title">
                                    <img class="nav-tab-country__link-img" src="/web/images/content/{{ strtoupper(App::getLocale()) }}.svg" alt="az">
                                    {{ Config::get('languages')[App::getLocale()] }}</span>
                                <img class="nav-languages__link-img" src="{{asset('web/images/content/chevron-down.png')}}" alt="Language">
                            </a>
                            <ul class="nav nav-languages-2 d-none">
                                @foreach (Config::get('languages') as $lang => $language)
                                <li class="nav-languages-2__item">
                                    <a href="{{ route('set_locale_language', $lang) }}" class="nav-languages-2__link d-flex">

                                        <img class="nav-tab-country__link-img" src="/web/images/content/{{ $language }}.svg" alt="az">

                                        {{ $language }}</a>
                                </li>
                                @endforeach

                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="col-auto d-block d-xl-none">
                    @if(Auth::check())
                    <div class="col-auto d-block d-xl-none">
                        <div class="media media-profile d-flex justify-content-center align-items-center">
                            <div class="media-profile__left mobile-dropdown">
                                <!-- <a class="btn btn-yellow btn-user-mobile" href="{{ route('get_account', ['locale' => App::getLocale()]) }}">
                                        <h6 class="media-profile__title font-n-b">
                                         <i class="fa fa-user"></i> 
                                        </h6>
                                    </a> -->
                                <div class="dropdown-container">
                                    <label for="dropdown-toggle1" class="dropdown-label mobile-dropdown-label" id="dropdown-label1">
                                        <i class="fa fa-user"></i>
                                        <span class="dropdown-icon"></span>
                                    </label>
                                    <input type="checkbox" id="dropdown-toggle1" class="dropdown-checkbox" />
                                    <ul class="dropdown-menu mobile-dropdown-menu">
                                        <li class="bar-padding">
                                            <h4 class="mobile-user-name" >
                                                {{Auth::user()->full_name()}}
                                            </h4><span   class="userIdCode"> ID: <strong> AS{{Auth::user()->suite()}} </strong> </span>
                                        </li>

                                        <li class="nav-profile-menu__item">
                                            <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}"
                                                class="nav-profile-menu__link d-flex justify-content-start align-items-center"
                                                style="white-space: normal; word-break: break-word; overflow-wrap: anywhere;">
                                                <span class="nav-profile-menu__link-title"
                                                style="white-space: normal; word-break: break-word; overflow-wrap: anywhere;"
                                                >{!! __('account_menu.my_account') !!}</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{ route('get_orders', ['locale' => App::getLocale()]) }}"
                                                class="nav-profile-menu__link d-flex justify-content-start align-items-center">
                                                <span class="nav-profile-menu__link-title">{!! __('account_menu.order') !!}</span>
                                            </a>
                                        </li>

                                        <li class="nav-profile-menu__item">
                                            <a href="{{ route('branchAndPudo', ['locale' => App::getLocale()]) }}"
                                                class="nav-profile-menu__link d-flex justify-content-start align-items-center"
                                                style="white-space: normal; word-break: break-word; overflow-wrap: anywhere;">
                                                <span class="nav-profile-menu__link-title" style="white-space: normal; word-break: break-word; overflow-wrap: anywhere;">
                                                    {{ optional($menu['branch'])->{'name_' . App::getLocale()} }}
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{route("get_courier_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center ">
                                                <span class="nav-profile-menu__link-title">{!! __('account_menu.courier') !!}</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{ route('special_order_select', ['locale' => App::getLocale()]) }}"
                                                class="nav-profile-menu__link d-flex justify-content-start align-items-center">
                                                <span class="nav-profile-menu__link-title">{!! __('static.order_title') !!}</span>
                                            </a>
                                        </li>

                                        <li class="nav-profile-menu__item">
                                            <a href="{{route("get_azerpost_courier_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center ">
                                                <span class="nav-profile-menu__link-title">{!! __('account_menu.courier_azerpost') !!}</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{route("get_balance_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center ">
                                                <span class="nav-profile-menu__link-title">{!! __('account_menu.balance') !!}</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{route("get_sub_accounts", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center ">
                                                <span class="nav-profile-menu__link-title">Referal Hesablar</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{ route('get_seller_otp', ['locale' => App::getLocale()]) }}"
                                                class="nav-profile-menu__link d-flex justify-content-start align-items-center">
                                                <span class="nav-profile-menu__link-title">OTP</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{ route('onay_code_list', ['locale' => App::getLocale()]) }}"
                                                class="nav-profile-menu__link d-flex justify-content-start align-items-center">
                                                <span class="nav-profile-menu__link-title">Trendyol Onay kodu</span>
                                            </a>
                                        </li>
                                        <li class="nav-profile-menu__item">
                                            <a href="{{route("get_user_settings", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center ">
                                                <span class="nav-profile-menu__link-title">Profil</span>
                                            </a>
                                        </li>



                                        <li class="nav-profile-menu__item logout-button">
                                            <a class="nav-profile-menu__link d-flex justify-content-start align-items-center" data-bs-toggle="modal" data-bs-target="#modalProfileLogout">
                                                <span class="nav-profile-menu__link-title">Çıxış</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- <div class="media-profile__right">
                                <div class="media-profile__img" style="background-image: url('{{Auth::user()->image}}')"></div>
                            </div> -->
                        </div>
                    </div>
                    @endif
                    <button class="btn btn-yellow mobile-menu @if(!Auth::check()) mobile-menu-top-0 @endif" type="button">
                        <span class="mobile-menu__item"></span>
                        <span class="mobile-menu__item"></span>
                        <span class="mobile-menu__item"></span>
                    </button>
                </div>
            </div>
            <div class="menu-mobile-block d-none">
                <ul class="nav nav-menu">
                    <li class="nav-menu__item">
                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(), optional($menu['tariff'])->{'slug_' . App::getLocale()}]) }}" class="nav-menu__link">
                            {{ optional($menu['tariff'])->{'name_' . App::getLocale()} }}
                        </a>

                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(), optional($menu['logistics'])->{'slug_' . App::getLocale()}]) }}" class="nav-menu__link">
                            {{ optional($menu['logistics'])->{'name_' . App::getLocale()} }}
                        </a>

                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['services'])->{'slug_' . App::getLocale()}]) }}"
                            class="nav-menu__link">{{ optional($menu['services'])->{'name_' . App::getLocale()} }}</a>

                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['branch'])->{'slug_' . App::getLocale()}]) }}"
                            class="nav-menu__link">{{ optional($menu['branch'])->{'name_' . App::getLocale()} }}</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['contact'])->{'slug_' . App::getLocale()}]) }}"
                            class="nav-menu__link">{{ optional($menu['contact'])->{'name_' . App::getLocale()} }}</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['trackingSearch'])->{'slug_' . App::getLocale()}]) }}"
                            class="nav-menu__link">{{ optional($menu['trackingSearch'])->{'name_' . App::getLocale()} }}</a>
                    </li>
                    <li>
                        <div class="col-auto language-col-mob">
                            <ul class="nav nav-languages">
                                <li class="nav-languages__item">
                                    <a href="#" class="nav-languages__link">
                                        <span class="nav-languages__link-title">
                                            <img class="nav-tab-country__link-img" src="/web/images/content/{{ strtoupper(App::getLocale()) }}.svg" alt="az"> {{ Config::get('languages')[App::getLocale()] }}</span>
                                        <img class="nav-languages__link-img" src="{{asset('web/images/content/chevron-down.png')}}" alt="Language">
                                    </a>
                                    <ul class="nav nav-languages-2  d-none">

                                        @foreach (Config::get('languages') as $lang => $language)

                                        <li class="nav-languages-2__item">

                                            <a href="{{ route('set_locale_language', $lang) }}" class="nav-languages-2__link">

                                                <img class="nav-tab-country__link-img" src="/web/images/content/{{ $language }}.svg" alt="az">

                                                {{ $language }}</a>

                                        </li>

                                        @endforeach



                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>


                </ul>
                @if(Auth::check())
                <div class="col-auto d-none d-xl-block">
                    <div class="media media-profile d-flex justify-content-center align-items-center">
                        <div class="media-profile__left">
                            <h6 class="media-profile__title font-n-b">{{Auth::user()->name . ' ' . Auth::user()->surname}}</h6>
                            <p class="media-profile__desc">ID: AS{{Auth::user()->suite()}}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="d-block d-md-none">
                    <a href="{{route("register", ['locale' => App::getLocale()])}}" class="btn btn-yellow header-top__btn d-block font-n-b">{!! __('auth.register') !!}</a>
                    <a href="{{route("login", ['locale' => App::getLocale()])}}" class="btn btn-trns-black header-top__btn d-block font-n-b">{!! __('auth.login') !!}</a>
                </div>
                @endif

            </div>
        </div>
    </div>


</header>

@if(($breadcrumbs ?? 0) == 1)
<section class="section section-breadcrumbs">
    <div class="container-lg">
        <div class="row justify-content-center align-items-start">
            <div class="col-sm-6 col-7">
                <ul class="nav nav-breadcrumbs font-n-b">
                    <li class="nav-breadcrumbs__item">
                        <a href="{{ route('home_page', ['locale' => App::getLocale()]) }}" class="nav-breadcrumbs__link">{!! __('breadcrumbs.homePage') !!}</a>
                    </li>
                    @yield('breadcrumbs')
                </ul>
            </div>
            <div class="col-sm-6 col-5">

            </div>
        </div>
    </div>
</section>
@endif




<script>
    document.addEventListener("DOMContentLoaded", function () {
        const logoutButton = document.querySelector(".logout-button");
        const dropdownToggle = document.getElementById("dropdown-toggle1");

        if (logoutButton && dropdownToggle) {
            logoutButton.addEventListener("click", function () {
                dropdownToggle.checked = false;
            });
        }
    });

    document.querySelector('.dropdown-container').addEventListener('click', function() {
        document.querySelector('.menu-mobile-block').classList.add('d-none');
    });
    document.querySelector('.nav-languages__link').addEventListener('click', function(e) {
        e.preventDefault();
        const languageDropdown = this.nextElementSibling;

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
    document.addEventListener("click", function(event) {
        let dropdown = document.querySelector(".dropdown-container");
        let checkbox = document.getElementById("dropdown-toggle1");

        if (!dropdown.contains(event.target)) {
            checkbox.checked = false;
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        const menu = document.querySelector(".menu-mobile-block");
        const toggleButton = document.querySelector(".mobile-menu");

        

        document.addEventListener("click", function (event) {
            if (!menu.contains(event.target) && !toggleButton.contains(event.target)) {
                menu.classList.add("d-none");
            }
        });
    });

</script>