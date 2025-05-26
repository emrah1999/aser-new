@extends('web.layouts.web')
@section('styles')
        <style>
            .col-sm-6 {
                width: 50%;
                float: left;
            }

            .form__group {
                margin-bottom: 15px;
            }

            .input-container {
                position: relative;
            }

            .form-checkbox {
                margin-right: 15px;
                cursor: pointer;
            }

            .form-checkbox__input {
                margin-right: 5px;
            }

            .form-checkbox__span {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 1px solid #ccc;
                border-radius: 50%;
                margin-right: 10px;
                vertical-align: middle;
                cursor: pointer;
            }

            .form-checkbox.d-flex.align-items-center {
                display: flex;
                align-items: center;
            }

            .invalid-feedback {
                color: red;
                font-size: 12px;
                display: none;
            }
            .custom-tooltip-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.custom-tooltip-text {
    visibility: hidden;
    width: 200px;
    background-color: rgba(0, 0, 0, 0.8);
    color: #fff;
    text-align: center;
    padding: 8px;
    border-radius: 5px;
    position: absolute;
    z-index: 10;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    white-space: normal;
    word-wrap: break-word;
    opacity: 0;
    transition: opacity 0.3s;
}

.custom-tooltip-container:hover .custom-tooltip-text {
    visibility: visible;
    opacity: 1;
}



            @media (max-width: 768px) {
                .custom-tooltip {
                    max-width: 90%;
                    left: 5%;
                }
            }

            .info-icon {
                display: inline-block;
                cursor: pointer;
                position: relative;
            }



            @keyframes blink {
                0% {
                    color: var(--yellow);
                }
                50% {
                    color: black;
                }
                100% {
                    color: var(--yellow);
                }
            }
            .is-invalid {
                border: 1px solid red;
            }
        </style>

@endsection
@section('content')
    @if (session('case'))
        <div class="alert alert-{{ session('case') }}" style="height: 4rem;">
            <strong>{{ session('title') }}</strong> {{ session('content') }}
        </div>
    @endif
    @php
        $showSecondPart = false;
        if (session('errorType') && in_array(session('errorType'), ['passport_number', 'fin'])) {
            $showSecondPart = true;
        }
    @endphp

    <div class="content" id="content">
    <section class="section section-registration d-flex justify-content-center align-items-center">
        <div class="container-lg">
            <form class="form form-registration center-block" name="formRegistrationPhysical" id="formRegistrationPhysical" method="post" action="{{route("register", ['locale' => App::getLocale()])}}" novalidate="novalidate">
                @csrf
                <input class="form__input" name="is_legality" value="0" type="hidden">
                <h1 class="form-registration__title text-center font-n-b">{!! __('static.welcome') !!}</h1>
                <p class="form-registration__title-2 text-center font-n-b">{!! __('static.registerForm') !!}</p>
                <div class="form-registration__btn-types d-flex justify-content-center align-items-center">
                    <div class="col">
                        <a href="{{route("register", ['locale' => App::getLocale(), 'type' => 'physical'])}}" class="btn btn-trns-yellow btn-block btn-trns-yellow--active form-registration__btn-type form-registration__btn-type--pos-rel-right font-n-b">{!! __('static.physic') !!}</a>
                    </div>
                    <div class="col">
                        <a href="{{route("register", ['locale' => App::getLocale(), 'type' => 'juridical'])}}" class="btn btn-trns-yellow btn-block form-registration__btn-type font-n-b">{!! __('static.jurdical') !!}</a>
                    </div>
                </div>
                <div class="form-registration__content form-registration__content--1 {{ $showSecondPart ?  'd-none': '' }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userName">{!! __('auth.Name') !!}</label>
                                <input class="form__input" name="name"  type="text" id="userName" placeholder="{!! __('static.namePH') !!}" value="{{ old('name') }}"  required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userSurname">{!! __('auth.Surname') !!}</label>
                                <input class="form__input" name="surname" value="{{ old('surname')}}" type="text" id="userSurname" placeholder="{!! __('static.surnamePH') !!}" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userEmail">{!! __('auth.Email') !!}</label>
                                <input class="form__input {{ session('errorType') == 'email' ? 'is-invalid' : '' }}"
                                       name="email"
                                       value="{{ session('errorType') == 'email' ? '' : old('email') }}"
                                       type="email"
                                       id="userEmail"
                                       placeholder="{!! __('static.emailPhLogin') !!}"
                                       required>
                                <div class="invalid-feedback">
                                    @if (session('errorType') == 'email')
                                        <strong> {{__('register.email_exists')}} </strong>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="phone">{!! __('auth.Phone') !!}</label>
                                <div class="d-flex gap-2">
                                    <span class="form-control d-flex align-items-center justify-content-center" style="width: 70px;">+994</span>


                                    <select id="prefix" name="prefix" class="form-control" style="width: 50px;" required>
                                        <option value="" disabled selected>--</option>
                                        <option value="50">50</option>
                                        <option value="55">55</option>
                                        <option value="60">60</option>
                                        <option value="70">70</option>
                                        <option value="77">77</option>
                                        <option value="99">99</option>
                                    </select>

                                    <input
                                            class="form__input"
                                            type="text"
                                            id="phoneSuffix"
                                            name="phone_suffix"
                                            maxlength="9"
                                            placeholder="xxx-xx-xx"
                                            required
                                            value="{{ session('errorType') == 'number' ? '' : old('phone_suffix') }}"
                                            style="flex: 1;"
                                    />
                                </div>

                                <div class="invalid-feedback">
                                    @if (session('errorType') == 'number')
                                        <strong>{{__('register.phone_exists')}}</strong>
                                    @elseif(session('errorType') == 'number2')
                                        <strong>{{ session('content') }}</strong>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userBirthdate">{!! __('auth.Birthday') !!}</label>
                                <input
                                        class="form__input {{ session('errorType') == 'age' ? 'is-invalid' : '' }}"
                                        name="birthday"
                                        value="{{ session('errorType') == 'age' ? '' : old('birthday') }}"
                                        type="date"
                                        id="userBirthdate"
                                        max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                                        required
                                >
                                <div class="invalid-feedback">
                                    @if (session('errorType') == 'age')
                                        <strong>{!! __('static.ageLimit') !!}</strong>
                                    @endif
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userSex">{!! __('auth.Language') !!}</label>
                                <div class="form__select-wrapper">
                                    <select class="form__select" name="language" id="language" required>
                                        <option value="AZ" {{ old('language') == 'AZ' ? 'selected' : '' }}>AZ</option>
                                        <option value="EN" {{ old('language') == 'EN' ? 'selected' : '' }}>EN</option>
                                        <option value="RU" {{ old('language') == 'RU' ? 'selected' : '' }}>RU</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userSex">{!! __('auth.City') !!}</label>
                                <div class="form__select-wrapper">
                                    <select class="form__select" name="city" id="city" required>
                                        <option value="">{!! __('static.choose') !!}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->name}}" {{ old('city') == $city->name ? 'selected' : '' }}>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userSex">{!! __('auth.Gender') !!}</label>
                                <div class="form__select-wrapper">
                                    <select class="form__select" name="gender" id="userSex" required>
                                        <option value="">{!! __('auth.gender_select') !!}</option>
                                        <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>{!! __('auth.male') !!}</option>
                                        <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>{!! __('auth.female') !!}</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userBranch">{!! __('static.branch') !!}</label>
                                <div class="form__select-wrapper">
                                    <select class="form__select" name="branch_id" id="userBranch" required>
                                        <option value="0" disabled selected>{!! __('static.branch') !!}</option>
                                        @foreach($branchs as $branch)
                                            <option value="{{$branch->id}}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <div class="custom-tooltip-container">
                                    <img src="{{ asset('uploads/static/info.png') }}" height="15px" width="15px">
                                    <span class="custom-tooltip-text">{!! nl2br(e(__('auth.ParentCode2'))) !!}</span>
                                </div>
                                  <label class="form__label" for="userRefer">{!! __('auth.ParentCode') !!}</label>
                                     <input class="form__input" name="parent_code" value="{{ old('parent_code')}}" type="text" id="userRefer">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-registration__content form-registration__content--2 {{ $showSecondPart ? '' : 'd-none' }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userPassportSeria">{!! __('auth.PassportSeries') !!}</label>
                                <div class="form__select-wrapper">
                                    <select class="form__select" name="passport_series" id="userPassportSeria" required>
                                        <option value="0" disabled {{ old('passport_series') ? '' : 'selected' }}>{!! __('static.choose') !!}</option>
                                        <option value="AA" {{ old('passport_series') == 'AA' ? 'selected' : '' }}>AA</option>
                                        <option value="AZE" {{ old('passport_series') == 'AZE' ? 'selected' : '' }}>AZE</option>
                                        <option value="MYI" {{ old('passport_series') == 'MYI' ? 'selected' : '' }}>MYI</option>
                                        <option value="DYI" {{ old('passport_series') == 'DYI' ? 'selected' : '' }}>DYI</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userPassportSeriaNumber">{!! __('auth.PassportNumber') !!}</label>
                                <input class="form__input {{ session('errorType') == 'passport_number' ? 'is-invalid' : '' }}"
                                       name="passport_number"
                                       value="{{ session('errorType') == 'passport_number' ? '' : old('passport_number') }}"
                                       type="text"
                                       id="userPassportSeriaNumber"
                                       placeholder="{!! __('static.passprtNumberPh') !!}n"
                                       required>
                                <div class="invalid-feedback">
                                    @if (session('errorType') == 'passport_number')
                                        <strong>{!! __('register.passport_number_exists') !!}</strong>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userPassportFinCode">{!! __('auth.PassportFIN') !!}</label>
                                <input class="form__input {{ session('errorType') == 'fin' ? 'is-invalid' : '' }}"
                                       name="passport_fin"
                                       value="{{ session('errorType') == 'fin' ? '' : old('passport_fin') }}"
                                       type="text"
                                       id="userPassportFinCode"
                                       placeholder="{!! __('static.finReg') !!}"
                                       required>
                                <div class="invalid-feedback">
                                    @if (session('errorType') == 'fin')
                                        <strong>{{ __('register.passport_fin_exists')}}</strong>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userAddress">{!! __('auth.Address') !!}</label>
                                <input class="form__input" name="address1" value="{{ old('address1')}}" type="text" id="userAddress" placeholder="{!! __('static.addressPhReg') !!}" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userPassword">{!! __('auth.Password') !!}</label>
                                <div class="input-container" style="position: relative;">
                                    <input class="form__input" name="password" value="{{ old('password')}}" type="password" id="userPassword" placeholder="{!! __('static.passwordReg') !!}" required style="padding-right: 30px;">
                                    <span class="eye-icon" id="togglePassword1" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form__label" for="userPassword2">{!! __('static.confirmPasswordReg2') !!}</label>
                                <div class="input-container" style="position: relative;">
                                    <input class="form__input" name="user_password2" value="{{ old('user_password2')}}" type="password" id="userPassword2" placeholder="{!! __('static.confirmPasswordReg') !!}" required style="padding-right: 30px;">
                                    <span class="eye-icon" id="togglePassword2" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">
                                <div class="input-container" style="position: relative;">
                                    <label class="form-checkbox d-flex align-items-center" style="margin-right: 15px;">
                                        <input class="form-checkbox__input" type="radio" name="verification" value="sms" id="smsVerification">
                                        <span class="form-checkbox__span"></span> {!! __('static.sms') !!}
                                    </label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form__group">

                                <div class="input-container" style="position: relative;">
                                    <label class="form-checkbox d-flex align-items-center">
                                        <input class="form-checkbox__input" type="radio" name="verification" value="email" id="emailVerification">
                                        <span class="form-checkbox__span"></span> {!! __('static.emailReg') !!}
                                    </label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="form-registration__btn-actions form-registration__btn-actions--1 {{ $showSecondPart ?  'd-none': '' }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-6">
                            <div class="form__group">
                                <label class="form-checkbox d-flex justify-content-start align-items-center" for="userAgree">
                                    <input class="form-checkbox__input" name="agreement" type="checkbox" id="userAgree"{{old('agreement') ? 'checked' : ''}}>
                                    <span class="form-checkbox__span" style="border-radius: 50px;width: 25px"></span>
                                    <a href="https://asercargo.az/uploads/static/terms2.pdf" target="_blank">
                                        <span class="form-checkbox__text" style="animation: blink 1s infinite;">{!! __('auth.agreement') !!}</span>
                                    </a>
                                    <div class="invalid-feedback"></div>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-yellow btn-block form__btn form-registration__btn-action form-registration__btn-action--next font-n-b" type="button">{!! __('static.next') !!}</button>
                        </div>
                    </div>
                </div>
                <div class="form-registration__btn-actions form-registration__btn-actions--2 {{ $showSecondPart ? '' : 'd-none' }}">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-6">
                            <button class="btn btn-black btn-block form__btn form-registration__btn-action form-registration__btn-action--prev font-n-b" type="button">{!! __('static.backReg') !!}</button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-yellow btn-block form__btn form-registration__btn-action form-registration__btn-action--submit font-n-b" name="formRegistrationPhysicalSubmit" type="submit">{!! __('static.register') !!}</button>
                        </div>
                    </div>
                </div>
                <div class="login-registration-question">
                    <p class="login-registration-question__block text-center">
                        <span class="login-registration-question__title">{!! __('static.haveacc') !!}</span>
                        <a href="{{route("login", ['locale' => App::getLocale()])}}" class="login-registration-question__link font-n-b">{!! __('static.login') !!}</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>
    <script>
        document.getElementById('togglePassword1').addEventListener('click', function() {
            const passwordField = document.getElementById('userPassword');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        document.getElementById('togglePassword2').addEventListener('click', function() {
            const passwordField = document.getElementById('userPassword2');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
        document.addEventListener("DOMContentLoaded", function () {
            let infoIcon = document.getElementById("infoIcon");
            let tooltip = document.getElementById("customTooltip");



            infoIcon.addEventListener("click", function (event) {
                if (window.innerWidth <= 768) {
                    event.stopPropagation();
                    tooltip.style.display = tooltip.style.display === "block" ? "none" : "block";
                }
            });

            document.addEventListener("click", function () {
                if (window.innerWidth <= 768) {
                    tooltip.style.display = "none";
                }
            });
            });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneSuffix = document.getElementById('phoneSuffix');
            const mask = '___-__-__';

            phoneSuffix.value = mask;

            function setCursorToNextUnderscore(input) {
                const pos = input.value.indexOf('_');
                input.setSelectionRange(pos, pos);
            }

            phoneSuffix.addEventListener('focus', () => setCursorToNextUnderscore(phoneSuffix));
            phoneSuffix.addEventListener('click', () => setCursorToNextUnderscore(phoneSuffix));

            phoneSuffix.addEventListener('keydown', function (e) {
                const cursor = this.selectionStart;

                if (/\d/.test(e.key)) {
                    e.preventDefault();
                    const chars = this.value.split('');
                    let pos = this.selectionStart;

                    while (pos < chars.length) {
                        if (chars[pos] === '_') {
                            chars[pos] = e.key;
                            break;
                        }
                        pos++;
                    }

                    this.value = chars.join('');
                    setCursorToNextUnderscore(this);
                }

                if (e.key === 'Backspace') {
                    e.preventDefault();
                    const chars = this.value.split('');
                    let pos = this.selectionStart - 1;

                    while (pos >= 0) {
                        if (chars[pos] !== '-' && pos !== -1) {
                            chars[pos] = '_';
                            break;
                        }
                        pos--;
                    }

                    this.value = chars.join('');
                    this.setSelectionRange(pos >= 0 ? pos : 1, pos >= 0 ? pos : 1);
                }
            });

            phoneSuffix.addEventListener('input', function () {
                if (this.value.length !== mask.length) {
                    this.value = mask;
                    setCursorToNextUnderscore(this);
                }
            });
        });
    </script>

@endsection