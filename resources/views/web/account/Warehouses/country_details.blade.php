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
                        </div>
                        <div class="tab-content tab-content-categories">
                            <div class="tab-pane fade show active" id="turkey">
                                @if($currentCountry==9)
                                    <div class="row">
                                        <div class=" information-div col-md-1">
                                             <img src="{{asset('uploads/static/info.png')}}"  height="15px" width="15px" data-toggle="tooltip" data-placement="right" >
                                        </div>

                                        <p class="information col-md-11 ">{!! __('static.germany_info') !!}</p>
                                    </div>
                                @endif
                                @foreach($details as $detail)
                                    @php($information = $detail->information)
                                    @php($information = str_replace('{name_surname}', Auth::user()->full_name(), $information))
                                    @php($information = str_replace('{aser_id}', Auth::user()->suite(), $information))

                                    <div class="thumbnail thumbnail-profile-addresses d-flex justify-content-between align-items-start thumbnail-style ">
                                        <div class="thumbnail-profile-addresses__caption thumbnail-style2">
                                            <h6 class="thumbnail-profile-addresses__title">{{$detail->title}}</h6>
                                            <p class="thumbnail-profile-addresses__desc">{{$information}}</p>
                                        </div>
                                        <div class="thumbnail-profile-addresses__img-block color-style" onclick="copyToClipboardAddress('{{$information}}', event)">
                                            <img
                                                    class="thumbnail-profile-addresses__img color-style"
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
