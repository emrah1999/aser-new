@extends('web.layouts.web')
@section('styles')
    <style>
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
    </style>

@endsection
@section('content')
    @if (session('case'))
        <div class="alert alert-{{ session('case') }}" style="height: 4rem;">
            <strong>{{ session('title') }}</strong> {{ session('content') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" style="height: 4rem;">
            <strong>{!! __('static.error') !!}  </strong> {!!  __('static.error_text') !!}
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!} </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="content" id="content">
        <section class="section section-registration d-flex justify-content-center align-items-center">
            <div class="container-lg">
                <form class="form form-registration center-block" name="formRegistrationJuridical" id="formRegistrationJuridical" method="post" action="{{route("register", ['locale' => App::getLocale()])}}" novalidate="novalidate">
                    @csrf
                    <input class="form__input" name="is_legality" value="1" type="hidden">
                    <h1 class="form-registration__title text-center font-n-b">Aser-ə xoş gəlmişsiniz!</h1>
                    <p class="form-registration__title-2 text-center font-n-b">Qeydiyyat forumu</p>
                    <div class="form-registration__btn-types d-flex justify-content-center align-items-center">
                        <div class="col">
                            <a href="{{route("register", ['locale' => App::getLocale(), 'type' => 'physical'])}}" class="btn btn-trns-yellow btn-block form-registration__btn-type font-n-b">Fiziki şəxs</a>
                        </div>
                        <div class="col">
                            <a href="{{route("register", ['locale' => App::getLocale(), 'type' => 'juridical'])}}" class="btn btn-trns-yellow btn-block btn-trns-yellow--active form-registration__btn-type form-registration__btn-type--pos-rel-left font-n-b">Hüquqi şəxs</a>
                        </div>
                    </div>
                    <div class="form-registration__content form-registration__content--1">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userVoen">Vöen</label>
                                    <input class="form__input" name="voen" type="text" id="userVoen" placeholder="Vöeni daxil edin" value="{{ old('voen') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userCompanyName">Şirkətin adı</label>
                                    <input class="form__input" name="company_name" type="text" id="userCompanyName" placeholder="Şirkətin adı daxil edin" value="{{ old('company_name') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userName">{!! __('auth.Name') !!}</label>
                                    <input class="form__input" name="name" type="text" id="userName" placeholder="Adınızı daxil edin" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSurname">{!! __('auth.Surname') !!}</label>
                                    <input class="form__input" name="surname" type="text" id="userSurname" placeholder="Soyadınızı daxil edin" value="{{ old('surname') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userEmail">{!! __('auth.Email') !!}</label>
                                    <input class="form__input" name="email" type="email" id="userEmail" placeholder="Emailiniz daxil edin" value="{{ old('email') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="phone">{!! __('auth.Phone') !!}</label>
                                    <input class="form__input" name="phone1" type="text" id="phone" placeholder="xxx-xxx-xx-xx" value="{{ old('phone1') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSex">{!! __('auth.City') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" name="city" id="city" required>
                                            <option value="">Seç</option>
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
                                    <label class="form__label" for="userAddress">{!! __('auth.Address') !!}</label>
                                    <input class="form__input" name="address1" type="text" id="userAddress" placeholder="Ünvanızı daxil edin" value="{{ old('address1') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userBranch">{!! __('auth.branch') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" name="branch_id" id="userBranch" required>
                                            <option value="0" disabled selected>{!! __('auth.branch') !!}</option>
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
                                    <label class="form__label" for="userPassword">{!! __('auth.Password') !!}</label>
                                    <div class="input-container" style="position: relative;">
                                        <input class="form__input" name="password" value="{{ old('password')}}" type="password" id="userPassword" placeholder="Şifrənizi daxil edin" required style="padding-right: 30px;">
                                        <span class="eye-icon" id="togglePassword1" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px;">
                <i class="fas fa-eye"></i>
            </span>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPassword2">Təkrar şifrə</label>
                                    <div class="input-container" style="position: relative;">
                                        <input class="form__input" name="user_password2" value="{{ old('user_password2')}}" type="password" id="userPassword2" placeholder="Təkrar şifrənizi daxil edin" required style="padding-right: 30px;">
                                        <span class="eye-icon" id="togglePassword2" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px;">
                <i class="fas fa-eye"></i>
            </span>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>


{{--                            <div class="col-sm-6">--}}
{{--                                <div class="form__group">--}}
{{--                                    <label class="form__label" for="userSex">{!! __('auth.Gender') !!}</label>--}}
{{--                                    <div class="form__select-wrapper">--}}
{{--                                        <select class="form__select" name="gender" id="userSex" required>--}}
{{--                                            <option value="">{!! __('auth.gender_select') !!}</option>--}}
{{--                                            <option value="1">{!! __('auth.male') !!}</option>--}}
{{--                                            <option value="0">{!! __('auth.female') !!}</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="invalid-feedback"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-sm-6">--}}
{{--                                <div class="form__group">--}}
{{--                                    <img src="{{asset('uploads/static/info.png')}}" height="15px" width="15px" data-toggle="tooltip" data-placement="right" title="" style="display: inline-block;" data-original-title="Bu bölmə “Dostunu gətir daha çox qazan” kampaniyası üçün nəzərdə tutulmuşdur. Burada, sizi xidmətimizdən istifadə etmək üçün dəvət edən dostunuzun Aser şəxsi nömrəsi yazılmalı və yaxud xidmətimizdən istifadə üçün sizin dəvət linkinizlə gələn dostlarınız qeydiyyat zamanı linkdə sizə məxsus olan Aser şəxsi nömrənizi qeyd etməlidilər.">--}}
{{--                                    <label class="form__label" for="userRefer">{!! __('auth.ParentCode') !!}</label>--}}
{{--                                    <input class="form__input" name="parent_code" type="text" id="userRefer">--}}
{{--                                    <div class="invalid-feedback"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="form-registration__content form-registration__content--2 d-none">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPassportSeria">{!! __('auth.PassportSeries') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" name="passport_series" id="userPassportSeria" required>
                                            <option value="0" disabled {{ old('passport_series') ? '' : 'selected' }}>Seçin</option>
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
                                    <div class="form__group">
                                        <label class="form__label" for="userPassportSeriaNumber">{!! __('auth.PassportNumber') !!}</label>
                                        <input class="form__input" name="passport_number" type="text" id="userPassportSeriaNumber" placeholder="Ş.V-nin nömrəsini daxil edin" value="{{ old('passport_number') }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPassportFinCode">{!! __('auth.PassportFIN') !!}</label>
                                    <input class="form__input" name="passport_fin" type="text" id="userPassportFinCode" placeholder="Fin kodu daxil edin" value="{{ old('passport_fin') }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-sm-6">

                            </div>
                        </div>
                    </div>
                    <div class="form-registration__btn-actions form-registration__btn-actions--1">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form-checkbox d-flex justify-content-start align-items-center" for="userAgree">
                                        <input class="form-checkbox__input" name="agreement" type="checkbox" id="userAgree">
                                        <span class="form-checkbox__span"></span>
                                        <a href="https://asercargo.az/uploads/static/terms.pdf" target="_blank">
                                            <span class="form-checkbox__text" style="animation: blink 1s infinite;">{!! __('auth.agreement') !!}</span>
                                        </a>
                                        <div class="invalid-feedback"></div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-yellow btn-block form__btn form-registration__btn-action form-registration__btn-action--next font-n-b" type="button">Irəli</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-registration__btn-actions form-registration__btn-actions--2 d-none">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-6">
                                <button class="btn btn-black btn-block form__btn form-registration__btn-action form-registration__btn-action--prev font-n-b" type="button">Geriyə qayıt</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-yellow btn-block form__btn form-registration__btn-action form-registration__btn-action--submit font-n-b" name="formRegistrationJuridicalSubmit" type="submit">Qeydiyyatdan keçin</button>
                            </div>
                        </div>
                    </div>
                    <div class="login-registration-question">
                        <p class="login-registration-question__block text-center">
                            <span class="login-registration-question__title">Hesabınız var?</span>
                            <a href="login.html" class="login-registration-question__link font-n-b">Daxil olun</a>
                        </p>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script>
        // Şifrə göster/gizle işlemleri
        document.getElementById('togglePassword1').addEventListener('click', function() {
            const passwordField = document.getElementById('userPassword');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // İkonu değiştir
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        document.getElementById('togglePassword2').addEventListener('click', function() {
            const passwordField = document.getElementById('userPassword2');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // İkonu değiştir
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection