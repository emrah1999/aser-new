<header class="header nm" id="header">
    
    <div class="header-bottom">
        <div class="container-lg">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <a href="{{ route('home_page', ['locale' => App::getLocale()]) }}" class="logo">
                        <img class="logo__img" src="{{asset('web/images/logo/logo2.png')}}" height="68px"  width=178px" alt="Logo">
                    </a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <ul class="nav nav-menu">
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
                            <a href="{{route("register", ['locale' => App::getLocale()])}}" class="btn btn-yellow header-top__btn font-n-b">{!! __('auth.register') !!}</a>
                            <a href="{{route("login", ['locale' => App::getLocale()])}}" class="btn btn-trns-black header-top__btn font-n-b">{!! __('auth.login') !!} </a>
                        </li>
                        @endif

                    </ul>
                </div>

                @if(Auth::check())
                    <div class="col-auto d-none d-xl-block">
                        <div class="media media-profile d-flex justify-content-center align-items-center">
                            <div class="media-profile__left" style="position: relative;top:20px">
                                <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}">
                                    <h6 class="media-profile__title font-n-b">
                                        {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                                    </h6>
                                </a>
                                <p class="media-profile__desc">ID: AS{{ Auth::user()->suite() }}</p>

                                <div class="logout-menu" style="display: none; position: absolute; top: 100%; left: 0; background-color: #FFCC00; padding: 5px; width: 100%; text-align: center; border-radius: 4px;">
                                    <a href="{{route("logout", ['locale' => App::getLocale()])}}" class="logout-link" style="color: black; font-weight: bold; text-decoration: none;">{!! __("labels.logout") !!}</a>

                                </div>
                            </div>
                            <div class="media-profile__right">
                                <div class="media-profile__img" style="background-image: url('{{Auth::user()->image}}')"></div>
                            </div>
                        </div>
                    </div>
                @endif

            <div class="col-auto language-col">
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
                                            <span class="nav-languages__link-title">{{ Config::get('languages')[App::getLocale()] }}</span>
                                            <img class="nav-languages__link-img" src="{{asset('web/images/content/chevron-down.png')}}" alt="Language">
                                        </a>
                                        <ul class="nav nav-languages-2  d-none">
                                            @foreach (Config::get('languages') as $lang => $language)
                                                <li class="nav-languages-2__item">
                                                    <a href="{{ route('set_locale_language', $lang) }}" class="nav-languages-2__link">{{ $language }}</a>
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
    </script>


