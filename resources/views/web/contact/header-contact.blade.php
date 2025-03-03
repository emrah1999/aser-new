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
    <div class="content" id="content">
        <section class="section section-contact">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{{$title->contacts}}</h1>
                <div class="row">
                    <br>
                    <div class="col-lg-6">
                        <div class="media-branches__left">
                            <iframe class="media-branches__map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d759.7081685227259!2d49.84359226553985!3d40.39040094792123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307d30e58f34c5%3A0xdbd9946f959d9e!2sAser%20Cargo%20Express!5e0!3m2!1str!2saz!4v1726507917582!5m2!1str!2saz" width="100%" height="660" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                    <!-- Əlaqə məlumatları -->
                    <div class="col-lg-4 col-md-5">
                        <ul class="nav nav-contact flex-column">
                            <li class="nav nav-contact__item">
                                <img class="nav-contact__img" src="{{ asset('web/images/content/contact-map.png') }}" alt="Contact">
                                <span class="nav-contact__title">{!! __('static.address_text_footer') !!},</span>
                            </li>
                            <li class="nav nav-contact__item">
                                <img class="nav-contact__img" src="{{ asset('web/images/content/contact-phone-2.png') }}" alt="Contact">
                                <span class="nav-contact__title">(+994) 12 310 39 39</span>
                            </li>
                            <li class="nav nav-contact__item">
                                <img class="nav-contact__img" src="{{ asset('web/images/content/contact-email-2.png') }}" alt="Contact">
                                <span class="nav-contact__title">info@asercargo.az</span>
                            </li>
                        </ul>
                        <div class="workhours">
                            <img class="nav-contact__img" src="{{ asset('web/images/content/contact-clock.png') }}" alt="Contact">
                            <p class="workhours__desc">{!! $general_settings->{"working_hours_" . \Illuminate\Support\Facades\App::getLocale()} !!} </p>
                        </div>

                        <p class="section-contact__text font-n-b">Bizi sosial şəbəkələrdən izləyin</p>
                        <ul class="nav nav-socials">
                            <li class="nav-socials__item d-flex justify-content-center align-items-center">
                                <a href="https://www.facebook.com/people/Aser-Cargo/pfbid04EgswBfoXuLYbR94GVm8h8zuJ3PCocFT5bweeUA1aRtyGiGDgZXXhR3TwcDGPkZLl/" class="nav-socials__link">
                                    <img class="nav-socials__img" src="{{ asset('web/images/content/social-facebook.png') }}" alt="Facebook">
                                </a>
                            </li>
                            <li class="nav-socials__item d-flex justify-content-center align-items-center">
                                <a href="https://www.instagram.com/asercargo.az?igsh=OWxraHl6Nm5jbml2" class="nav-socials__link">
                                    <img class="nav-socials__img" src="{{ asset('web/images/content/social-instagram.png') }}" alt="Instagram">
                                </a>
                            </li>
                            <li class="nav-socials__item d-flex justify-content-center align-items-center">
                                <a href="https://youtube.com/@asercargo" class="nav-socials__link">
                                    <img class="nav-socials__img" src="{{ asset('web/images/content/social-youtube.png') }}" alt="Youtube">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
    <script>
        function initMap() {
            // Bakı şəhərinin koordinatları
            const location = { lat: 40.409264, lng: 49.867092 };

            // Xəritəni yarat
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: location,
            });

            // Marker əlavə et
            new google.maps.Marker({
                position: location,
                map: map,
                title: "Bakı şəhəri!",
            });
        }

        // Xəritəni yüklə
        window.onload = initMap;
    </script>
@endpush
