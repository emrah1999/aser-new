@extends('web.layouts.web')
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item">
        <a href="{{ route('ourServices_page', ['locale' => App::getLocale()]) }}" class="nav-breadcrumbs__link">{!! __('breadcrumbs.tariff') !!}</a>
    </li>
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{{$country->name}}</li>
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media-tarif-country__body">
                                <h4 class="media-tarif-country__title font-n-b">{{$country->name}}</h4>
                                <p class="media-tarif-country__desc">
                                   {{$country->content}}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-tarif-country__right">
                                <img class="media-tarif-country__img img-responsive" src="{{$country->icon}}" alt="Tarif">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media-tarif-country__right">
                                <div class="thumbnail thumbnail-tarifs-2 center-block">
                                    <table class="table table-tarifs">
                                        <caption class="table-tarifs__caption caption-top text-center font-n-b">STANDART</caption>
                                        <tbody class="table-tarifs__tbody">
                                        @foreach($tariffs->where('type_id', 1) as $tariff)
                                            <tr class="table-tarifs__tbody-tr">
                                                @php($rate = $tariff->rate == 0 ? $tariff->charge : $tariff->rate)
                                                <td class="table-tarifs__tbody-td font-n-b">Kq {{$tariff->from_weight}} - Kq {{$tariff->to_weight}}</td>
                                                <td class="table-tarifs__tbody-td text-right">{{$tariff->icon}}{{$rate}} / ₼{{ $tariff->amount_azn }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-tarif-country__body">
                                <h4 class="media-tarif-country__title font-n-b">{{$country->sub_title}}</h4>
                                <p class="media-tarif-country__desc">
                                    {{$country->sub_description}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-tarifs-order-how">
            <div class="container-lg">
                <h4 class="section-title text-center font-n-b">Sifarişləri hardan edək?</h4>
                <p class="section-desc text-center">Sifarişlərinizi Türkiyənin, Amerikanın, İngiltərənin, İspaniyanın müxtəlif mağazalardan edə bilərsiniz</p>
                <ul class="nav nav-shops justify-content-start justify-content-md-between">
                    <li class="nav-shops__item nav-shops__item--active">
                        <a href="#" class="nav-shops__link">Bütün mağazalar</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">Aksessuar</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">Geyim</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">Elektronika</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">İdman</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">Kosmetika</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">Kitab</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link">Baxım</a>
                    </li>
                </ul>
                <div class="row align-items-center">
                    @foreach($sellers as $seller)
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="thumbnail thumbnail-shops d-flex justify-content-center align-items-center">
                                <a href="#" class="thumbnail-shops__link">
                                    <img class="thumbnail-shops__img" src="{{$seller->img}}" alt="Shop">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{route("sellers_page", ['locale' => App::getLocale()])}}" class="btn btn-trns-yellow btn-shops">Daha çoxunu göstər</a>
                </div>
            </div>
        </section>
        <section class="section section-tarifs-calculator">
            <div class="container-lg">
                <div class="media media-tarifs-country">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xxl-6 col-xl-5 d-none d-xl-block">
                            <div class="media-tarifs-country__left">
                                <img class="media-tarifs-country__img img-fluid" src="/web/images/content/tarif-calculator.png" alt="Tarif">
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-7">
                            <div class="media-tarifs-country__body">
                                <form class="form form-calculator bg-white" name="formCalculator" id="formCalculator" method="post" action="/" novalidate="novalidate">
                                    <div class="row">
                                        <h1 class="form-calculator__title font-n-b">{!! __('static.calculator') !!}</h1>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcCountry">{!! __('static.country') !!}</label>
                                                    <div class="form__select-wrapper">
                                                        <select class="form__select" name="country" id="calcCountry" required>
                                                            <option value="null" disabled selected>Ölkə seçin</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->id}}">{{$country->name}} - {!! __('static.baku') !!}</option>
                                                            @endforeach
                                                        </select>
                                                        <label id="calcCountryErrorMessage" class="form-error-text" for="calcCountry"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcTransferType">{!! __('static.type') !!}</label>
                                                    <div class="form__select-wrapper">
                                                        <select class="form__select" name="type" id="calcTransferType" required>
                                                            @foreach($types as $type)
                                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcWeightType">{!! __('static.unit') !!}</label>
                                                    <div class="form__select-wrapper">
                                                        <select class="form__select" name="unit" id="calc_weight_type" required>
                                                            <option value="kq">kg</option>
                                                            <option value="gm">g</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcWide">En</label>
                                                    <input class="form__input" name="length" type="text" id="calcWide"
                                                           placeholder="En (sm)" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcWidth">Uzunluq</label>
                                                    <input class="form__input" name="width" type="text" id="calcWidth"
                                                           placeholder="Uzunluq (sm)" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcHeight">Hündürlük</label>
                                                    <input class="form__input" name="height" type="text" id="calcHeight"
                                                           placeholder="Hündürlük" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcWeght">Çəki</label>
                                                    <input class="form__input" name="weight" type="text" id="calcWeght"
                                                           placeholder="Çəki" required>
                                                    <label id="calcWeghtErrorMessage" class="form-error-text" for="calcWeght"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button class="btn btn-yellow form__btn form-calculator__btn font-n-b"
                                                            name="formCalculatorSubmit" type="submit">Hesabla</button>
                                                </div>
                                                <p id="amount" class="form-calculator__result text-center font-n-b"> 00.0</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-blogs">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{{$title->blogs}}</h1>
                <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-sm-4">
                            <div class="thumbnail thumbnail-blogs">
                                <a href="#" class="thumbnail-blogs__link">
                                    <div class="thumbnail-blogs__img-block">
                                        <img class="thumbnail-blogs__img img-responsive" src="{{$blog->icon}}" alt="Blog">
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <section class="section section-questions">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{{$title->feedback}}</h1>
                <div class="accordion accordion-questions" id="accordionQuestions">

                    <div class="row">
                        @foreach($faqs->chunk(6) as $faqChunk)
                            <div class="col-md-6">
                                @foreach($faqChunk as $faq)
                                    <div class="accordion-item accordion-questions__item">
                                        <h2 class="accordion-header accordion-questions__header">
                                            <button class="accordion-button accordion-questions__button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="false">
                                                {{$faq->name}}
                                            </button>
                                        </h2>
                                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionQuestions{{$faq->id}}">
                                            <div class="accordion-body accordion-questions__body">
                                                {!! $faq->content !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var defaultTab = document.querySelector('.nav-tab-categories__link.active');
            if (defaultTab) {
                var target = defaultTab.getAttribute('href');
                document.querySelector(target).classList.add('show', 'active');
                defaultTab.classList.add('active');
            }


            var tabLinks = document.querySelectorAll('.nav-tab-categories__link');
            tabLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    document.querySelectorAll('.tab-pane').forEach(function(tab) {
                        tab.classList.remove('show', 'active');
                    });
                    tabLinks.forEach(function(link) {
                        link.classList.remove('active');
                    });

                    link.classList.add('active');
                    var target = link.getAttribute('href');
                    document.querySelector(target).classList.add('show', 'active');
                });
            });
        });
    </script>
@endsection
