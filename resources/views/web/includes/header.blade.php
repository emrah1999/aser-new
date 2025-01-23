<header class="header nm" id="header">
    <div class="header-top">
        <div class="container-lg">
            <div class="row justify-content-center align-items-center">
                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-10 col-9">
                    <div class="d-flex justify-content-start align-items-center">
                        <p class="header-top__text">Mobil tətbiqi yükləyin</p>
                        <a href="#" class="google-apple__link">
                            <img class="google-apple__img d-none d-sm-block" src="{{asset('web/images/content/other-google-play.png')}}" alt="Google Play">
                            <img class="google-apple__img d-block d-sm-none" src="{{asset('web/images/content/other-google-play-2.png')}}" alt="Google Play">
                        </a>
                        <a href="#" class="google-apple__link">
                            <img class="google-apple__img d-none d-sm-block" src="{{asset('web/images/content/other-apple-store.png')}}" alt="Apple Store">
                            <img class="google-apple__img d-block d-sm-none" src="{{asset('web/images/content/other-apple-store-2.png')}}" alt="Apple Store">
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-5 col-md-5 col-sm-2 col-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto d-none d-md-block">
                            @if(Auth::check())
{{--                                <a href="{{route("logout", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center">--}}
{{--                                    <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-exit.png" alt="ProfileMenu">--}}
{{--                                    <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-exit.png" alt="ProfileMenu">--}}
{{--                                    <span class="nav-profile-menu__link-title">{!! __('auth.logout') !!}</span>--}}
{{--                                </a>--}}
                            @else
                                <a href="{{route("register", ['locale' => App::getLocale()])}}" class="btn btn-yellow header-top__btn font-n-b">{!! __('auth.register') !!}</a>
                                <a href="{{route("login", ['locale' => App::getLocale()])}}" class="btn btn-trns-black header-top__btn font-n-b">{!! __('auth.login') !!} </a>
                            @endif
                        </div>
                        <div class="col-auto d-md-none"></div>
                        <div class="col-auto">
                            <ul class="nav nav-languages">
                                <li class="nav-languages__item">
                                    <a href="#" class="nav-languages__link">
                                        <span class="nav-languages__link-title">{{ Config::get('languages')[App::getLocale()] }}</span>
                                        <img class="nav-languages__link-img" src="{{asset('web/images/content/chevron-down.png')}}" alt="Language">
                                    </a>
                                    <ul class="nav nav-languages-2 d-none">
                                        @foreach (Config::get('languages') as $lang => $language)
                                            <li class="nav-languages-2__item">
                                                <a href="{{ route('set_locale_language', $lang) }}" class="nav-languages-2__link">{{ $language }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container-lg">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <a href="{{ route('home_page', ['locale' => App::getLocale()]) }}" class="logo">
                        <img class="logo__img" src="{{asset('web/images/logo/logo.png')}}" alt="Logo">
                    </a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <ul class="nav nav-menu">
                        <li class="nav-menu__item">
                            <a href="{{ route('tariffs_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.tariffs') !!}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('transport_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.transport') !!}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('ourServices_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.our_services') !!}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('ourServices_branhces', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('auth.branch') !!}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('contact_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.contact') !!}</a>
                        </li>
                        <li class="nav-menu__item">
                            <a href="{{ route('get_tracking_search', ['locale' => App::getLocale()]) }}" class="nav-menu__link">Tracking Search</a>
                        </li>
                    </ul>
                </div>

                @if(Auth::check())
                    <div class="col-auto d-none d-xl-block">
                        <div class="media media-profile d-flex justify-content-center align-items-center">
                            <div class="media-profile__left" style="position: relative;">
                                <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}">
                                    <h6 class="media-profile__title font-n-b">
                                        {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                                    </h6>
                                </a>
                                <p class="media-profile__desc">ID: AS{{ Auth::user()->suite() }}</p>

                                <!-- Açılır menü -->
                                <div class="logout-menu" style="display: none; position: absolute; top: 100%; left: 0; background-color: #FFCC00; padding: 5px; width: 100%; text-align: center; border-radius: 4px;">
                                    <a href="{{route("logout", ['locale' => App::getLocale()])}}" class="logout-link" style="color: black; font-weight: bold; text-decoration: none;">Logout</a>

                                </div>
                            </div>
                            </div>
                            <div class="media-profile__right">
                                <div class="media-profile__img" style="background-image: url('{{Auth::user()->image}}')"></div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="col-auto d-block d-lg-none">
                    <button class="btn btn-yellow mobile-menu" type="button">
                        <span class="mobile-menu__item"></span>
                        <span class="mobile-menu__item"></span>
                        <span class="mobile-menu__item"></span>
                    </button>
                </div>
            </div>
            <div class="menu-mobile-block d-none">
                <ul class="nav nav-menu">
                    <li class="nav-menu__item">
                        <a href="{{ route('about_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.about') !!}</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('ourServices_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.our_services') !!}</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('ourServices_branhces', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('auth.branch') !!}</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('sellers_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.sellers') !!}</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('ourServices_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">Tracking Search</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{ route('contact_page', ['locale' => App::getLocale()]) }}" class="nav-menu__link">{!! __('menu.contact') !!}</a>
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

