@extends('front.app')
@section('content')
    <section class="login-section">
        <div class="login-left-panel"></div>
        <div class="login-right-panel">
            <div class="login-link"></div>
            <div class="login-form-block only-login sign-main">
                <div class="form-header">
                    <div class="success-notification show-block">
                        {!! __('auth.otp') !!}
                    </div>
                </div>

                <br><br><br>

                @if (session('error'))
                    <div class="error-notification show-block">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="success-notification show-block">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="login-form">
                    <form action="{{ route('otp_verify') }}" method="post" id="otp-form">
                        @csrf
                        <input type="hidden" id="otp_session" name="otp_session" value="{{ $otp_session }}">
                        <div class="def-label field-otpform-otp required">
                            <span class="label-sm"><label class="control-label" for="otp">{!! __('labels.otp') !!}</label></span>
                            <div class="otp-inputs">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required inputmode="numeric" pattern="[0-9]*">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required inputmode="numeric" pattern="[0-9]*">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required inputmode="numeric" pattern="[0-9]*">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required inputmode="numeric" pattern="[0-9]*">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required inputmode="numeric" pattern="[0-9]*">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required inputmode="numeric" pattern="[0-9]*">
                            </div>
                        </div>
                        <input type="hidden" id="otp" name="otp_full">
                        <button type="submit" class="verify-button"> {!! __('auth.otp_button') !!}</button>
                    </form>
                    <button id="resend-otp-button" class="verify-button" style="margin-top: 15px"> {!! __('auth.reset_otp') !!}</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        .login-section {
            display: flex;
            height: 100vh;
        }

        .login-left-panel {
            flex: 1;
            background: #f2f2f2;
        }

        .login-right-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-link {
            margin-bottom: 20px;
        }

        .login-form-block {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-header h3 {
            margin-bottom: 20px;
        }

        .error-notification {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .success-notification {
            color: #ffce00;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .def-label {
            margin-bottom: 20px;
            text-align: left;
        }

        .label-sm {
            display: block;
            margin-bottom: 5px;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
        }

        .otp-input {
            padding: 20px !important;
            border: 1px solid #ddd !important;
            border-radius: 5px !important;
            text-align: center !important;
            font-size: 18px !important;
            color: #000 !important;
            background-color: #fff !important;
            margin: 10px;
            box-shadow: 0 12px 24px 0 rgba(0, 0, 0, 0.08);
            -moz-box-shadow: 0 12px 24px 0 rgba(0, 0, 0, 0.08);
            -ms-box-shadow: 0 12px 24px 0 rgba(0, 0, 0, 0.08);
        }

        .verify-button {
            background: #ffce00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .verify-button:hover {
            background: #ffce00;
        }

        @media (max-width: 680px) {
            .otp-input {
                padding: 10px !important;
            }
            .login-form-block {
                padding: 17px;
            }
        }

        @media (max-width: 372px) {
            .otp-input {
                padding: 5px !important;
                width: 24px !important;
            }
            .login-form-block {
                padding: 32px 0px;
            }
        }
    </style>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpForm = document.getElementById('otp-form');
            const otpHiddenInput = document.getElementById('otp');
            const resendOtpButton = document.getElementById('resend-otp-button');
            const otpSessionInput = document.getElementById('otp_session');
            const otpResendKey = 'otp_resend_time';
            const countdownTime = 120; // 2 deq

            // OTP input handling
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    if (!/^[0-9]$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    if (value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text').trim();
                    const numbers = paste.match(/\d/g);
                    if (numbers) {
                        otpInputs.forEach((inp, i) => {
                            inp.value = numbers[i] || '';
                        });
                    }
                });
            });

            otpForm.addEventListener('submit', (e) => {
                let otpValue = '';
                otpInputs.forEach(input => {
                    otpValue += input.value;
                });
                otpHiddenInput.value = otpValue;
            });

            // Resend OTP handling
            let resendOtpTimeout;
            const disableResendButton = (timeLeft) => {
                resendOtpButton.disabled = true;
                updateResendButton(timeLeft);

                resendOtpTimeout = setInterval(() => {
                    timeLeft--;
                    updateResendButton(timeLeft);
                    if (timeLeft <= 0) {
                        clearInterval(resendOtpTimeout);
                        resendOtpButton.disabled = false;
                        resendOtpButton.textContent = '{!! __('auth.reset_otp') !!}';
                        localStorage.removeItem(otpResendKey);
                    }
                }, 1000);
            };

            const updateResendButton = (timeLeft) => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                resendOtpButton.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            };

            // Check if there's a previous resend time stored
            const previousResendTime = localStorage.getItem(otpResendKey);
            if (previousResendTime) {
                const elapsedTime = Math.floor((Date.now() - previousResendTime) / 1000);
                const remainingTime = countdownTime - elapsedTime;
                if (remainingTime > 0) {
                    disableResendButton(remainingTime);
                }
            } else {
                disableResendButton(countdownTime);
            }

            // On resend OTP button click, call the server to resend the OTP
            resendOtpButton.addEventListener('click', () => {
                fetch('{{ route('resend_otp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ otp_session: otpSessionInput.value })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            otpSessionInput.value = data.otp_session;
                            localStorage.setItem(otpResendKey, Date.now());
                            disableResendButton(countdownTime);
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    }).catch(error => {
                    console.error('Error:', error);
                    alert('Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin!');
                });
            });
        });
    </script>
@endsection
