@extends('web.layouts.web')

@section('title')
    {{$delivery->ceo_title}}
@endsection

@section('description')
    {{$delivery->seo_description }}
@endsection
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item ">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['logistics'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link">{!! __('breadcrumbs.logistics') !!}</a>
    </li>
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{{$delivery->name}}</li>
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-cargo-service">
            <div class="container-lg">
                <div class="media media-cargo-service">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="media-cargo-service__body">
                                <h1 class="media-cargo-service__title font-n-b">{{$delivery->name}}</h1>
                                <p class="media-cargo-service__desc">
                                   {!! $delivery->content !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-cargo-service__right">
                                <img class="media-cargo-service__img img-responsive" src="{{$delivery->internal_images}}" alt="Cargo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-contact section-margin-bottom">
            <div class="container-lg">
                <div class="section-contact__block center-block">
                    <form  class="form form-contact" name="formContact" id="formContact" method="post" action="{{route('send_feedback',['locale' => App::getLocale()])}}" novalidate="novalidate">
                    <h3 class="form-contact__title text-center font-n-b">{{$title->feedback}}</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userName">Ad</label>
                                    <input class="form__input" name="user_name" type="text" id="userName" placeholder="Adınızı daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSurname">Soyad</label>
                                    <input class="form__input" name="user_surname" type="text" id="userSurname" placeholder="Soyadınızı daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userEmail">Email</label>
                                    <input class="form__input" name="user_email" type="email" id="userEmail" placeholder="Emailiniz daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPhone">Telefon</label>
                                    <input class="form__input" name="user_phone" type="text" id="userPhone" placeholder="Telefon nömrənizi daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form__group">
                                    <label class="form__label" for="userMessage">Mesaj</label>
                                    <textarea class="form__textarea" name="user_message" id="userMessage" rows="6" placeholder="Mesajınızı yazın......" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-8">

                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-yellow btn-block form__btn form-contact__btn font-n-b" name="formContactSubmit" type="submit">Göndər</button>
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