@extends('front.app')
@section('content')
    <section class="login-section ">
        <div class="login-left-panel"></div>
        <div class="login-right-panel">
            <div class="login-link">
               
            </div>
            <div class="login-form-block only-login sign-main">
                <div class="form-header">
                    <h3 style="color: #333"> {!! __('forgot_password.title') !!} </h3>
                </div>
                <br><br><br>
                @if(session('display') == 'block')
                    <div class="alert alert-{{session('class')}}" role="alert">
                        {{session('message')}}
                    </div>
                @endif
                <div class="error-notification show-block">
                    {!! __('forgot_password.notification') !!}
                </div>
                <div class="login-form">
                    <form id="signin-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{!! __('labels.email') !!}">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="flex-between register-submit">
                            <button type="submit" class="orange-button"> {!! __('forgot_password.submit_button') !!} </button>
                        </div>
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