@extends('web.layouts.web')
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
{{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['tariff'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link nav-breadcrumbs__item--active">{!! __('breadcrumbs.tariff') !!}</a>
    </li>
@endsection

@section('title')
    {{$menu['tariff']->{'title_' . App::getLocale()} }}
@endsection

@section('description')
    {{$menu['tariff']->{'description_' . App::getLocale()} }}
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-tarifs">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{{$title->international_delivery}}</h1>

                <div class="country-carousel-container">
                    <div class="country-carousel">
                        <div class="country-carousel-track">
                            @foreach($countries as $country)
                                <div class="country-carousel-item">
                                    <div class="thumbnail thumbnail-tarifs">
                                        <a href="{{ route('menuIndex',['locale' => App::getLocale(),$country->slug]) }}" class="thumbnail-tarifs__link">
                                            <div class="thumbnail-tarifs__img-block">
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
                    <button class="country-carousel-nav country-carousel-prev">&lt;</button>
                    <button class="country-carousel-nav country-carousel-next">&gt;</button>
                </div>
            </div>
        </section>

        @if($text->name1!=null && $text->name1!='')

        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h4 class="media-tarif-country__title align-text-custom">A{{$text->name1}}</h4>
                            <p class="media-tarif-country__desc">
                                {{$text->content1}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif


        @if($text->name2!=null && $text->name2!='')

            <section class="section section-tarifs-country">
                <div class="container-lg">
                    <div class="media media-tarif-country">
                        <div class="row">
                            <div class="media-tarif-country__body">
                                <h4 class="media-tarif-country__title align-text-custom">{{$text->name2}}</h4>
                                <p class="media-tarif-country__desc">
                                    {{$text->content2}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif



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

        @if($text->name3!=null && $text->name3!='')
        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h4 class="media-tarif-country__title align-text-custom">{{$text->name3}}</h4>
                            <p class="media-tarif-country__desc">
                                {{$text->content3}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <section class="section section-calculator">
            <div class="container-lg">
                <form class="form form-calculator" name="formCalculator" id="formCalculator" novalidate="novalidate">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-block d-md-none">
                            <h2 class="form-calculator__title font-n-b">{!! __('static.calculator') !!}</h2>
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

        @if(count($blogs)>0)
        <section class="section section-blogs section-margin-top">
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
        @endif
        @if(count($faqs)>0)
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
        @endif

    </div>
@endsection

@section('styles')
    <style>
        .breadcrumb-nav {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .breadcrumb-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb-item {
            font-size: 14px;
            color: #6c757d;
            display: flex;
            align-items: center;
        }

        .breadcrumb-link {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            transition: color 0.3s ease-in-out;
        }

        .breadcrumb-link:hover {
            color: #0056b3;
        }

        .breadcrumb-item:not(:last-child)::after {
            content: "›";
            margin-left: 8px;
            color: #6c757d;
            font-weight: bold;
        }

        .breadcrumb-item[aria-current] {
            font-weight: 600;
            color: #343a40;
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
            .thumbnail-tarifs__img-block{
                text-align: center;
            }
        }

        .country-carousel-container {
            position: relative;
            margin: 0 auto;
            max-width: 100%;
            overflow: hidden;
        }

        .country-carousel {
            position: relative;
            overflow: hidden;
            margin: 0 40px;
        }

        .country-carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .country-carousel-item {
            flex: 0 0 25%; /* 4 items per slide */
            max-width: 25%;
            padding: 0 15px;
            box-sizing: border-box;
        }

        .country-carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .country-carousel-nav:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .country-carousel-prev {
            left: 0;
        }

        .country-carousel-next {
            right: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .country-carousel-item {
                flex: 0 0 33.333%;
                max-width: 33.333%;
            }
        }

        @media (max-width: 767px) {
            .country-carousel-item {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 575px) {
            .country-carousel-item {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .country-carousel {
                margin: 0 30px;
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

    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.country-carousel-track');
        const items = document.querySelectorAll('.country-carousel-item');
        const prevButton = document.querySelector('.country-carousel-prev');
        const nextButton = document.querySelector('.country-carousel-next');

        if (!track || items.length === 0) return;

        // Calculate how many items to show per slide based on screen width
        const getItemsPerSlide = () => {
            if (window.innerWidth <= 575) return 1;
            if (window.innerWidth <= 767) return 2;
            if (window.innerWidth <= 991) return 3;
            return 4; // Default: 4 items per slide
        };

        let itemsPerSlide = getItemsPerSlide();
        let currentIndex = 0;
        const totalItems = items.length;

        // Clone first and last items for infinite loop effect
        function setupCarousel() {
            // Remove any existing clones
            const clones = document.querySelectorAll('.country-carousel-clone');
            clones.forEach(clone => clone.remove());

            // Clone first items and append to end
            for (let i = 0; i < itemsPerSlide; i++) {
                const clone = items[i].cloneNode(true);
                clone.classList.add('country-carousel-clone');
                track.appendChild(clone);
            }

            // Clone last items and prepend to beginning
            for (let i = totalItems - 1; i >= totalItems - itemsPerSlide; i--) {
                if (i >= 0) {
                    const clone = items[i].cloneNode(true);
                    clone.classList.add('country-carousel-clone');
                    track.insertBefore(clone, track.firstChild);
                }
            }

            // Set initial position to show first real slide
            currentIndex = 0;
            updateCarouselPosition(false);
        }

        // Update carousel position based on currentIndex
        function updateCarouselPosition(animate = true) {
            const itemWidth = items[0].offsetWidth;
            const offset = -((currentIndex + itemsPerSlide) * itemWidth);

            if (!animate) {
                track.style.transition = 'none';
            } else {
                track.style.transition = 'transform 0.5s ease-in-out';
            }

            track.style.transform = `translateX(${offset}px)`;

            if (!animate) {
                // Force a reflow to make the transition removal take effect immediately
                track.offsetHeight;
                track.style.transition = 'transform 0.5s ease-in-out';
            }
        }

        // Handle next button click
        function moveNext() {
            currentIndex++;
            updateCarouselPosition();

            // If we've moved past the last original item
            if (currentIndex >= totalItems) {
                // Wait for transition to complete then reset to first item without animation
                setTimeout(() => {
                    currentIndex = 0;
                    updateCarouselPosition(false);
                }, 500);
            }
        }

        // Handle previous button click
        function movePrev() {
            currentIndex--;
            updateCarouselPosition();

            // If we've moved before the first original item
            if (currentIndex < 0) {
                // Wait for transition to complete then reset to last item without animation
                setTimeout(() => {
                    currentIndex = totalItems - 1;
                    updateCarouselPosition(false);
                }, 500);
            }
        }

        // Add event listeners
        nextButton.addEventListener('click', moveNext);
        prevButton.addEventListener('click', movePrev);

        // Handle resize events
        window.addEventListener('resize', function() {
            const newItemsPerSlide = getItemsPerSlide();
            if (newItemsPerSlide !== itemsPerSlide) {
                itemsPerSlide = newItemsPerSlide;
                setupCarousel();
            } else {
                updateCarouselPosition(false);
            }
        });

        // Initialize carousel
        setupCarousel();

        // Auto-advance the carousel every 5 seconds
        let autoplayInterval = setInterval(moveNext, 5000);

        // Pause autoplay on hover
        const carouselContainer = document.querySelector('.country-carousel-container');
        carouselContainer.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });

        carouselContainer.addEventListener('mouseleave', () => {
            autoplayInterval = setInterval(moveNext, 5000);
        });
    });


</script>


@endsection
