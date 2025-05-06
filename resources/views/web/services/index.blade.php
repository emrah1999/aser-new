@extends('web.layouts.web')
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['services'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link nav-breadcrumbs__item--active">{!! __('breadcrumbs.services') !!}</a>
    </li>
@endsection

@section('title')
    {{$menu['services']->{'title_' . App::getLocale()} }}
@endsection

@section('description')
    {{$menu['services']->{'description_' . App::getLocale()} }}
@endsection


@section('content')
@if(session('success'))
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    <div class="content" id="content">
        <section class="section section-services">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{{$title->services}}</h1>
                <div class="row">

                    @foreach($services as $service)
                        <div class="col-md-4 col-sm-6">
                            <div class="thumbnail thumbnail-services">
                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $service->slug]) }}" class="thumbnail-services__link">
                                    <div class="thumbnail-services__img-block">
                                        <img class="thumbnail-services__img img-responsive" src="{{$service->icon}}" alt="Service">
                                    </div>
                                    <div class="thumbnail-services__caption">
                                        <h6 class="thumbnail-services__title text-center font-n-b">{{$service->name}}</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-tarifs-country section-margin-top" >
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h2 class="media-tarif-country__title font-n-b">{{$text->name}}</h2>
                            <p class="media-tarif-country__desc">
                                {{$text->content}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-contact">
            <div class="container-lg">
                <div class="section-contact__block center-block">
                    <form  class="form form-contact" name="formContact" id="formContact" method="post" action="{{route('send_feedback',['locale' => App::getLocale()])}}" novalidate="novalidate">
                        @csrf
                        <h3 class="form-contact__title text-center font-n-b">{{$title->contacts}}</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userName">{!! __('static.name1') !!}</label>
                                    <input class="form__input" name="name" type="text" id="userName" placeholder="{!! __('static.name1ph') !!}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSurname">{!! __('static.surname1') !!}</label>
                                    <input class="form__input" name="surname" type="text" id="userSurname" placeholder="{!! __('static.surname1ph') !!}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userEmail">{!! __('static.email1') !!}</label>
                                    <input class="form__input" name="email" type="email" id="userEmail" placeholder="{!! __('static.email1ph') !!}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPhone">{!! __('static.number1') !!}</label>
                                    <input class="form__input" name="phone" type="text" id="userPhone" placeholder="{!! __('static.number1ph') !!}" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form__group">
                                    <label class="form__label" for="userMessage">{!! __('static.message1') !!}</label>
                                    <textarea class="form__textarea" name="message" id="userMessage" rows="6" placeholder="{!! __('static.message1ph') !!}" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-8">

                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-yellow btn-block form__btn form-contact__btn font-n-b" name="formContactSubmit" type="submit">{!! __('static.submit1') !!}</button>
                            </div>
                        </div>
                    </form>
                </div>
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
        <section class="section section-questions section-margin-top">
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
        .media-tarif-country__title{
            text-align: center;
        }
        .thumbnail-services__img{
            border-radius: 10px;
            height: 320px;
        }
        @media only screen and (max-width: 767px) {
            .thumbnail-services__img{
                width: 75%;
                height: 75%;
            }

            .thumbnail-services__img-block{
                text-align: center;
            }
        }
        .alert {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .alert-content {
            display: flex;
            align-items: center;
        }

        .alert .fas {
            font-size: 24px;
            margin-right: 10px;
        }

        .alert span {
            font-size: 16px;
        }

       
    </style>
@endsection