@extends('web.layouts.web')
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
                                    <h4 class="profile-title-block__title font-n-b">{!! __('account_menu.my_account2') !!}
                                    </h4>
                                </div>
                                <div class="col-xxl-4">

                                </div>
                            </div>
                        </div>
                        <div class="nav nav-tab-categories">
                            <div class="d-flex flex-wrap">
                                @foreach($countries as $country)
                                    <div style="flex: 0 0 auto; min-width: 95px; margin-bottom: 8px;">
                                        <a href=" {{ route('shipping_days.details', ['locale' => App::getLocale(), 'country_id' => $country->id]) }}"
                                            class="nav-tab-categories__link nav-tab-categories__link flex-fill d-flex justify-content-center align-items-center mr-5">
                                            <img class="nav-tab-categories__link-img" src="{{ $country->new_flag }}">
                                            <span class="nav-tab-categories__link-title d-none d-md-block">
                                                {{ $country->name }}</span>
                                        </a>
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
@section('styles')
    <style>
        @media (max-width: 575.98px) {

            .footer {
                padding: 10px 0;
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        }

        @media (max-width: 800.98px) {

            .nav-tab-categories__link {
                margin-right: 4px;
            }
        }
    </style>
@endsection