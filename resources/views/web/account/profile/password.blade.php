@extends('web.layouts.web')
@section('content')
@if (session('case') === 'warning')
    <div class="alert alert-warning">
        <strong>{{ session('title') }}</strong>
        @if (is_array(session('content')))
            <ul>
                @foreach (session('content') as $field => $errors)
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>{{ session('content') }}</p>
        @endif
    </div>
@endif

@if (session('case') === 'exist')
    <div class="alert alert-warning">
        <strong>{{ session('title') }}</strong>
        <p>{{ session('content') }}</p>
    </div>
@endif

@if (session('case') === 'success')
    <div class="alert alert-success">
        <strong>{{ session('title') }}</strong>
        <p>{{ session('content') }}</p>
    </div>
@endif

@if (session('case') === 'error')
    <div class="alert alert-danger">
        <strong>{{ session('title') }}</strong>
        <p>{{ session('content') }}</p>
    </div>
@endif
<div class="content" id="content">
    <section class="section section-profile-settings">
        <div class="container-lg">
            <div class="row">
                @include("web.account.account_left_bar")
                <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                    <div class="profile-title-block">
                        <div class="row justify-content-center align-items-start">
                            <div class="col-xxl-8">
                                <a href="{{route("get_user_settings", ['locale' => App::getLocale()])}}" class="d-flex justify-content-start align-items-center">
                                    <img class="profile-title-block__img" src="/web/images/content/profile-settings-chevron-left.png" alt="Settings">
                                    <h1 class="profile-title-block__title font-n-b">Şifrəni dəyiş</h1>
                                </a>
                            </div>
                            <div class="col-xxl-4">

                            </div>
                        </div>
                    </div>
                    <form class="form form-profile-password-edit" name="formProfilePasswordEdit" id="formProfilePasswordEdit" method="post" action="{{route("post_update_user_password", ['locale' => App::getLocale()])}}" novalidate="novalidate">
                        @csrf
                        <div class="form__group">
                            <label class="form__label" for="password">Yeni şifrə</label>
                            <input class="form__input" name="password" type="password" id="password" placeholder="{!! __('register.input_password') !!}" required>
                        </div>
                        <div class="form__group">
                            <label class="form__label" for="userReNewPassword">Təkrar şifrə</label>
                            <input class="form__input" name="user_re_new_password" type="password" id="userReNewPassword" placeholder="Yeni şifrənizi təkrar daxil edin" required>
                        </div>
                        <button class="btn btn-blue btn-block form__btn form-profile-password-edit__btn font-n-b" name="formProfilePasswordEditSubmit" type="submit">Şifrəni dəyiş</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection