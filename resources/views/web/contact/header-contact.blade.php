@extends('web.layouts.web')
@section('content')
<div class="content" id="content">
    <section class="section section-contact">
        <div class="container-lg">
            <h1 class="section-title text-center font-n-b">Bizimlə əlaqə</h1>
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <form class="form form-tracking-search" name="formTrackingSearch" id="formTrackingSearch" method="post" action="/" novalidate="novalidate">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form__group">
                                    <label class="form__label" for="trackNumber">Trek nömrə</label>
                                    <input class="form__input" name="track_number" type="text" id="trackNumber" placeholder="Trek nömrəni yazın" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-yellow btn-block form__btn form-tracking-search__btn font-n-b" name="formTrackingSearchGlobalSubmit" type="submit">Qlobal axtarış</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-trns-yellow btn-block form__btn form-tracking-search__btn font-n-b" name="formTrackingSearchAserdaSubmit" type="submit">Aserdə axtar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-md-5">
                    <ul class="nav nav-contact flex-column">
                        <li class="nav nav-contact__item">
                            <img class="nav-contact__img" src="{{asset('web/images/content/contact-map.png')}}" alt="Contact">
                            <span class="nav-contact__title">{!! __('static.address_text_footer') !!},</span>
                        </li>
                        <li class="nav nav-contact__item">
                            <img class="nav-contact__img" src="{{asset('web/images/content/contact-phone-2.png')}}" alt="Contact">
                            <span class="nav-contact__title">(+994) 12 310 39 39</span>
                        </li>
                        <li class="nav nav-contact__item">
                            <img class="nav-contact__img" src="{{asset('web/images/content/contact-email-2.png')}}" alt="Contact">
                            <span class="nav-contact__title">info@colibri.az</span>
                        </li>
                    
                    </ul>
                    <div class="workhours">
                        <img class="nav-contact__img" src="{{asset('web/images/content/contact-clock.png')}}" alt="Contact">
                        <p class="workhours__desc">{!! $general_settings->{"working_hours_" . \Illuminate\Support\Facades\App::getLocale()} !!} </p>
                    </div>
                    
                    <p class="section-contact__text font-n-b">Bizi sosial şəbəkələrdən izləyin</p>
                    <ul class="nav nav-socials">
                        <li class="nav-socials__item d-flex justify-content-center align-items-center">
                            <a href="#" class="nav-socials__link">
                                <img class="nav-socials__img" src="{{asset('web/images/content/social-facebook.png')}}" alt="Facebook">
                            </a>
                        </li>
                        <li class="nav-socials__item d-flex justify-content-center align-items-center">
                            <a href="#" class="nav-socials__link">
                                <img class="nav-socials__img" src="{{asset('web/images/content/social-instagram.png')}}" alt="Instagram">
                            </a>
                        </li>
                        <li class="nav-socials__item d-flex justify-content-center align-items-center">
                            <a href="#" class="nav-socials__link">
                                <img class="nav-socials__img" src="{{asset('web/images/content/social-youtube.png')}}" alt="Youtube">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection