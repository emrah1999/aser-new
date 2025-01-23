@extends('web.layouts.web')
@section('content')

<div class="content" id="content">
    <section class="section section-profile-notifications">
        <div class="container-lg">
            <div class="row">
                @include("web.account.account_left_bar")
                <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                    <div class="profile-title-block">
                        <div class="row">
                            <div class="col-xxl-8">
                                <h4 class="profile-title-block__title font-n-b">Bildirişlər</h4>
                            </div>
                            <div class="col-xxl-4">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($notifications as $notification)
                            <div class="col-xl-6">
                                <div class="thumbnail thumbnail-profile-notifications">
                                    <div class="d-flex justify-content-start align-items-start">
                                        <div class="thumbnail-profile-notifications__img-block">
                                            <img class="thumbnail-profile-notifications__img" src="/web/images/content/profile-menu-notification-active.png" alt="Notification">
                                        </div>
                                        <div class="thumbnail-profile-notifications__caption">
                                            <h6 class="thumbnail-profile-notifications__title font-n-b">{{$notification->subject_header}}</h6>
                                            <p class="thumbnail-profile-notifications__desc">{{$notification->created_at}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(count($notifications) > 0)
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="#" class="profile-more-btn d-flex justify-content-center align-items-center">
                                <span class="profile-more-btn__title font-n-b">Daha çox</span>
                                <img class="profile-more-btn__img" src="/web/images/content/profile-more.png" alt="More">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection