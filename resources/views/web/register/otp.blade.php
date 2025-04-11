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
                        <span class="modal-otp__title-time2">02:00</span>
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
                        <button class="btn btn-yellow btn-block form__btn form-confirmation-otp__btn font-n-b" id="submitBtn" type="submit" disabled>{!! __('auth.otp_button') !!}</button>
                    </form>
                    <div class="form form-confirmation-otp center-block">
                    <button class="btn btn-yellow btn-block form__btn form-confirmation-otp__btn  font-n-b" id="resendOtpBtn" style="display: none;">Yenidən göndər</button>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timerDisplay = document.querySelector('.modal-otp__title-time2');
            const resendBtn = document.getElementById('resendOtpBtn');
            const submitBtn = document.getElementById('submitBtn');
            let timeLeft = 120;
            let timer;

            function startTimer() {
                clearInterval(timer);
                timeLeft = 120;
                updateTimerDisplay();

                timer = setInterval(function() {
                    timeLeft--;
                    updateTimerDisplay();

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        timerDisplay.textContent = '00:00';
                        timerDisplay.parentElement.querySelector('.modal-otp__title-text').textContent = 'Vaxtınız bitdi';
                        submitBtn.style.display = 'none';
                        resendBtn.style.display = 'block';
                    }
                }, 1000);
            }

            function updateTimerDisplay() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            startTimer();

            resendBtn.addEventListener('click', function() {
                resendBtn.disabled = true;
                resendBtn.textContent = 'Göndərilir...';

                fetch('{{ route("reset_email", ["locale" => App::getLocale(), 'type'=>$otpType]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        'user_email': '{{session('credential')}}',
                        'number': '{{session('credential')}}'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            startTimer();
                            resendBtn.style.display = 'none';
                            submitBtn.style.display = 'block';
                            timerDisplay.parentElement.querySelector('.modal-otp__title-text').textContent = 'Vaxtınız var: ';
                            alert('Yeni OTP kodu göndərildi!');

                            otpFields.forEach(field => {
                                field.value = '';
                            });
                            updateOtpValue();
                        } else {
                            alert('Xəta baş verdi: ' + (data.message || 'Bilinməyən xəta'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Xəta baş verdi');
                    })
                    .finally(() => {
                        resendBtn.disabled = false;
                        resendBtn.textContent = 'Yenidən göndər';
                    });
            });

            const otpFields = document.querySelectorAll('.form__otp-field');
            const otpValueField = document.querySelector('.form__otp-value');

            otpFields.forEach((field, index) => {
                field.addEventListener('input', function() {
                    if (this.value.length === 1 && index < otpFields.length - 1) {
                        otpFields[index + 1].focus();
                    }
                    updateOtpValue();
                });

                field.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        otpFields[index - 1].focus();
                    }
                });
            });

            function updateOtpValue() {
                let otp = '';
                otpFields.forEach(field => {
                    otp += field.value;
                });
                otpValueField.value = otp;
                submitBtn.disabled = otp.length !== otpFields.length;
            }
        });
    </script>
@endsection