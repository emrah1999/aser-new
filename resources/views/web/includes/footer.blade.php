
<footer class="footer footer-new" id="footer">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="row footer-menu">
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <a href="#" class="logo">
                            <img class="logo__img" src="{{asset('web/images/logo/logo-footer.png')}}" alt="Logo">
                        </a>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 footer-tab-menu">
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
                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['contact'])->{'slug_' . App::getLocale()}]) }}"
                                   class="nav-menu-2__link">{{ optional($menu['contact'])->{'name_' . App::getLocale()} }}</a>
                            </li>

                            <li class="nav-menu-2__item">
{{--                                <a href="{{ route('blogs', ['locale' => App::getLocale()]) }}" class="nav-menu-2__link">Bloq</a>--}}
                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['blog'])->{'slug_' . App::getLocale()}]) }}"
                                   class="nav-menu-2__link">{{ optional($menu['blog'])->{'name_' . App::getLocale()} }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 footer-tab-menu">
                        <p class="footer__text font-n-b">Tariflər</p>
                        <ul class="nav nav-menu-2 flex-column">
                            @foreach ($tariffs as $tariff)
                                <li class="nav-menu-2__item">
                                    <a href="{{ route('menuIndex',['locale' => App::getLocale(),$tariff['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}" class="nav-menu-2__link">
                                        {{ $tariff['name_'. \Illuminate\Support\Facades\App::getLocale()] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 footer-tab-menu">
                        <p class="footer__text font-n-b">Logistika  xidməti</p>
                        <ul class="nav nav-menu-2 flex-column">
                            @foreach ($logistics as $logistic)
                                <li class="nav-menu-2__item">
                                    <a href="{{ route('menuIndex',['locale' => App::getLocale(),$logistic['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}" class="nav-menu-2__link">
                                        {{ $logistic['name_'. \Illuminate\Support\Facades\App::getLocale()] }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    @if(count($footerBlogs)>0)
                    <div class="col-xl-2 col-lg-2 col-md-2 footer-tab-menu">
                        <p class="footer__text font-n-b">Faydalı məqalələr</p>
                        <ul class="nav nav-menu-2 flex-column">
                            @foreach($footerBlogs as $footerBlog)
                            <li class="nav-menu-2__item">

                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $footerBlog['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}" class="nav-menu-2__link">{{$footerBlog['name_'. \Illuminate\Support\Facades\App::getLocale()]}}</a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>