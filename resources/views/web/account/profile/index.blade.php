@extends('web.layouts.web')
@section('content')
<div class="content" id="content">
    <section class="section section-profile-settings">
        <div class="container-lg">
            <div class="row">
                @include("web.account.account_left_bar")
                <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                    <div class="thumbnail thumbnail-profile-settings">
                        <a href="{{route("get_update_user_account", ['locale' => App::getLocale()])}}" class="thumbnail-profile-settings__link d-flex justify-content-between align-items-center">
                            <div class="thumbnail-profile-settings__caption-block">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="thumbnail-profile-settings__img-block-1">
                                        <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings1.png" alt="Settings">
                                    </div>
                                    <div class="thumbnail-profile-settings__caption">
                                        <h6 class="thumbnail-profile-settings__title font-n-b">{!! __('static.information') !!}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-profile-settings__img-block-2 justify-content-end">
                                <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings-chevron-right.png" alt="Settings">
                            </div>
                        </a>
                    </div>
                    <div class="thumbnail thumbnail-profile-settings">
                        <a href="{{route("get_update_user_password", ['locale' => App::getLocale()])}}" class="thumbnail-profile-settings__link d-flex justify-content-between align-items-center">
                            <div class="thumbnail-profile-settings__caption-block">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="thumbnail-profile-settings__img-block-1">
                                        <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings2.png" alt="Settings">
                                    </div>
                                    <div class="thumbnail-profile-settings__caption">
                                        <h6 class="thumbnail-profile-settings__title font-n-b">{!! __('static.change_password') !!}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-profile-settings__img-block-2 justify-content-end">
                                <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings-chevron-right.png" alt="Settings">
                            </div>
                        </a>
                    </div>
                    {{--
                        <div class="thumbnail thumbnail-profile-settings">
                        <a href="{{route("get_account", ['locale' => App::getLocale()])}}" class="thumbnail-profile-settings__link d-flex justify-content-between align-items-center">
                            <div class="thumbnail-profile-settings__caption-block">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="thumbnail-profile-settings__img-block-1">
                                        <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings3.png" alt="Settings">
                                    </div>
                                    <div class="thumbnail-profile-settings__caption">
                                        <h6 class="thumbnail-profile-settings__title font-n-b">{!! __('account_menu.my_account') !!}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-profile-settings__img-block-2 justify-content-end">
                                <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings-chevron-right.png" alt="Settings">
                            </div>
                        </a>
                    </div>
                    <div class="thumbnail thumbnail-profile-settings">
                        <a href="{{route("get_balance_page", ['locale' => App::getLocale()])}}" class="thumbnail-profile-settings__link d-flex justify-content-between align-items-center">
                            <div class="thumbnail-profile-settings__caption-block">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="thumbnail-profile-settings__img-block-1">
                                        <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings4.png" alt="Settings">
                                    </div>
                                    <div class="thumbnail-profile-settings__caption">
                                        <h6 class="thumbnail-profile-settings__title font-n-b">{!! __('account_menu.balance') !!}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-profile-settings__img-block-2 justify-content-end">
                                <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings-chevron-right.png" alt="Settings">
                            </div>
                        </a>
                    </div>--}}
                    <div class="thumbnail thumbnail-profile-settings">
                        <a href="{{route("change_notification_settings", ['locale' => App::getLocale()])}}" class="thumbnail-profile-settings__link d-flex justify-content-between align-items-center">
                            <div class="thumbnail-profile-settings__caption-block">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="thumbnail-profile-settings__img-block-1">
                                        <img class="thumbnail-profile-settings__img" src="/web/images/content/notification-new.png" height="24px" width="24px" alt="Settings">
                                    </div>
                                    <div class="thumbnail-profile-settings__caption">
                                        <h6 class="thumbnail-profile-settings__title font-n-b">{!! __('static.notification') !!}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-profile-settings__img-block-2 justify-content-end">
                                <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings-chevron-right.png" alt="Settings">
                            </div>
                        </a>
                    </div>
                   {{-- <div class="thumbnail thumbnail-profile-settings">
                        <a class="thumbnail-profile-settings__link d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalProfileLogout">
                            <div class="thumbnail-profile-settings__caption-block">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="thumbnail-profile-settings__img-block-1">
                                        <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings5.png" alt="Settings">
                                    </div>
                                    <div class="thumbnail-profile-settings__caption">
                                        <h6 class="thumbnail-profile-settings__title font-n-b">Çıxış et</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-profile-settings__img-block-2 justify-content-end">
                                <img class="thumbnail-profile-settings__img" src="/web/images/content/profile-settings-chevron-right.png" alt="Settings">
                            </div>
                        </a>
                    </div>--}}
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('styles')
    <style>
        @media (max-width: 575.98px) {
            .footer{
                padding: 10px 0;
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
@endsection