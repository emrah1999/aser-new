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
                    @csrf
                    <div class="form__group">
                        <label class="form__label" for="userEmail">Email</label>
                        <input class="form__input" name="user_email" type="email" id="userEmail" placeholder="Emailiniz daxil edin" required>
                    </div>
                    <button class="btn btn-yellow btn-block form__btn form-registration-otp__btn font-n-b" type="submit" data-bs-toggle="modal" data-bs-target="">OTP kodu əldə et</button>
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
                            <span class="modal-otp__title-time2">02:00</span>
                        </h3>
                        <p class="modal-otp__desc font-n-b" id="otpActionText">OTP Kodu daxil et</p>
                        <form class="form form-confirmation-otp center-block" id="formConfirmationOTP" name="formConfirmationOTP" method="post" action="{{route('verifyForgetOtp')}}" novalidate="novalidate">
                            @csrf
                            <div class="form__group form-confirmation-otp__group d-flex justify-content-evenly align-items-center">
                                <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1" inputmode="numeric" pattern="[0-9]*">
                                <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1" inputmode="numeric" pattern="[0-9]*">
                                <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1" inputmode="numeric" pattern="[0-9]*">
                                <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1" inputmode="numeric" pattern="[0-9]*">
                                <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1" inputmode="numeric" pattern="[0-9]*">
                                <input class="form__otp-field" type="text" name="otp_field[]" maxlength="1" inputmode="numeric" pattern="[0-9]*">
                                <input class="form__otp-value" type="hidden" name="full_otp">
                            </div>
                            <button class="btn btn-yellow btn-block form__btn form-confirmation-otp__btn font-n-b" name="formConfirmationOTPSubmit" type="submit" id="otpSubmitBtn" disabled>OTP kodu daxil et</button>
                        </form>
                        <button class="btn btn-yellow btn-block form__btn form-confirmation-otp__btn font-n-b d-none" id="resendOtpBtn">OTP kodu yenidən göndər</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('scripts')
        <script>
            $(document).ready(function () {
                function checkOtpFields() {
                    let allFilled = true;
                    $('.form__otp-field').each(function() {
                        if ($(this).val() === '') {
                            allFilled = false;
                            return false;
                        }
                    });

                    if (allFilled) {
                        $('#otpSubmitBtn').prop('disabled', false);
                        let fullOtp = '';
                        $('.form__otp-field').each(function() {
                            fullOtp += $(this).val();
                        });
                        $('.form__otp-value').val(fullOtp);
                    } else {
                        $('#otpSubmitBtn').prop('disabled', true);
                    }
                }

                $('.form__otp-field').on('input', function() {
                    checkOtpFields();

                    if ($(this).val().length === 1) {
                        $(this).next('.form__otp-field').focus();
                    }
                });

                $('.form__otp-field').on('keydown', function(e) {
                    if (e.key === "Backspace" && $(this).val() === '') {
                        $(this).prev('.form__otp-field').focus();
                    }
                });

                $("#formRegistrationOTP").on("submit", function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr("action"),
                        type: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.success === true) {
                                startTimer();
                                $("#modalOTP").modal("show");
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                            alert("Xəta baş verdi");
                        }
                    });
                });

                function startTimer() {
                    let timeLeft = 120;
                    const timerElement = $(".modal-otp__title-time2");
                    const otpActionText = $("#otpActionText");
                    const otpSubmitBtn = $("#otpSubmitBtn");
                    const resendOtpBtn = $("#resendOtpBtn");

                    if (window.otpTimerInterval) {
                        clearInterval(window.otpTimerInterval);
                    }

                    window.otpTimerInterval = setInterval(function() {
                        timeLeft--;
                        updateTimerDisplay();

                        if (timeLeft <= 0) {
                            clearInterval(window.otpTimerInterval);
                            timerExpired();
                        }
                    }, 1000);

                    function updateTimerDisplay() {
                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        timerElement.text(
                            (minutes < 10 ? "0" + minutes : minutes) + ":" +
                            (seconds < 10 ? "0" + seconds : seconds)
                        );
                    }

                    function timerExpired() {
                        otpActionText.text("OTP kodu yenidən göndər");
                        otpSubmitBtn.addClass("d-none");
                        resendOtpBtn.removeClass("d-none");
                    }

                    // Önceki click event'ini kaldır ve yeni bir tane ekle
                    resendOtpBtn.off("click").on("click", function() {
                        $.ajax({
                            url: $("#formRegistrationOTP").attr("action"),
                            type: "POST",
                            data: $("#formRegistrationOTP").serialize(),
                            success: function(response) {
                                if (response.success) {
                                    timeLeft = 120;
                                    updateTimerDisplay();
                                    otpActionText.text("OTP Kodu daxil et");
                                    otpSubmitBtn.removeClass("d-none").prop("disabled", true);
                                    resendOtpBtn.addClass("d-none");
                                    $(".form__otp-field").val("");

                                    // Yeni interval başlat
                                    if (window.otpTimerInterval) {
                                        clearInterval(window.otpTimerInterval);
                                    }
                                    window.otpTimerInterval = setInterval(function() {
                                        timeLeft--;
                                        updateTimerDisplay();
                                        if (timeLeft <= 0) {
                                            clearInterval(window.otpTimerInterval);
                                            timerExpired();
                                        }
                                    }, 1000);
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(xhr) {
                                alert("Xəta baş verdi");
                            }
                        });
                    });
                }

                $("#modalOTP").on("show.bs.modal", function() {
                    startTimer();
                });

                $("#modalOTP").on("hidden.bs.modal", function() {
                    if (window.otpTimerInterval) {
                        clearInterval(window.otpTimerInterval);
                    }
                });
            });
        </script>
    @endsection
@section('styles')
    <style>
        .modal-otp__title-time2{
            color: #F2C516;
        }
    </style>
@endsection