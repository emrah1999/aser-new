@extends('web.layouts.web')
@section('title')
    {{$country->ceo_title}}
@endsection

@section('description')
    {{$country->seo_description }}
@endsection

@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item ">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['tariff'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link ">{!! __('breadcrumbs.tariff') !!}</a>
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
                                <h1 class="media-tarif-country__title font-n-b">{{$country->name}}</h1>
                                <p class="media-tarif-country__desc">
                                    {!! $country->content !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-tarif-country__right">
                                <img class="media-tarif-country__img img-responsive" src="{{$country->internal_images}}" alt="Tarif">
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
                                        @foreach($tariffAll->where('type_id', 1) as $tariff)
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
                                <h4 style="margin-top: 20px" class="media-tarif-country__title font-n-b">{{$country->sub_title}}</h4>
                                <p class="media-tarif-country__desc">
                                    {{$country->sub_description}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="seller-section-unique section seller-section-tarifs-order-how">
            <div class="seller-section-unique container-lg">
                <h4 class="seller-section-unique section-title text-center font-n-b">Sifarişləri hardan edək?</h4>
                <p class="seller-section-unique section-desc text-center">
                    Sifarişlərinizi Türkiyənin, Amerikanın, İngiltərənin, İspaniyanın müxtəlif mağazalardan edə bilərsiniz
                </p>
                <ul class="seller-section-unique nav seller-section-nav-shops">
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="1">Aksessuar</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="2">Geyim</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="3">Elektronika</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="4">İdman</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="5">Kosmetika</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="6">Kitab</a>
                    </li>
                    <li class="nav-shops__item">
                        <a href="#" class="nav-shops__link" data-type="5">Baxım</a>
                    </li>
                </ul>
                <div id="sellers-list" class="seller-section-unique row align-items-center">
                </div>
                <div class="text-center">
                    <a  href="{{route("sellers_page", ['locale' => App::getLocale()])}}"  class="btn seller-btn" >Daha çoxunu göstər</a>
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
                                    @csrf
                                    <div class="row">
                                        <h2 class="form-calculator__title font-n-b">{!! __('static.calculator') !!}</h2>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form__group">
                                                    <label class="form__label" for="calcCountry">{!! __('static.country') !!}</label>
                                                    <div class="form__select-wrapper">
                                                        <select class="form__select" name="country" id="calcCountry" required>
                                                            <option value="null" disabled selected>Ölkə seçin</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->id}}">{{$country->name}}</option>
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
                <h2 class="section-title text-center font-n-b">{{$title->blogs}}</h2>
                <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-sm-4">
                            <div class="thumbnail thumbnail-blogs">
                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $blog->slug]) }}" class="thumbnail-blogs__link">
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
                <h2 class="section-title text-center font-n-b">{{$title->feedback}}</h2>
                <div class="accordion accordion-questions" id="accordionQuestions">

                    <div class="row">
                        @foreach($faqs as $faq)
                            <div class="col-md-6">
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
        .seller-btn{
            text-align: center;
        }
        .media-tarif-country__title{
            margin-bottom: 20px;
        }
        .section-tarifs-calculator{
            background-color:  #fdf9e9;
        }

        .seller-section-unique {
            font-family: Arial, sans-serif;
            text-align: center;
            width: 100%;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-desc {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .seller-section-nav-shops {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            border-bottom: 2px solid #eee;
            list-style: none;
        }

        .nav-shops__item a {
            text-decoration: none;
            color: #666;
            font-size: 16px;
            text-align: center;
        }

        .nav-shops__item--active a {
            color: #fbbf24; /* Sarı renk */
            font-weight: bold;
            position: relative;
        }

        .section-title {
            margin-bottom: 30px;
        }
        .section-desc{
            margin-bottom: 50px;

        }

        .nav-shops__item--active a::after {
            content: "";
            display: block;
            width: 100%;
            height: 3px;
            background-color: #fbbf24;
            position: absolute;
            bottom: -8px;
            left: 0;
        }

        .seller-logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .seller-thumbnail {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .seller-logo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .seller-btn {
            display: inline-block;
            background-color: #fbbf24;
            color: #000;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 20px;
            text-decoration: none;
        }

        .seller-btn:hover {
            background-color: #eab308;
        }

    </style>
@endsection

@section('scripts')
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            const navItems = document.querySelectorAll('.nav-shops__item');
            const sellersList = document.getElementById('sellers-list');
            const showMoreBtn = document.getElementById('show-more-btn');

            const defaultCategory = navItems[3];
            defaultCategory.classList.add('nav-shops__item--active');
            const defaultCategoryType = defaultCategory.querySelector('.nav-shops__link').getAttribute('data-type');
            const locale = document.documentElement.lang;
            loadSellers(locale, defaultCategoryType);

            navItems.forEach(function(item) {
                item.querySelector('.nav-shops__link').addEventListener('click', function(e) {
                    e.preventDefault();
                    navItems.forEach(function(nav) {
                        nav.classList.remove('nav-shops__item--active');
                    });
                    item.classList.add('nav-shops__item--active');
                    const categoryType = this.getAttribute('data-type');
                    loadSellers(locale, categoryType);
                });
            });

            function loadSellers(locale, type) {
                sellersList.innerHTML = '';
                fetch(`/` + locale + `/get-sellers/` + type)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function(seller) {
                            let sellerDiv = document.createElement('div');
                            sellerDiv.classList.add('col-xl-2', 'col-md-4', 'col-sm-6', 'seller-logo-container');
                            sellerDiv.innerHTML = `
                        <div class="seller-thumbnail">
                            <a href="${seller.url}">
                                <img class="seller-logo" src="${seller.img}" alt="${seller.name}">
                            </a>
                        </div>
                    `;
                            sellersList.appendChild(sellerDiv);
                        });
                        showMoreBtn.style.display = 'block';
                    })
                    .catch(error => console.log('Error:', error));
            }
        });




        $(".form-calculator__btn").click(function(e) {
            e.preventDefault();
            var formData = $('#formCalculator').serializeArray();
            $.ajax({
                url: "{{ route('calculate') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.case === "success") {
                        $("#amount").text(response.amount);
                    } else {
                        alert(response.content);
                    }
                },
                error: function() {
                }
            });
        });

    </script>
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
