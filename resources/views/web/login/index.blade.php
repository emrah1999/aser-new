@extends('web.layouts.web')
@section('title')
    {{$title->login}}
@endsection

@section('description')
    {{$title->description_login}}
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-login">
            <div class="container-lg">
                <div class="row justify-content-between align-items-start">
                    <div class="col-lg-6 col-md-7 d-none d-md-block">
                        <div class="thumbnail thumbnail-login">
                            <div class="thumbnail-login__caption">
                                {{-- <h1 class="thumbnail-login__title font-n-b">{!! __('static.welcome') !!}</h1> --}}
                                <h1 class="section-title text-center font-n-b mb-3">{{$title->login}}</h1>
                            </div>
                            <div class="thumbnail-login__img-block">
                                <img class="thumbnail-login__img img-responsive" src="/web/images/content/login/login.png" alt="Login">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <form class="form form-login center-block" id="formLogin" name="formLogin" method="post" action="{{ route('login', ['locale' => App::getLocale()]) }}" novalidate="novalidate">
                            @csrf
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            <p class="form-login__title text-center font-n-b">{!! __('auth.login') !!}</p>
                            <div class="form__group">
                                <label class="form__label" for="userEmail">{!! __('labels.email') !!}</label>
                                <input class="form__input" name="email" type="email" id="userEmail" placeholder="{!! __('static.emailPhLogin') !!}" required>
                            </div>
                            <div class="form__group">
                                <label class="form__label" for="userPassword">{!! __('labels.password') !!}</label>
                                <input class="form__input" name="password" type="password" id="userPassword" placeholder="{!! __('static.passwordPhLogin') !!}" required>
                            </div>
                            @if ($errors->any())
                                <div style="color:red">
                                    <ul style="list-style: none">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-login__remember_forgot-block d-flex justify-content-between align-items-center">
                                <label class="form-checkbox form-login__form-checkbox d-flex justify-content-start align-items-center" for="userRemember">
                                    <input class="form-checkbox__input form-login__form-checkbox-input" name="remember" type="checkbox" id="userRemember">
                                    <span class="form-checkbox__span form-login__form-checkbox-span" style="margin-right: 7px" ></span>
                                    <span class="form-checkbox__text form-login__form-checkbox-text">{!! __('static.rememberLogin') !!}</span>
                                </label>
                                <a href="{{ route('password.request', ['locale' => App::getLocale()]) }}" class="form-login__link-forgot">{!! __('auth.forgot_password')!!}</a>
                            </div>
                            <button class="btn btn-blue btn-block form__btn form-login__btn font-n-b" name="formLoginSubmit" type="submit">{!! __('static.login') !!}</button>
{{--                            <a href="" class="login-sima d-flex justify-content-center align-items-center">--}}
{{--                                <img class="login-sima__img" src="/web/images/content/login/other-sima.png" alt="Sima">--}}
{{--                                <span class="login-sima__title">{!! __('static.enterWith') !!}</span>--}}
{{--                            </a>--}}
                            <div class="login-registration-question">
                                <p class="login-registration-question__block text-center">
                                    <span class="login-registration-question__title">{!! __('auth.have_account') !!}</span>
                                    <a href="{{route("register", ['locale' => App::getLocale()])}}" class="login-registration-question__link font-n-b">{!! __('auth.got_to_registr') !!}</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection