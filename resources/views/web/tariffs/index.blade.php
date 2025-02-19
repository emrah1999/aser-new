@extends('web.layouts.web')
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
{{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{!! __('breadcrumbs.tariff') !!}</li>
@endsection

@section('content')
    <div class="content" id="content">
        <section class="section section-tarifs">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->international_delivery}}</h2>
                <div class="row">
                    @foreach($countries as $country)
                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail thumbnail-tarifs">
                                <a href="
                                {{ route('show_tariffs', ['locale' => App::getLocale(), 'country_id' => $country->id]) }}
                                    " class="thumbnail-tarifs__link">
                                    <div class="thumbnail-tarifs__img-block">
                                        <img class="thumbnail-tarifs__img img-responsive" src="{{$country->icon}}" alt="Tarif">
                                    </div>
                                    <div class="thumbnail-tarifs__caption text-center">
                                        <h4 class="thumbnail-tarifs__title font-n-b">{{$country->name}}</h4>
                                        <p class="thumbnail-tarifs__desc">
                                            {{$country->content}}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h1 class="media-tarif-country__title font-n-b">{{$text->name1}}</h1>
                            <p class="media-tarif-country__desc">
                                {{$text->content1}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h1 class="media-tarif-country__title font-n-b">{{$text->name2}}</h1>
                            <p class="media-tarif-country__desc">
                                {{$text->content2}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="section section-partners">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->partners}}</h2>
                <div class="owl-carousel owl-partners owlPartners">
                    @foreach($sellers as $seller)
                        <div class="owl-partners__item">
                            <div class="thumbnail thumbnail-partners d-flex justify-content-center align-items-center">
                                <div class="thumbnail-partners__img-block">
                                    <img class="thumbnail-partners__img img-responsive"
                                         src="{{$seller->img}}" alt="Partner">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h1 class="media-tarif-country__title font-n-b">{{$text->name3}}</h1>
                            <p class="media-tarif-country__desc">
                                {{$text->content3}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-calculator">
            <div class="container-lg">
                <form class="form form-calculator" name="formCalculator" id="formCalculator"
                      novalidate="novalidate">
                    <div class="row">
                        <div class="col-md-12 d-block d-md-none">
                            <h1 class="form-calculator__title font-n-b">{!! __('static.calculator') !!}</h1>
                            <p class="form-calculator__desc">{!! __('static.calculate_text') !!}</p>
                        </div>
                        <div class="col-md-7">
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
                        <div class="col-md-5 d-none d-md-block">
                            <p class="form-calculator__title font-n-b">{!! __('static.calculator') !!}</p>
                            <p class="form-calculator__desc">{!! __('static.calculate_text') !!} </p>
                        </div>
                    </div>
                </form>
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
                <h1 class="section-title text-center font-n-b">{{$title->faqs}}</h1>
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

@section('styles')
    <style>
        /* Breadcrumb Nav */
        .breadcrumb-nav {
            background-color: #f8f9fa; /* Açıq boz arxa fon */
            padding: 10px 15px;
            border-radius: 5px;
        }

        /* Breadcrumb List */
        .breadcrumb-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px; /* Elementlər arasında boşluq */
        }

        /* Breadcrumb Item */
        .breadcrumb-item {
            font-size: 14px;
            color: #6c757d; /* Boz rəng */
            display: flex;
            align-items: center;
        }

        /* Breadcrumb Link */
        .breadcrumb-link {
            text-decoration: none;
            color: #007bff; /* Mavi rəng */
            font-weight: 500;
            transition: color 0.3s ease-in-out;
        }

        .breadcrumb-link:hover {
            color: #0056b3; /* Daha tünd mavi */
        }

        /* Breadcrumb Separators */
        .breadcrumb-item:not(:last-child)::after {
            content: "›"; /* Ayırıcı işarəsi */
            margin-left: 8px;
            color: #6c757d;
            font-weight: bold;
        }

        /* Aktiv Breadcrumb */
        .breadcrumb-item[aria-current] {
            font-weight: 600;
            color: #343a40; /* Qara rəng */
        }

    </style>
@endsection
