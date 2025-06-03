@extends('web.layouts.web')
@section('styles')
    <style>
        .information{
            font-style: italic;
            margin-bottom: 15px;
        }
        .information-div{
            max-width: 15px;
        }
        .nav-tab-categories__link{
            margin-right: 10px;
        }

        .custom-alert {
            position: absolute;
            z-index: 9999;
            padding: 10px 15px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: white;
            background-color: var(--blue);
            border: 1px solid var(--blue);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: opacity 0.5s ease;
            opacity: 1;
            top: 50%;
            left: -120px;
            transform: translateY(-50%);
        }
        .color-style{
            height: 35px;
            width: 23px;
            margin-top: -5px;
        }

        .thumbnail-profile-addresses__img-block {
            color: var(--blue);
            position: relative;
        }
        .thumbnail-style{
            height: 55px;
        }
        .thumbnail-style2 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        
        @media (max-width: 800.98px) {
            
            .nav-tab-categories__link {
                margin-right: 4px;
            }
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
                                    <h4 class="profile-title-block__title font-n-b">{!! __('account_menu.my_account2') !!}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="nav nav-tab-categories">
                            @php
                                $currentCountryId = request()->route('country_id');
                            @endphp
                            @foreach($countries as $country)
                                <a href="{{ route('get_country_details', ['locale' => App::getLocale(), 'country_id' => $country->id]) }}"
                                   class="nav-tab-categories__link flex-fill d-flex justify-content-center align-items-center {{ $currentCountryId == $country->id ? 'nav-tab-categories__link--active mr-5 active' : '' }}">
                                    <img class="nav-tab-categories__link-img" src="{{ $country->new_flag }}">
                                    <span class="nav-tab-categories__link-title d-none d-md-block"> {{ $country->name }}</span>
                                </a>
                            @endforeach
                            <a href="{{route('get_country_details', ['locale' => App::getLocale(), 'country_id'=>'special'])}}" class="nav-tab-categories__link nav-tab-categories__link flex-fill d-flex justify-content-center align-items-center mr-5 {{ $currentCountry == 'special' ? 'nav-tab-categories__link--active mr-5 active' : '' }}">
                                <img  class="nav-tab-categories__link-img" src="https://asercargo.az/web/images/content/flag-usa.png" alt="">
                                <span class="nav-tab-categories__link-title d-none d-md-block">New York</span>

                            </a>
                        </div>
                        <div class="tab-content tab-content-categories">
                            <div class="tab-pane fade show active" id="turkey">
                                <div class="row">
                                    <div class=" information-div col-md-1">
                                        <img src="{{asset('uploads/static/info.png')}}"  height="15px" width="15px" data-toggle="tooltip" data-placement="right" >
                                    </div>

                                    <p class="information col-md-11 ">
                                      {!! __('static.newyork_text') !!}
                                    </p>
                                </div>

                                    <div class="account-address-info">
                                        <div class="cn-box">
                                            <div class="row form-element">
                                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                                    <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                                        <h6 class="thumbnail-profile-addresses__title">Address Line1:</h6>
                                                        <p class="thumbnail-profile-addresses__desc">1923 McDonald Ave
                                                            Brooklyn, NY11223</p>
                                                    </div>
                                                    <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('1923 McDonald Ave Brooklyn, NY11223', event)">
                                                        <img
                                                                class="thumbnail-profile-addresses__img color-style"
                                                                src="/web/images/content/profile-file.png"
                                                                alt="Profile"
                                                                style="cursor: pointer;">
                                                    </div>
                                                </div>
                                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                                    <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                                        <h6 class="thumbnail-profile-addresses__title">Address Line2:</h6>
                                                        <p class="thumbnail-profile-addresses__desc">{{ auth()->id() }},  Aser Cargo Express
                                                        </p>
                                                    </div>
                                                    <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('{{ auth()->id() }},  Aser Cargo Express ', event)">
                                                        <img
                                                                class="thumbnail-profile-addresses__img color-style"
                                                                src="/web/images/content/profile-file.png"
                                                                alt="Profile"
                                                                style="cursor: pointer;">
                                                    </div>
                                                </div>
                                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                                    <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                                        <h6 class="thumbnail-profile-addresses__title">City:</h6>
                                                        <p class="thumbnail-profile-addresses__desc">New York</p>
                                                    </div>
                                                    <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('New York', event)">
                                                        <img
                                                                class="thumbnail-profile-addresses__img color-style"
                                                                src="/web/images/content/profile-file.png"
                                                                alt="Profile"
                                                                style="cursor: pointer;">
                                                    </div>
                                                </div>
                                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                                    <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                                        <h6 class="thumbnail-profile-addresses__title">State:</h6>
                                                        <p class="thumbnail-profile-addresses__desc">NY (New York)
                                                        </p>
                                                    </div>
                                                    <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('NY (New York)', event)">
                                                        <img
                                                                class="thumbnail-profile-addresses__img color-style"
                                                                src="/web/images/content/profile-file.png"
                                                                alt="Profile"
                                                                style="cursor: pointer;">
                                                    </div>
                                                </div>

                                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                                    <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                                        <h6 class="thumbnail-profile-addresses__title">ZIP postal code:</h6>
                                                        <p class="thumbnail-profile-addresses__desc">11223</p>
                                                    </div>
                                                    <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('11223', event)">
                                                        <img
                                                                class="thumbnail-profile-addresses__img color-style"
                                                                src="/web/images/content/profile-file.png"
                                                                alt="Profile"
                                                                style="cursor: pointer;">
                                                    </div>
                                                </div>
                                                <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                                    <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                                        <h6 class="thumbnail-profile-addresses__title">Phone Number:</h6>
                                                        <p class="thumbnail-profile-addresses__desc">+1 (718) 872-7577</p>
                                                    </div>
                                                    <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('+1 (718) 872-7577', event)">
                                                        <img
                                                                class="thumbnail-profile-addresses__img color-style"
                                                                src="/web/images/content/profile-file.png"
                                                                alt="Profile"
                                                                style="cursor: pointer;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        function copyToClipboardAddress(text, event) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    const alertBox = document.createElement("div");
                    alertBox.className = "custom-alert";
                    alertBox.innerText = "Kopyalandı";

                    const buttonBlock = event.target.closest('.thumbnail-profile-addresses__img-block');
                    buttonBlock.style.position = "relative";
                    buttonBlock.appendChild(alertBox);

                    setTimeout(() => {
                        alertBox.style.opacity = "0";
                        setTimeout(() => alertBox.remove(), 500);
                    }, 3000);
                })
                .catch(err => {
                    console.error("Error", err);
                });
        }
    </script>
@endsection
