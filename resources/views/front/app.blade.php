<!DOCTYPE html>
<html lang="az">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- <meta name="viewport" content="width=1290"> -->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Amerika, Ingiltere, Almaniya, Ispaniya ve Turkiyeden catdirilma xidmeti | Aser Cargo Express</title>
	<meta name="title" content="asercargo.az">
	<meta name="csrf-token" secret="{{csrf_token()}}">
	<meta property="og:title" content="asercargo.az">
	<meta property="og:description"
	      content="ASER CARGO: çatdırılmadan daha üstün. Aser Carqo ABŞ-dan bağlamaların, onlayn mağazalar vasitəsi ilə edilən sifarişlərin ən qısa müddət ərzində Bakıya çatdırılmasını təşkil edir.">
	<meta name="description"
	      content="ASER CARGO: çatdırılmadan daha üstün. ASER CARGO ABŞ-dan bağlamaların, onlayn mağazalar vasitəsi ilə edilən sifarişlərin ən qısa müddət ərzində Bakıya çatdırılmasını təşkil edir.">
	<meta name="keywords"
	      content="aser, ASER CARGO, Çatdırılma, Onlayn mağazalar, ABŞ-dan Bakıya yük daşıma, Çatdırılma xidməti, catdirilma, abs-dan catdirilma">
	<meta name="description" content="Türkiyədən və Amerikadan bağlamaların sürətli çatdırılması. Etibarlı, sürətli və keyfiyyətli kargo. Türkiyə, Amerikadan alış-veriş saytları, tanınmış brend mağazalar, kargo şirkətləri">
	<meta property="og:title" content="asercargo.az | Türkiyədən çatdırılma, Amerikadan çatdırılma, Türkiyədən catdırılma, Amerikadan catdırılma">
	<meta property="og:description" content="Türkiyədən və Amerikadan Azərbaycana çatdırılma. Türkiyədən çatdırılma, Amerikadan çatdırılma, Türkiyədən catdırılma, Amerikadan catdırılma">
	<meta name="keywords" content="Türkiyədən Çatdırılma, Turkiyeden catdirilma,, türkiyədən çatdırılma,amerikadan çatdırılma, Azərbaycana çatdırılma,
        Kargo şirkəti, turkiyeden catdirilma,türkiyədən sifariş, amerikadan sifariş,amerikadan sifaris, amerikadan çatdırılma, turkiyeden sifaris,turkiyeden alis veris,turkiyeden alver,
        turkiyeden azerbaycana kargo, online alışveriş azerbaycan, online alışveriş baki,kargo azerbaycan, Trendyoldan azerbaycana sifaris,rayonlara çatdırılma,
        Bakı ətrafına çatdırılma,online alış veriş, AliExpress.com-dan Azərbaycana sifariş və çatdırılma, Amazon.com-dan Azərbaycana sifariş və çatdırılma, kargo şirkəti, kargo şirketi,karqo şirkətləri,
        daşınma şirkəti, daşınma şirkəti, kitab sifarişi, Online Alış veriş">
	<meta property="og:image" content="{{asset("front/css/image/icon/aserExpressLogo.png")}}">
	<link href="{{asset("front/css/font.min.css?v=2.2.0")}}" rel="stylesheet">
	<link href="{{asset("front/css/plugin.min.css?v=2.2.0")}}" rel="stylesheet">
	<link href="{{asset("front/css/reset.min.css?v=2.2.0")}}" rel="stylesheet">
	<link href="{{asset("front/css/main.css?v=3.0.1")}}" rel="stylesheet">
	<link href="{{asset("front/css/mobile.css?v=3.0.1")}}" rel="stylesheet">
	<link href="{{asset("front/css/user.css?v=3.0.1")}}" rel="stylesheet">
	<link href="{{asset("front/css/simpleLightbox.min.css")}}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="icon" href="{{asset("front/image/tab_icon.png")}}" type="image/x-icon">
	<link rel="shortcut icon" href="{{asset("front/image/tab_icon.png")}}" type="image/x-icon">
	<link rel="stylesheet" href="{{asset("frontend/css/sweetalert2.min.css")}}">
	<link rel="stylesheet" href="{{asset("frontend/css/main.css?v=2.3.0")}}">
	@yield("css")
	<style>

		.snowflakes {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			pointer-events: none;
			z-index: 9999;
			top: -22px;
		}
		.snowflake {
			position: absolute;
			width: 100%;
			height: 10px;
			color: white;
			font-size: 13px;
			opacity: 1;
			animation: snowflakes-fall linear infinite;
			z-index: 1;
		}

		@keyframes snowflakes-fall {
			from {
				transform: translateY(-80vh);
			}
			to {
				transform: translateY(100vh);
			}
		}

		.item {
            color: #FFF;
            border-radius: 3px;
            text-align: center;
        }
        .owl-carousel .item img {
            display: block;
            width: 100%;
            /* height: 298px; */
        }

		.owl-nav{
			display: none;
		}

		.owl-dots{
			display: none;
		}
		.lang-block {
			position: relative;
			display: inline-block;
		}

		.dropdown-menu {
			width: 100%;
			padding: 0;
			margin: 0;
		}

		.dropdown-menu > li {
			list-style: none;
		}

		.dropdown-menu > li > a {
			display: flex;
			align-items: center;
			padding: 8px 16px;
			text-decoration: none;
			color: #333;
			width: 100px;
		}


		.dropdown-menu > li > a img {
			margin-right: 8px;
		}

	</style>
	<script src="{{asset("front/js/jquery.js")}}"></script>
	<script src="{{asset("front/js/popper.js")}}"></script>
	<meta property="og:type" content="website">
	<meta property="og:url" content="">
	<link rel="shortcut icon" href="favicon.ico" />
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-P55HPJD38H"></script>-->
<!--<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-P55HPJD38H');
</script-->
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NH2BLDGS');</script>
	<!-- End Google Tag Manager -->
</head>

<body class="body-loading">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NH2BLDGS"
				  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="snowflakes" aria-hidden="true"></div>

<header>
	<div class="desktop-show">
		<div class="top-header">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="flex">
							<div class="lang-block">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<img src="{{ asset('front/css/image/icon/lang-' . App::getLocale() . '.png') }}" alt="{{ Config::get('languages')[App::getLocale()] }} flag" style="width: 20px; height: 15px; margin-right: 8px;">

										<span class="caret">{{ Config::get('languages')[App::getLocale()] }}</span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="languageDropdown">
										@foreach (Config::get('languages') as $lang => $language)
											<li>
												<a href="{{ route('set_locale_language', $lang) }}">
													<img src="{{ asset('front/css/image/icon/lang-' . $lang . '.png') }}" alt="{{ $language }} flag" style="width: 20px; height: 15px; margin-right: 8px;">
													<span class="caret">
														{{ $language }}
													</span>

												</a>
											</li>
										@endforeach
									</ul>
								</div>
							</div>






							{{-- <div class="lang-block">
								<ul>
									@foreach (Config::get('languages') as $lang => $language)
										@if ($lang == App::getLocale())
											<li class="active"><a class="lang-{{$lang}}"
											                      href="{{route("set_locale_language", $lang)}}"> </a>
											</li>
										@else
											<li><a class="lang-{{$lang}}"
											       href="{{route("set_locale_language", $lang)}}"> </a></li>
										@endif
									@endforeach
								</ul>
							</div> --}}
							<div class="col header_top_left pl-0">
								{{-- <a href="">{!! __('menu.dangerous_goods') !!}</a> --}}
								 <a href="{{route("faq_page", ['locale' => App::getLocale()])}}">{!! __('menu.faqi') !!}</a>
								<a class="terms" target="_blank" href="{{asset('uploads/static/terms.pdf')}}"> {!! __('menu.terms') !!} </a>
							</div>
							{{-- <div class="currency-block">
								<span> {{ now()->format("d.m.Y") }}, {{ now()->localeDayOfWeek }}, {{ now()->timezoneName }} {{ substr(now()->toTimeString(), 0, 5) }} </span>
								|

								<div class="currency-list">
									@if(isset($exchange_rates_for_header))
										@php($exchange_rates_for_header_count = 0)
										@foreach($exchange_rates_for_header as $rate)
											@php($exchange_rates_for_header_count++)
											<span class="ca-{{$exchange_rates_for_header_count}}"> 1 {{$rate->from_currency}} - {{$rate->rate}} {{$rate->to_currency}} </span>
										@endforeach
									@endif
									
								</div>

							</div> --}}
						</div>
					</div>
					<div class="col-md-6">
						<div class="flex-right">
							@if(Auth::check())
							<div class="log-container">
								<a href="{{route("get_account")}}" class="log-in-block log_block" title="">
									<div class="log-in-image">
										<img src="{{Auth::user()->profile_image()}}"
											title="{{Auth::user()->full_name()}}" alt="{{Auth::user()->full_name()}}" />
									</div>
									<div class="log-in-content">
										<h5 style="text-transform: capitalize;"> {{Auth::user()->full_name()}} </h5>
										<span style="color: #333; font-size:14px"> ID: <code> {{Auth::user()->suite()}} </code> </span>
										<button type="button" class="log-in-dropdown"></button>
									</div>
								</a>

								<a href="{{route("logout")}}" title="" class="logout-link logout_block">{!! __('auth.logout') !!}</a>
							</div>
							@else
								<div class="register-block">
									<a class="aser_login" href="{{route("login")}}"> {!! __('auth.login') !!} </a>
									<a class="aser_reg" href="{{route("register")}}"> {!! __('auth.register') !!} </a>
								 {{--	<a href="#" onclick="show_modal_for_tracking_search('tracking-search-modal');"> {!! __('menu.tracking_search') !!} </a> --}}
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="content-header">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<div class="logo">
							<a href="{{route("home_page")}}">
								<img src="{{asset("front/css/image/icon/aserExpressLogo.png")}}" title="asercargo.az"
								     alt="asercargo.az" />
							</a>
						</div>
					</div>
					<div class="col-md-9">
						<div class="header-menu">
							<ul class="header-menus">
								<li><a href="{{route("about_page")}}"> {!! __('menu.about') !!} </a></li>
								<li><a href="{{route("ourServices_page")}}"> {!! __('menu.our_services') !!} </a></li>
								<li><a href="{{route("tariffs_page")}}"> {!! __('menu.tariffs') !!} </a></li>
								<li><a href="{{route("sellers_page")}}"> {!! __('menu.sellers') !!} </a></li>
								{{-- <li><a href="{{route("news_page")}}"> {!! __('menu.news') !!} </a></li> --}}
								<li><a href="{{route("contact_page")}}"> {!! __('menu.contact') !!} </a></li>
								{{-- <li class="dropdown">
									<a href="#" class="dropbtn"> {!! __('menu.services') !!} </a>
									<ul class="dropdown-content">
										<li>
											<a href="{{route("dangerous_goods_page")}}"> {!! __('menu.dangerous_goods') !!} </a>
										</li>
										<li>
											<a href="#" onclick="show_modal_for_tracking_search('tracking-search-modal');"> {!! __('menu.tracking_search') !!} </a>
										</li>
									</ul>
								</li> --}}
							</ul>
							{{-- <div class="header_order_side ">
							<a href="/az/signin.html" class="header_order_button">Daxil ol</a>
									<button class="menu_open"></button>
							</div> --}}
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile-show header-mobile">
		<div class="mobile-top-header">
			<div class="container">
				<div class="row">
					<div class="currency-block">
						<span> {{ now()->format("d.m.Y") }}, {{ now()->localeDayOfWeek }}, {{ now()->timezoneName }} {{ substr(now()->toTimeString(), 0, 5) }} </span>
						<div class="currency-list">
							@if(isset($exchange_rates_for_header))
								@php($exchange_rates_for_header_count = 0)
								@foreach($exchange_rates_for_header as $rate)
									@php($exchange_rates_for_header_count++)
									<span class="ca-{{$exchange_rates_for_header_count}}"> 1 {{$rate->from_currency}} - {{$rate->rate}} {{$rate->to_currency}} </span>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content-header">
			<div class="container">
				<div class="row">
					<div class="col-md-5 col-11">
						<div class="logo">
							<a href="{{route("home_page")}}">
								<img src="{{asset("front/css/image/icon/aserExpressLogo.png")}}" title="asercargo.az"
								     alt="asercargo.az">
							</a>
						</div>
					</div>
					<div class="col-md-7 col-1">
						<div class="mobile-menu-control nav-control">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</div>
				</div>
			</div>

			<div class="navbar-panel">
				<div class="navbar-inside">
					<div class="ni-top">
						<div class="nav-close-btn">X</div>
						<div class="ni-account">

							@if(Auth::check())
								<a href="{{route("get_account")}}" class="log-in-block" title="">
									<div class="log-in-image">
										<img src="{{Auth::user()->profile_image()}}"
										     title="{{Auth::user()->full_name()}}" alt="{{Auth::user()->full_name()}}" />
									</div>
									<div class="log-in-content">
										<h5 style="text-transform: capitalize;"> {{Auth::user()->full_name()}} </h5>
										<span style="color: #333; font-size: 13px"> ID: <code> {{Auth::user()->suite()}} </code> </span>
										<button type="button" class="log-in-dropdown"></button>
									</div>
								</a>

								<a href="{{route("logout")}}" title="" class="logout-link">{!! __('auth.logout') !!}</a>
							@else
								<div class="register-block">
									<a href="{{route("register")}}"> {!! __('auth.register') !!} </a>
									<a href="{{route("login")}}"> {!! __('auth.login') !!} </a>
								</div>
							@endif

						</div>
						<div class="ni-menu">
							<ul>
								<li><a href="{{route("about_page")}}"> {!! __('menu.about') !!} </a></li>
								<li><a href="{{route("ourServices_page")}}"> {!! __('menu.our_services') !!} </a></li>
								<li><a href="{{route("tariffs_page")}}"> {!! __('menu.tariffs') !!} </a></li>
								<li><a href="{{route("sellers_page")}}"> {!! __('menu.sellers') !!} </a></li>
								{{--<li>
									<a href="{{route("dangerous_goods_page")}}"> {!! __('menu.dangerous_goods') !!} </a>
								</li> --}}
								{{-- <li><a href="{{route("faq_page")}}"> {!! __('menu.faq') !!} </a></li> --}}
								
								{{-- <li>
									<a href="#" onclick="show_modal_for_tracking_search('tracking-search-modal');"> {!! __('menu.tracking_search') !!} </a>
								</li> --}}
								
								{{-- <li class="dropdown">
									<a href="#" class="dropbtn"> {!! __('menu.services') !!} </a>
									<ul class="dropdown-content">
										<li>
											<a href="{{route("dangerous_goods_page")}}"> {!! __('menu.dangerous_goods') !!} </a>
										</li>
									</ul>
								</li> --}}
							{{--	<li><a href="{{route("news_page")}}"> {!! __('menu.news') !!} </a></li> --}}
								<li><a href="{{route("contact_page")}}"> {!! __('menu.contact') !!} </a></li>
								<li><a target="_blank" href="{{asset('uploads/static/terms.pdf')}}"> {!! __('menu.terms') !!} </a></li>
							</ul>
						</div>
						<div class="ni-lang lang-block">
							<ul>
								@foreach (Config::get('languages') as $lang => $language)
									@if ($lang == App::getLocale())
										<li class="active"><a class="lang-{{$lang}}"
										                      href="{{route("set_locale_language", $lang)}}"> </a></li>
									@else
										<li><a class="lang-{{$lang}}"
										       href="{{route("set_locale_language", $lang)}}"> </a></li>
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</header>
@yield("content")

<div class="modal fade" id="tracking-search-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
					<div id="tracking_search_panel">
						<div class="order-form-header">
							<h3> {!! __('tracking_search.title') !!} </h3>
						</div>
						<div class="form-element">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group field-userorder-product_name required">
										<label class="control-label" for="track_no_for_search">{!! __('tracking_search.track') !!}</label>
										<input type="text" id="track_no_for_search" class="form-control" placeholder="{!! __('tracking_search.track') !!}" required maxlength="500">
									</div>
									<div class="order-button tracking-search-buttons">
										<button type="button" class="orange-button" onclick="global_tracking_search();"> {!! __('tracking_search.global_search_button') !!}</button>
										<button type="button" class="orange-button" onclick="local_tracking_search('{{route("local_tracking_search")}}');"> {!! __('tracking_search.local_search_button') !!}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tracking_search_list" style="display: none;">
						<h1>{!! __('tracking_search.track') !!}: <b id="tracking_search_track"></b></h1>
						<!-- <hr> -->
						<table class="table table-bordered">
							<thead>
							<tr>
								<th>{!! __('tracking_search.no') !!}</th>
								<th>{!! __('tracking_search.status') !!}</th>
								<th>{!! __('tracking_search.date') !!}</th>
							</tr>
							</thead>
							<tbody id="tracking_search_status_list">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="close_modal" class="close_modal" onclick="close_modal('tracking-search-modal')"></div>
</div>


<footer>
	<div class="container">
		<div class="row">
			<div class="footer-block">
				<div class="footer-left-block">
					<div class="footer-logo">
						<a href="{{route("home_page")}}"> <img src="{{asset("front/css/image/icon/aserExpressLogo.png")}}"
						                                       title="aser.az" alt="logo" /> </a>
					</div>
					<div class="footer-logo-content">
						{{-- <span> {!! $general_settings->{"working_hours_" . \Illuminate\Support\Facades\App::getLocale()} !!} </span> --}}
					</div>
				</div>
				<div class="footer-right-block">
					<div class="footer-menu">
						<ul class="footer-menu-ul">
							<li>
								<span>{!! __('menu.main_menus') !!} </span>
								<ul class="child-ul">
									<li><a href="{{route("about_page")}}"> {!! __('menu.about') !!} </a></li>
									<li><a href="{{route("tariffs_page")}}"> {!! __('menu.tariffs') !!} </a></li>
									<li><a href="{{route("sellers_page")}}"> {!! __('menu.sellers') !!} </a></li>
									{{-- <li><a href="{{route("faq_page")}}"> {!! __('menu.faq') !!} </a></li> --}}
									<li><a href="{{route("contact_page")}}"> {!! __('menu.contact') !!} </a></li>
									{{-- <li>
										<a href="#" onclick="show_modal_for_tracking_search('tracking-search-modal');"> {!! __('menu.tracking_search') !!} </a>
									</li> --}}
								</ul>
							</li>
							<li>
								<span>{!! __('menu.useful_information') !!} </span>
								<ul class="child-ul">
									<li><a target="_blank" href="{{asset('uploads/static/terms.pdf')}}"> {!! __('menu.terms') !!} </a></li>
									<li><a href="{{route("faq_page")}}">{!! __('menu.faqi') !!}</a></li>
									{{-- <li><a href="{{route("tutorial")}}"> {!! __('menu.tutorial') !!} </a></li> --}}
								</ul>
							</li>

							<li>
								<span> {!! __('static.contact') !!} </span>
								<ul class="child-ul">
									<li>
										<span class="address"> {!! __('static.address') !!}: {!! __('static.address_text_footer') !!} </span>
									</li>
									<li><span class="phone"> {!! __('static.phone') !!}: </span> <a
														href="tel:(+99412) 310 07 09"> (+99412) 310 07 09 </a></li>
							
									<li><span class="email"> {!! __('static.email') !!}: </span> <a
														href="mailto:info@asercargo.az">
											info@asercargo.az </a></li>
								</ul>
								{{-- <ul class="footer-social-ul">
									<li><a href="https://www.facebook.com/aser.azerbaijan/" target="_blank"
									       class="fa-fb"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
									<li><a href="https://www.instagram.com/aser.az/" target="_blank" class="fa-in"><i
															class="fab fa-instagram" aria-hidden="true"></i></a></li>
									<li><a href="https://www.youtube.com/channel/UCV-ljAqohSNZretpFxMeuBg"
									       target="_blank" class="fa-yt"><i class="fab fa-youtube"
									                                        aria-hidden="true"></i></a></li>
								</ul> --}}
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="copyright-block">
				<div class="copyright">
					<p> © {{ now()->year }} Aser Cargo MMC. {!! __('static.reserved') !!} </p>
				</div>
				<div class="paypal"></div>
			</div>
		</div>
	</div>
