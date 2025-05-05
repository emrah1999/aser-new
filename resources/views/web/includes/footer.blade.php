<footer class="footer footer-new" id="footer">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="row footer-menu">
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <a href="#" class="logo">
                            <img class="logo__img" src="{{asset('web/images/logo/logo2.png')}}"  height="68px" width=162px"  alt="Logo">
                        </a>
                    </div>


                    <div class="col-xl-10 col-lg-10 col-md-10  d-none d-lg-block ">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 footer-tab-menu">
                                <p class="footer__text font-n-b">{!! __('static.company1') !!}</p>
                                <ul class="nav nav-menu-2  flex-column">
                                    <li class="nav-menu-2__item ">
                                        <a href="{{route('about_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.about_us1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{route('faq_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.faq1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{route('terms_and_conditions', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.terms1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{route('news_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.news1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{route('video_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.vodeos1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{route('prohibited_items', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.prohibited1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{route('sellers_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link nav-padding">{!! __('static.stores1') !!}</a>
                                    </li>
                                    <li class="nav-menu-2__item">
                                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['contact'])->{'slug_' . App::getLocale()}]) }}"
                                            class="nav-menu-2__link nav-padding">{{ optional($menu['contact'])->{'name_' . App::getLocale()} }}</a>
                                    </li>
                                    
                                    <li class="nav-menu-2__item">
                                      <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['blog'])->{'slug_' . App::getLocale()}]) }}"
                                   class="nav-menu-2__link nav-padding">{{ optional($menu['blog'])->{'name_' . App::getLocale()} }}</a>
                            </li>
                                    
              
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 footer-tab-menu">
                                <p class="footer__text font-n-b">{!! __('static.tariffs1') !!}</p>
                                <ul class="nav nav-menu-2 flex-column">
                                    @foreach ($tariffs as $tariff)
                                    <li class="nav-menu-2__item">
                                        <a href="{{ route('menuIndex',['locale' => App::getLocale(),$tariff['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}" class="nav-menu-2__link nav-padding">
                                            {{ $tariff['name_'. \Illuminate\Support\Facades\App::getLocale()] }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-2 footer-tab-menu">
                                <p class="footer__text font-n-b">{!! __('static.logistics1') !!}</p>
                                <ul class="nav nav-menu-2 flex-column">
                                    @foreach ($logistics as $logistic)
                                    <li class="nav-menu-2__item">
                                        <a href="{{ route('menuIndex',['locale' => App::getLocale(),$logistic['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}" class="nav-menu-2__link nav-padding">
                                            {{ $logistic['name_'. \Illuminate\Support\Facades\App::getLocale()] }}
                                        </a>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                            @if(count($footerBlogs)>0)
                            <div class="col-xl-3 col-lg-2 col-md-4 footer-tab-menu">
                                <p class="footer__text font-n-b">{!! __('static.articles1') !!}</p>
                                <ul class="nav nav-menu-2 flex-column">
                                    @foreach($footerBlogs as $footerBlog)
                                    <li class="nav-menu-2__item">

                                        <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $footerBlog['slug_'. \Illuminate\Support\Facades\App::getLocale()]]) }}" class="nav-menu-2__link nav-padding">
                                            {{$footerBlog['name_'. \Illuminate\Support\Facades\App::getLocale()]}}</a>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                            @endif
                        </div>


                            
                        </ul>

                    </div>
                    <div class="d-block d-lg-none">
                        <div class="col-xl-2 col-lg-2 col-md-2 footer-tab-menu">
                            <p class="footer__text font-n-b" id="footer-company">{!! __('static.company1') !!} <i class="fa fa-chevron-down footer-company-icon"></i></p>
                            <ul class="nav nav-menu-2 flex-column footer-company-menus d-none">
                                <li class="nav-menu-2__item">
                                    <a href="{{route('about_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('static.about_us1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{route('faq_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('static.faq1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{route('terms_and_conditions', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('menu.terms1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{route('news_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('static.news1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{route('video_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('static.vodeos1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{route('prohibited_items', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('static.prohibited1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{route('sellers_page', ['locale' => app::getLocale()])}}" class="nav-menu-2__link">{!! __('static.stores1') !!}</a>
                                </li>
                                <li class="nav-menu-2__item">
                                    <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['contact'])->{'slug_' . App::getLocale()}]) }}"
                                        class="nav-menu-2__link">{{ optional($menu['contact'])->{'name_' . App::getLocale()} }}</a>
                                </li>

                                <li class="nav-menu-2__item">
                                    <a href="{{ route('blogs', ['locale' => App::getLocale()]) }}" class="nav-menu-2__link">{!! __('static.blog1') !!}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 footer-tab-menu">
                            <!-- <p class="footer__text font-n-b">Tariflər</p> -->
                            <p class="footer__text font-n-b" id="footer-tariff">
                                Tariflər <i class="fa fa-chevron-down footer-tariff-icon"></i>
                            </p>
                            <ul class="nav nav-menu-2 flex-column footer-tariff-menus d-none">
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
                            <p class="footer__text font-n-b" id="footer-logistic">Logistika xidməti <i class="fa fa-chevron-down footer-logistic-icon"></i></p>
                            <ul class="nav nav-menu-2 flex-column footer-logistic-menus d-none">
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
                            <p class="footer__text font-n-b" id="footer-blog">Faydalı məqalələr <i class="fa fa-chevron-down footer-blog-icon"></i></p>
                            <ul class="nav nav-menu-2 flex-column footer-blog-menus d-none">
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
    </div>
</footer>
@section('scripts')

<script>

</script>
@endsection