@extends('web.layouts.web')
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['contact'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link nav-breadcrumbs__item--active">{!! __('breadcrumbs.contacs') !!}</a>
    </li>
@endsection

@section('title')
    {{$menu['contact']->{'title_' . App::getLocale()} }}
@endsection

@section('description')
    {{$menu['contact']->{'description_' . App::getLocale()} }}
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
    <section class="section section-contact">
        <div class="container-lg">
            <h1 class="section-title text-center font-n-b">{{$title->contacts}}</h1>
            <div class="section-contact__block center-block">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-contact text-center">
                            <div class="thumbnail-contact__img-block">
                                <img class="thumbnail-contact__img" src="{{asset('web/images/content/contact-phone.png')}}" alt="Contact">
                            </div>
                            <div class="thumbnail-contact__caption">
                                <h6 class="thumbnail-contact__title font-n-b">Bizə zəng edin</h6>
                                <p class="thumbnail-contact__desc">(+994) 12 310 07 09</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-contact text-center">
                            <div class="thumbnail-contact__img-block">
                                <img class="thumbnail-contact__img" src="{{asset('web/images/content/contact-email.png')}}" alt="Contact">
                            </div>
                            <div class="thumbnail-contact__caption">
                                <h6 class="thumbnail-contact__title font-n-b">Email</h6>
                                <p class="thumbnail-contact__desc">info@asercargo.az</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-contact text-center">
                            <div class="thumbnail-contact__img-block">
                                <img class="thumbnail-contact__img" src="{{asset('web/images/content/contact-media.png')}}" alt="Contact">
                            </div>
                            <div class="thumbnail-contact__caption">
                                <h6 class="thumbnail-contact__title font-n-b">Sosial media</h6>
                                <ul class="nav nav-socials thumbnail-contact__nav-socials justify-content-center align-items-center">
                                    <li class="nav-socials__item thumbnail-contact__nav-socials-item d-flex justify-content-center align-items-center">
                                        <a href="https://www.facebook.com/share/1Dkj88UQxV/"  class="nav-socials__link thumbnail-contact__nav-socials-link">
                                            <img class="nav-socials__img thumbnail-contact__nav-socials-img" src="{{asset('web/images/content/social-facebook.png')}}" alt="Facebook">
                                        </a>
                                    </li>
                                    <li class="nav-socials__item thumbnail-contact__nav-socials-item d-flex justify-content-center align-items-center">
                                        <a href="https://www.instagram.com/asercargo.az?igsh=OWxraHl6Nm5jbml2"
                                           class="nav-socials__link thumbnail-contact__nav-socials-link">
                                            <img class="nav-socials__img thumbnail-contact__nav-socials-img" src="{{asset('web/images/content/social-instagram.png')}}" alt="Instagram">
                                        </a>
                                    </li>
                                    <li class="nav-socials__item thumbnail-contact__nav-socials-item d-flex justify-content-center align-items-center">
                                        <a href="https://youtube.com/@asercargo" class="nav-socials__link thumbnail-contact__nav-socials-link">
                                            <img class="nav-socials__img thumbnail-contact__nav-socials-img" src="{{asset('web/images/content/social-youtube.png')}}" alt="Youtube">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-contact text-center">
                            <div class="thumbnail-contact__img-block">
                                <img class="thumbnail-contact__img" src="{{asset('web/images/content/contact-address.png')}}" alt="Contact">
                            </div>
                            <div class="thumbnail-contact__caption">
                                <h6 class="thumbnail-contact__title font-n-b">Ünvan</h6>
                                <p class="thumbnail-contact__desc">Abbasqulu Ağa Bakıxanov küç, 92</p>
                            </div>
                        </div>
                    </div>
                </div>
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
            </div>
        </div>
    </section>
</div>
@endsection
@section('styles')
    <style>
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