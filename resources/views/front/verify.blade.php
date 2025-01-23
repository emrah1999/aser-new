@extends('front.app')
@section('content')
    <section class="login-section ">
        <div class="login-left-panel"></div>
        <div class="login-right-panel">
            <div class="login-link">
                <a href="{{route("login")}}"> {!! __('auth.login') !!} </a>
                @if (Route::has('register'))
                    <a href="{{route("register")}}"> {!! __('auth.register') !!}} </a>
                @endif
            </div>
            <div class="login-form-block only-login sign-main">
                <div class="form-header">
                    <h3> {!! __('auth.verify_account') !!}} </h3>
                </div>
                <br><br><br>
                <div class="login-form">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {!! __('auth.sent_verify_email') !!}}
                        </div>
                    @endif
                    <form id="signin-form" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="flex-between register-submit">
                            <button type="submit" class="orange-button"> {!! __('send_verify_email_button') !!}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')

@endsection

@section('js')

@endsection