@extends('web.layouts.web')
@section('content')

<div class="content" id="content">
    <section class="section section-otp">
        <div class="container-lg">
            <div class="thumbnail thumbnail-otp center-block">
                <div class="thumbnail-otp__body text-center">
                    <a href="#" class="thumbnail-otp__link d-block">
                        <img class="thumbnail-otp__img" src="/web/images/logo/logo.png" alt="Logo">
                    </a>
                    <img class="thumbnail-otp__img" src="/web/images/content/other-otp.png" alt="OTP">
                    <p class="thumbnail-otp__title font-n-b">OTP kodu əldə etmək üçün emailinizi göstərilən xanaya yazın və emailinizi yoxlayın</p>
                </div>
            </div>
            <form class="form form-registration-otp center-block" name="formRegistrationOTP" id="formRegistrationOTP" method="post" action="{{route('reset_email', ['locale' => App::getLocale()])}}" novalidate="novalidate">
                <div class="form__group">
                    <label class="form__label" for="userEmail">Email</label>
                    <input class="form__input" name="user_email" type="email" id="userEmail" placeholder="Emailiniz daxil edin" required>
                </div>
                <button class="btn btn-yellow btn-block form__btn form-registration-otp__btn font-n-b" type="submit" data-bs-toggle="modal" data-bs-target="#modalOTP">OTP kodu əldə et</button>
            </form>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal modal-otp fade" id="modalOTP" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-otp__dialog">
        <div class="modal-content modal-otp__content">
            <div class="modal-header modal-otp__header justify-content-end">
                <img class="modal-otp__img-close" src="/web/images/content/modal-close.png" alt="Modal Close" data-bs-dismiss="modal">
            </div>
            <div class="modal-body modal-otp__body text-center">
                <h3 class="modal-otp__title font-n-b">
                    <span class="modal-otp__title-text">Vaxtınız var: </span>
                    <span class="modal-otp__title-time">02:00</span>
                </h3>
                <p class="modal-otp__desc font-n-b">OTP Kodu daxil et</p>
                <form class="form form-confirmation-otp center-block" id="formConfirmationOTP" name="formConfirmationOTP" method="post" action="/" novalidate="novalidate">
                    <div class="form__group form-confirmation-otp__group d-flex justify-content-evenly align-items-center">
                        <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1">
                        <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1">
                        <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1">
                        <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1">
                        <!-- Store OTP Value -->
                        <input class="form__otp-value" type="hidden" name="otp_value">
                    </div>
                    <button class="btn btn-yellow btn-yellow--disabled btn-block form__btn form-confirmation-otp__btn font-n-b" name="formConfirmationOTPSubmit" type="submit" disabled="disabled">OTP kodu daxil et</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection