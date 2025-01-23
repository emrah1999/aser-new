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
                                    <h1 class="profile-title-block__title font-n-b">Şəxsi məlumatlar</h1>
                                </a>
                            </div>
                            <div class="col-xxl-4">

                            </div>
                        </div>
                    </div>
                    <form class="form form-profile-information-edit" name="formProfileInformationEdit" id="formProfileInformationEdit" method="post" action="{{route("post_update_user_account", ['locale' => App::getLocale()])}}" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userName">{!! __('register.input_name') !!}</label>
                                    <input class="form__input" name="name" type="text" id="name" placeholder="Adınızı daxil edin" value="{{Auth::user()->name}}" readonly disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSurname">{!! __('register.input_surname') !!}</label>
                                    <input class="form__input" name="user_surname" type="text" id="userSurname" placeholder="Soyadınızı daxil edin" readonly disabled value="{{Auth::user()->surname}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="passport_prefix">{!! __('auth.PassportSeries') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" name="passport_prefix" id="passport_prefix">
                                            <option value="{{Auth::user()->passport_series}}" selected>{{Auth::user()->passport_series}}</option>
                                            <option value="AZE">AZE</option>
                                            <option value="MYI">MYI</option>
                                            <option value="DYI">DYI</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <div class="form__group">
                                        <label class="form__label" for="passport_number">{!! __('auth.PassportNumber') !!}</label>
                                        <input class="form__input" name="passport_number" type="text" id="passport_number" placeholder="Ş.V-nin nömrəsini daxil edin" required  value="{{Auth::user()->passport_number}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPassportFinCode">{!! __('auth.PassportFIN') !!}</label>
                                    <input class="form__input" type="text" id="passport_fin" name="passport_fin" value="{{Auth::user()->passport_fin}}" readonly disabled>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="birthday">{!! __('register.input_birthday') !!}</label>
                                    <input class="form__input" name="birthday" type="date" id="birthday" required value="{{ Auth::user()->birthday }}">
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="address">{!! __('register.input_address') !!}</label>
                                    <input class="form__input" name="address" type="text" id="userAddress" placeholder="Ünvanızı daxil edin" required value="{{Auth::user()->address1}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="phone1">{!! __('auth.Phone') !!}</label>
                                    <input class="form__input" name="phone1" type="text" id="phone1" value="{{Auth::user()->phone1}}"
																		       disabled readonly >
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form__group">
                                    <label class="form__label" for="email">{!! __('register.input_email') !!}</label>
                                    <input class="form__input" name="email" type="email" id="email" value="{{Auth::user()->email}}" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form__group">
                                    <label class="form__label" for="userSex">{!! __('auth.Language') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" name="language" id="language" required>
                                        @switch(Auth::user()->language)
                                            @case('AZ')
                                            <option selected value="AZ">AZ
                                            </option>
                                            <option value="EN">EN</option>
                                            <option value="RU">RU</option>
                                            @break
                                            @case('EN')
                                            <option value="AZ">AZ</option>
                                            <option selected value="EN">EN
                                            </option>
                                            <option value="RU">RU</option>
                                            @break
                                            @case('RU')
                                            <option value="AZ">AZ</option>
                                            <option value="EN">EN</option>
                                            <option selected value="RU">RU
                                            </option>
                                            @break
                                        @endswitch
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form__group">
                                    <label class="form__label" for="branch_id">Filial</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" name="branch_id" id="branch_id" required>
                                            <option value="" disabled>Filialın adı</option>
                                            @foreach($branchs as $branch)
                                                <option value="{{$branch->id}}" {{ isset(Auth::user()->branch_id) && Auth::user()->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-trns-black btn-block form__btn form-profile-information-edit__btn font-n-b">Ləğv et</a>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-blue btn-block form__btn form-profile-information-edit__btn font-n-b" name="formProfileInformationEditSubmit" type="submit">Yadda saxla</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection