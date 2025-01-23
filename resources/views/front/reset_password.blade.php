@extends('front.app')
@section('content')
    <section class="login-section ">
        <div class="login-left-panel"></div>
        <div class="login-right-panel">
            <div class="login-link">
               
            </div>
            <div class="login-form-block only-login sign-main">
                <div class="form-header">
                    <h3> {!! __('auth.reset_password') !!} </h3>
                </div>

                <br><br><br>

                <div class="error-notification show-block">
                    {!! __('auth.reset_password_text') !!}
                </div>

                <div class="login-form">
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="def-label field-passwordresetrequestform-email required has-error">
                            <span><span class="label-sm"><label class="control-label"
                                                                for="email">{!! __('labels.email') !!}</label></span></span><input
                                type="text" id="email" class="form-control"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                placeholder="mail@mail.com"
                                name="email"
                                required>
                        </div>
                        <button type="submit" class="orange-button"> {!! __('auth.reset_password_button') !!}</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('css')

@endsection

@section('js')

@endsection