</footer>

{{--<script src="{{asset("front/js/colorbox.js")}}"></script>--}}
<script src="{{asset("front/js/bootstrap.min.js")}}"></script>
<script src="{{asset("front/js/bxslider.js")}}"></script>
<script src="{{asset("front/js/script.js")}}"></script>
<script src="{{asset("front/user/count-up.js")}}"></script>
<script src="{{asset("front/user/jquery.form.js")}}"></script>
<script src="{{asset("front/user/script.js")}}"></script>

<script src="{{asset("frontend/js/jquery-3.4.1.js")}}"></script>
<script src="{{asset("frontend/js/bootstrap.min.js")}}"></script>
<script src="{{asset("frontend/js/jquery.form.min.js")}}"></script>
<script src="{{asset("frontend/js/sweetalert2.min.js")}}"></script>
<script src="{{asset("frontend/js/main.js?ver=0.2.6")}}"></script>
<script src="{{asset("frontend/js/ajax.js?ver=1.1.7")}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@yield("js")
<script>

	/*document.addEventListener('DOMContentLoaded', function() {
		// Calculate 18 years ago from today
		var currentDate = new Date();
		var maxDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());

		flatpickr("#birthday", {
			dateFormat: "Y-m-d",
			allowInput: true,
			minDate: "1935-01-01",
			maxDate: maxDate,
			onReady: function(selectedDates, dateStr, instance) {
				// Disable the calendar from opening
				instance.calendarContainer.style.display = 'none';
				instance._input.addEventListener('focus', function(e) {
					instance.close();
				});
			}
		});

		document.querySelector('.date-icon').addEventListener('click', function() {
			document.querySelector('#birthday')._flatpickr.open();
		});

		// Validate manual input and format it correctly
		console.log(this.value);
		document.querySelector('#birthday').addEventListener('input', function() {
			var input = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
			if (input.length === 8) {
				var day = input.substring(0, 2);
				var month = input.substring(2, 4);
				var year = input.substring(4, 8);
				var formattedDate = year + '-' + month + '-' + day;
				this.value = formattedDate;
				console.log(this.value, formattedDate);
				// Validate the formatted date
				var dateObj = new Date(year, month - 1, day);
				var minDateObj = new Date(1935, 0, 1);
				var regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d\d$/;

				if (regex.test(formattedDate) && dateObj >= minDateObj && dateObj <= maxDate) {
					this.classList.remove('is-invalid');
				} else {
					this.classList.add('is-invalid');
				}
			} else {
				this.classList.add('is-invalid');
			}
		});
	});*/
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
  (function () {
    var s1     = document.createElement('script'), s0 = document.getElementsByTagName('script')[0]
    s1.async   = true
    s1.src     = 'https://embed.tawk.to/5d1ce5437a48df6da242cf37/default'
    s1.charset = 'UTF-8'
    s1.setAttribute('crossorigin', '*')
    s0.parentNode.insertBefore(s1, s0)
  })()
</script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		let snowflakes = document.querySelector(".snowflakes");
		let screenWidth = window.innerWidth;

		console.log(screenWidth);

		let today = new Date();
		let todayDate = today.getDate();
		let todayMonth = today.getMonth() + 1;

		if ((todayMonth === 12 && todayDate >= 15) || (todayMonth === 2 && todayDate <= 15)) {
			if (screenWidth <= 756) {
				for (let i = 0; i < 30; i++) {
					createSnowflake();
				}
			} else {
				for (let i = 0; i < 300; i++) {
					createSnowflake();
				}
			}
		}

		function createSnowflake() {
			let snowflake = document.createElement("div");
			snowflake.className = "snowflake";
			snowflake.style.left = Math.random() * screenWidth + "px";
			snowflake.style.animationDuration = Math.random() * 15 + 10 + "s";
			snowflake.style.animationDelay = Math.random() + "s";
			snowflake.textContent = "\u2744";
			snowflakes.appendChild(snowflake);
		}
	});
</script>

<script>
        $(document).ready(function(){
            $(".default-carousel").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
			$(".partner-carousel").owlCarousel({
                items: 2, 
                loop: true,
                margin: 20,
                nav: true,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
				responsive: {
					0: {
						items: 2
					},
					600: {
						items: 3
					},
					1000: {
						items: 5
					}
				}
            });
        });
    </script>

<script>
	function changeLanguage(select) {
		location = select.value;
	}

	document.addEventListener('DOMContentLoaded', function () {
		var select = document.getElementById('language_select');
		var options = select.options;

		for (var i = 0; i < options.length; i++) {
			var option = options[i];
			var iconUrl = option.getAttribute('data-icon');
			if (iconUrl) {
				var img = document.createElement('img');
				img.src = iconUrl;
				img.alt = option.text + ' flag';
				img.style.width = '20px';
				img.style.height = '15px';
				img.style.marginRight = '8px';
				option.style.backgroundImage = 'url(' + iconUrl + ')';
				option.style.backgroundRepeat = 'no-repeat';
				option.style.backgroundPosition = 'left center';
				option.style.paddingLeft = '25px'; // Adjust based on flag image width
			}
		}
	});
</script>
<script>
    window.translations = {
        pay_from_balance: "{!! __('static.pay_from_balance', ['locale' => App::getLocale()]) !!}",
        pay_by_card: "{!! __('static.pay_by_card', ['locale' => App::getLocale()]) !!}",
        pay_by_card: "{!! __('static.pay_by_card', ['locale' => App::getLocale()]) !!}",
        select_payment_method: "{!! __('static.select_payment_method', ['locale' => App::getLocale()]) !!}",
    };
</script>
<!--End of Tawk.to Script-->
</body>

</html>
