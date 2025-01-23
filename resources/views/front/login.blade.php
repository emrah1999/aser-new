@extends('front.app')
@section('content')

<section class="login_section full">
    <div class="container">
        <div class="row">
            <!-- page title -->
            <div class="col-md-12 page_title login_page_title"></div>
            <!-- page title end -->
            <div class="col-md-12 login_container">
                <div class="row justify-content-between">
                    <div class="login_left_side">
                        <div class="login_left">
                            <h3 class="full">{!! __('auth.login') !!}</h3>
                            <form action="{{ route('login') }}" method="post" autocomplete="off">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group field-loginform-email required">
                                    <input type="email" id="loginform-email" class="form-control floating-input login_email" name="email" placeholder=" " aria-required="true" value="{{ old('email') }}" autocomplete="off">
                                    <label class="animate_label" for="loginform-email">{!! __('labels.email') !!}</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group field-loginform-password required">
                                    <input type="password" id="loginform-password" class="form-control floating-input login_pass" name="password" placeholder=" " aria-required="true" autocomplete="off">
                                    <label class="animate_label" for="loginform-password">Şifrə</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div style="padding: 1.25rem !important;">
                                    <input style="-webkit-appearance: checkbox; display: block;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {!! __('auth.remember') !!}
                                    </label>
                                </div>                                                              
                                <div class="login_submit">
                                    <button type="submit" id="submit-button">{!! __('auth.login_title') !!}</button>
                                </div>
                                <div class="forget_pass">
                                    <a href="{{ route('password.request') }}" data-effect="mfp-zoom-in" class="popup_btn">{!! __('auth.forgot_password')!!}</a>
                                </div>
                                
                            </form>
                            <div class="have_account" style="margin-top: 15px;">
                                    <p>{!! __('auth.have_account') !!}<a href="{{route("register")}}">{!! __('auth.got_to_registr') !!}</a></p>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login_right_img">
                            <img src="{{ asset('front/image/login_img.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<!-- Gerekli CSS dosyaları -->
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputs = document.querySelectorAll('input[autocomplete="off"]');
            inputs.forEach(function(input) {
                input.setAttribute('autocomplete', 'new-password');
            });
        });

    </script>
<!-- Gerekli JavaScript dosyaları -->
@endsection
