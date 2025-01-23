@extends('front.app')
@section('content')
    <section class="login-section " style="background-color: #fdfaf6;">
        <div class="login-left-panel"></div>
        <div class="login-right-panel">
            <div class="login-link">
            </div>
            <div class="login-form-block only-login sign-main">
                <div class="form-header">
                    <h3 style="color: #333"> {!! __('reset_password.title') !!} </h3>
                </div>
                <br><br><br>
                <div class="login-form">
                    <form id="signin-form" method="POST" action="{{ route('password.update') }}" novalidate>
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="def-label field-loginform-email required">
                            <span><span class="label-sm"><label class="control-label"
                                                                for="loginform-email" style="color: #333">{!! __('labels.email') !!}</label></span><p
                                        class="help-block help-block-error"></p></span><input type="text"
                                                                                              id="loginform-email email"
                                                                                              class="form-control @error('email') is-invalid @enderror"
                                                                                              name="email"
                                                                                              placeholder="mail@mail.com"
                                                                                              autocomplete="off"
                                                                                              aria-required="true">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="password-el">
                            <div class="def-label field-loginform-password required">
                                <span><span class="label-sm"><label class="control-label"
                                                                    for="loginform-password" style="color: #333">{!! __('labels.password') !!}</label></span><p
                                            class="help-block help-block-error"></p></span><input type="password"
                                                                                                  id="loginform-password password"
                                                                                                  class="form-control @error('password') is-invalid @enderror"
                                                                                                  name="password"
                                                                                                  placeholder="••••••••••••"
                                                                                                  required
                                                                                                  autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <span class="control-password"><i class="fas fa-eye"></i></span>
                        </div>

                        <div class="password-el">
                            <div class="def-label field-loginform-password required">
                                <span><span class="label-sm"><label class="control-label"
                                                                    for="loginform-password" style="color: #333">{!! __('labels.password_again') !!}</label></span><p
                                            class="help-block help-block-error"></p></span><input type="password"
                                                                                                  id="loginform-password password"
                                                                                                  class="form-control @error('password') is-invalid @enderror"
                                                                                                  name="password_confirmation"
                                                                                                  placeholder="••••••••••••"
                                                                                                  required
                                                                                                  autocomplete="new-password">
                            </div>
                            <span class="control-password"><i class="fas fa-eye"></i></span>
                        </div>

                        <div class="flex-between register-submit">
                            <button type="submit" class="orange-button"> {!! __('reset_password.submit_button') !!} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
<style>
    .def-label input:not(.vs__search){
        color: #f4a51c !important;
        padding: 10px 10px;
    }
</style>
@endsection

@section('js')

@endsection