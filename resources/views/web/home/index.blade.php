@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-main">
            <div class="container-lg">
                <div class="owl-carousel owl-main owlMain">
                    @foreach($carousels as $carousel)
                    <div class="owl-main__item">
                        <div class="media media-slider center-block">
                            <div class="row justify-content-center align-items-center carousel-locale">
                                <div class="col">
                                    <div class="media-slider__left">
                                        <h2 class="media-slider__title font-n-b">{{$carousel->name}}</h2>
                                        <p class="media-slider__desc">{{$carousel->content}}</p>
                                        @if($carousel->link != null)
                                        <a href="{{$carousel->link}}" class="btn btn-yellow media-slider__link font-n-b">Ətraflı</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col d-none d-sm-block">
                                    <div class="media-slider__right">
                                        <img class="media-slider__img img-responsive"
                                             src="{{$carousel->icon}}" alt="Slider">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
                </div>
            </div>
        </section>
        <section class="section section-works">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->how_it_work}}</h2>
                <div class="row">
                    @foreach($works as $work)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="thumbnail thumbnail-works">
                            <div class="thumbnail-works__img-block">
                                <img class="thumbnail-works__img img-responsive"
                                     src="{{$work->icon}}" alt="Work">
                            </div>
                            <div class="thumbnail-works__caption text-center">
                                <h4 class="thumbnail-works__title font-n-b">{{$work->name}}</h4>
                                <p class="thumbnail-works__desc">{{$work->content}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-works-video">
            <div class="container-lg">

                <div class="media media-works">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6">
                            <div class="media-works__left">

                                <iframe class="media-works__iframe" width="100%" height="320"
                                        src="https://www.youtube.com/embed/sq_Ubu0by9k"
                                        allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="media-works__right">
                                <h2 class="section-title  font-n-b">{{$title->video}}</h2>
                                <p class="media-works__title">
                                    {{$contents->video}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-tarifs">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->international_delivery}}</h2>
                <div class="container">
                    <div class="row centered-row">
                            <div class="titles-content">
                                <p class="media-titles-content">
                                   {{$contents->international_delivery}}
                                </p>
                        </div>
                    </div>
                </div>




                <div class="row">
                    @foreach($countries as $country)
                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail thumbnail-tarifs">
                                <a href="{{ route('menuIndex',
                                        ['locale' => App::getLocale(),$country->slug]) }}" class="thumbnail-tarifs__link">
                                    <div class="thumbnail-tarifs__img-block text-center">
                                        <img class="thumbnail-tarifs__img img-responsive" src="{{$country->icon}}" alt="Tarif">
                                    </div>
                                    <div class="thumbnail-tarifs__caption text-center">
                                        <h4 class="thumbnail-tarifs__title font-n-b">{{$country->name}}</h4>
                                        <p class="thumbnail-tarifs__desc">
                                            {{$country->cover_description}}

                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-offers">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->corporative_logistics}}</h2>
                <div class="container">
                    <div class="row centered-row">
                        <div class="titles-content">
                            <p class="media-titles-content">
                                {{$contents->corporative_logistics}}

                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($deliveries as $deliverie)
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-cargo">
                            <a href="{{ route('menuIndex',['locale' => App::getLocale(),$deliverie->slug]) }}" class="thumbnail-cargo__link">
                                <div class="thumbnail-cargo__img-block">
                                    <img class="thumbnail-cargo__img img-responsive" src="{{$deliverie->icon}}" alt="Cargo">
                                </div>
                                <div class="thumbnail-cargo__caption text-center">
                                    <h4 class="thumbnail-cargo__title font-n-b">{{$deliverie->name}}</h4>
                                    <p class="thumbnail-cargo__desc">
                                       {{$deliverie->content}}
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-services">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->services}}</h2>
                <div class="row">
                    @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $service->slug]) }}" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block text-center">
                                    <img class="thumbnail-services__img img-responsive" src="{{$service->icon}}" alt="Service">
                                
                                    <h6 class="thumbnail-services__title text-center font-n-b">{{$service->name}}</h6>
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
                            <h1 class="media-tarif-country__title font-n-b">{{$text->name}}</h1>
                            <p class="media-tarif-country__desc">
                               {{$text->content}}
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
                    @foreach($partners as $partner)
                    <div class="owl-partners__item">
                        <div class="thumbnail thumbnail-partners d-flex justify-content-center align-items-center">
                            <div class="thumbnail-partners__img-block">
                                <img class="thumbnail-partners__img img-responsive"
                                     src="{{$partner->icon}}" alt="Partner">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-calculator">
            <div class="container-lg">
                <form class="form form-calculator" name="formCalculator" id="formCalculator" novalidate="novalidate">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-block d-md-none">
                            <h2 class="form-calculator__title font-n-b">{!! __('static.calculator') !!}</h2>
                            <p class="form-calculator__desc">{!! __('static.calculate_text') !!} </p>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form__group">
                                        <label class="form__label" for="calcCountry">{!! __('static.country') !!}</label>
                                        <div class="form__select-wrapper">
                                            <select class="form__select" name="country" id="calcCountry" required>
                                                <option  disabled selected>Ölkə seçin</option>
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
                                                <option value="gm">gr</option>
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
                                                name="formCalculatorSubmit" type="button">Hesabla</button>
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
                <h2 class="section-title text-center font-n-b">{{$title->blogs}}</h2>
                <div class="row">
                    @foreach($blogs as $blog)
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $blog->slug]) }}" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="{{ $blog->icon }}" alt="Blog">

                                </div>
                                <h4 class="thumbnail-blog-2__title font-n-b">{{$blog->name}}</h4>
                            </a>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>
        </section>
        <section class="section section-questions">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->faqs}}</h2>
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
        .thumbnail-blog-2__title{
            margin-top: 10px;
            color: black;
            text-align: center;
        }
        .media-tarif-country__title{
            text-align: center;
        }
        .thumbnail-services__img{
            border-radius: 10px;
            height: 200px;
            width: 250px;
        }
        .centered-row {
            display: flex;
            justify-content: center;
            align-items: center;
            /*height: 100vh;*/
        }

        .titles-content p {
            text-align: center;
            margin-bottom: 50px;
            width: 70%;
            box-sizing: border-box;
            margin-left: auto;
            margin-right: auto;

        }
        .media-slider__img{
            border-radius: 50%;
        }
        
        /*.carousel-locale{*/
        /*    width: 70vw;*/
        /*}*/
        @media only screen and (max-width: 992px) {
            .thumbnail-services__img{
                height: 170px;
                width: 230px;
            }
        }
        @media only screen and (max-width: 767px) {
            .thumbnail-tarifs__img{
                width: 75%;
            }
            .titles-content p{
                width: 90%;
            }
            .thumbnail-tarifs__desc, .thumbnail-works__desc, .thumbnail-cargo__desc{
                width: 90%; 
                text-align: center; 
                margin: 0 auto;
            }
        }




    </style>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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


@endsection