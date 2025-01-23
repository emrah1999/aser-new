@extends('web.layouts.web')
@section('content')



    <div class="content" id="content">
        <section class="section section-otp">
        
            <div class="container-lg">
                @if (session('error'))
                    <div class="alert alert-danger" style="text-align: center;">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="modal-body modal-otp__body text-center">
                    <h3 class="modal-otp__title font-n-b">
                        <span class="modal-otp__title-text">Vaxtınız var: </span>
                        <span class="modal-otp__title-time">02:00</span>
                    </h3>
                    <p class="modal-otp__desc font-n-b">OTP Kodu daxil et</p>
                    <form class="form form-confirmation-otp center-block" id="formConfirmationOTP" name="formConfirmationOTP" method="post" action="{{ route('otp_verify', ['locale' => App::getLocale()]) }}" novalidate="novalidate">
                        @csrf
                        <input type="hidden" id="otp_session" name="otp_session" value="{{ $otp_session }}">
                        <div class="form__group form-confirmation-otp__group d-flex justify-content-evenly align-items-center">
                            <input class="form__otp-field" type="text" name="otp[]" maxlength="1">
                            <input class="form__otp-field" type="text" name="otp[]" maxlength="1">
                            <input class="form__otp-field" type="text" name="otp[]" maxlength="1">
                            <input class="form__otp-field" type="text" name="otp[]" maxlength="1">
                            <input class="form__otp-field" type="text" name="otp[]" maxlength="1">
                            <input class="form__otp-field" type="text" name="otp[]" maxlength="1">

                            <input class="form__otp-value" type="hidden" name="otp_full">
                        </div>
                        <button class="btn btn-yellow btn-yellow--disabled btn-block form__btn form-confirmation-otp__btn font-n-b" type="submit" disabled="disabled">{!! __('auth.otp_button') !!}</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

@endsection