@extends('web.layouts.web')
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

                <div class="login-form">
                    <form id="signin-form" method="POST" action="{{route('resetPasswordPage',['locale'=>\Illuminate\Support\Facades\App::getLocale()])}}" novalidate>
                        @csrf

                        <div class="password-el">
                            <div class="def-label field-loginform-password required">
                                <span><span class="label-sm"><label class="control-label"
                                                                    for="loginform-password" style="color: #333">{!! __('labels.password') !!}</label></span><p
                                            class="help-block help-block-error"></p></span><input type="password"
                                                                                                  id="loginform-password password"
                                                                                                  class="form-control @error('password') is-invalid @enderror"
                                                                                                  name="password"
                                                                                                  required
                                                                                                  autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="password-el">
                            <div class="def-label field-loginform-password required">
                                <span><span class="label-sm"><label class="control-label"
                                                                    for="loginform-password" style="color: #333">{!! __('labels.password_again') !!}</label></span><p
                                            class="help-block help-block-error"></p></span><input type="password"
                                                                                                  id="loginform-password password"
                                                                                                  class="form-control @error('password') is-invalid @enderror"
                                                                                                  name="password_confirmation"
                                                                                                  required
                                                                                                  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="flex-between register-submit">
                            <button type="submit" class="orange-button"> {!! __('reset_password.submit_button') !!} </button>
                        </div>
                        <input type="hidden" name="email" value="{{$user->email}}">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        /*.def-label input:not(.vs__search){*/
        /*    color: #f4a51c !important;*/
        /*    padding: 10px 10px;*/
        /*}*/
        /*body {*/
        /*    font-family: 'Poppins', sans-serif;*/
        /*    background-color: #fdfaf6;*/
        /*    color: #333;*/
        /*}*/

        .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .login-right-panel {
            margin-top: 100px;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .form-header h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-form {
            margin-top: 20px;
        }

        .def-label {
            text-align: left;
            margin-bottom: 15px;
        }

        .def-label label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }

        .def-label input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s ease;
        }

        .def-label input:focus {
            border-color: #f4a51c;
            outline: none;
        }

        .password-el {
            position: relative;
        }

        .control-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            transition: color 0.3s;
        }

        .control-password:hover {
            color: #f4a51c;
        }

        .orange-button {
            width: 100%;
            background: linear-gradient(to right, #f4a51c, #ff8400);
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .orange-button:hover {
            background: linear-gradient(to right, #ff8400, #f4a51c);
            transform: scale(1.02);
        }

        @media (max-width: 600px) {
            .login-right-panel {
                padding: 30px;
            }

            .form-header h3 {
                font-size: 20px;
            }

            .def-label input {
                font-size: 14px;
                padding: 10px;
            }

            .orange-button {
                font-size: 14px;
                padding: 10px;
            }
            .sign-main{
                margin-top: 100px;
            }
        }

    </style>
@endsection

@section('js')

@endsection