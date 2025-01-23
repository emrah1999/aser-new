@extends('web.layouts.web')
@section('styles')
    <style>
        .custom-alert {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 9999;
            padding: 15px 20px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: opacity 0.5s ease;
        }
    </style>

@endsection
    @section('content')

<div class="content" id="content">
    <section class="section section-profile-addresses">
        <div class="container-lg">
            <div class="row">
                @include("web.account.account_left_bar")
                <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                    <div class="profile-title-block">
                        <div class="row">
                            <div class="col-xxl-8">
                                <h4 class="profile-title-block__title font-n-b">Xaricdəki ünvanlarım</h4>
                            </div>
                            <div class="col-xxl-4">

                            </div>
                        </div>
                    </div>
                    <div class="nav nav-tab-categories">
                        @php
                            $currentCountryId = request()->route('country_id');
                        @endphp
                        @foreach($countries as $country)
                            <a href="{{ route('get_country_details', ['locale' => App::getLocale(), 'country_id' => $country->id]) }}"
                               class="nav-tab-categories__link flex-fill d-flex justify-content-center align-items-center {{ $currentCountryId == $country->id ? 'nav-tab-categories__link--active active' : '' }}">
                                <img class="nav-tab-categories__link-img" src="{{ $country->new_flag }}">
                                <span class="nav-tab-categories__link-title d-none d-md-block"> {{ $country->name }}</span>
                            </a>
                        @endforeach
                    </div>
                    <div class="tab-content tab-content-categories">
                        <div class="tab-pane fade show active" id="turkey">
                            @foreach($details as $detail)
                                @php($information = $detail->information)
                                @php($information = str_replace('{name_surname}', Auth::user()->full_name(), $information))
                                @php($information = str_replace('{aser_id}', Auth::user()->suite(), $information))

                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start">
                                    <div class="thumbnail-profile-addresses__caption">
                                        <h6 class="thumbnail-profile-addresses__title">{{$detail->title}}</h6>
                                        <p class="thumbnail-profile-addresses__desc">{{$information}}</p>
                                    </div>
                                    <div class="thumbnail-profile-addresses__img-block" onclick="copyToClipboardAddress('{{$information}}')">
                                        <img
                                                class="thumbnail-profile-addresses__img"
                                                src="/web/images/content/profile-file.png"
                                                alt="Profile"
                                                style="cursor: pointer;">

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('css')

@endsection
@section('scripts')
    <script>
        // window.alert fonksiyonunu özelleştir
        window.alert = function (message) {
            // Alert kutusunu oluştur
            const alertBox = document.createElement("div");
            alertBox.className = "custom-alert";
            alertBox.innerText = message;

            // Sayfaya ekle
            document.body.appendChild(alertBox);

            // 3 saniye sonra kaybolmasını ayarla
            setTimeout(() => {
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500); // Tamamen kaldır
            }, 3000);
        };

        // Mevcut kopyalama fonksiyonu
        function copyToClipboardAddress(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert("Kopyalandı: " + text); // Özelleştirilmiş alert çalışır
                })
                .catch(err => {
                    console.error("Error", err);
                });
        }
    </script>


@endsection