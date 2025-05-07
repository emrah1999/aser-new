@extends('web.layouts.web')
@section('content')

<div class="content" id="content">
    <section class="section section-profile-settings">
        <div class="container-lg">
            <div class="row">
                @include("web.account.account_left_bar")
                    <div class="col-sm-4">
                        @if (session()->has('case') && session('case') === 'error1')
                            <div class="alert alert-danger d-flex align-items-center p-3 shadow-lg rounded-3" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle me-2">
                                    <path d="M..."/>
                                </svg>
                                <div>
                                    <strong>{{ session('content') }}</strong>
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('case') && session('case') === 'success')
                            <div class="alert alert-success d-flex align-items-center p-3 shadow-lg rounded-3" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle me-2">
                                    {{--                            <path d="M16 8a.5.5 0 0 1 .374.833l-5.5 6a.5.5 0 0 1-.748 0l-2.5-3a.5.5 0 0 1 .748-.664l2.126 2.553 5.126-5.593A.5.5 0 0 1 16 8z"/>--}}
                                    {{--                            <path d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zm0 1a7 7 0 1 1-7 7A7 7 0 0 1 8 1z"/>--}}
                                </svg>
                                <div>
                                    <strong>{{ session('content') }}</strong>
                                </div>
                            </div>
                        @endif
                        <h3 class="form-profile-curier__title  font-n-b">{!! __('static.change_password') !!}</h3>
                    <form action="{{route('post_update_user_password', ['locale' => \Illuminate\Support\Facades\App::getLocale()])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label>{!! __('static.current_password') !!}</label>
                        <div class="form-group pass_show">
                            <input type="password" value="{{old('currentPassword')}}"  name="currentPassword" class="form-control" placeholder="{!! __('static.current_password') !!}">
                        </div>
                        <label>{!! __('static.new_password') !!}</label>
                        <div class="form-group pass_show">
                            <input type="password" value="{{old('newPassword')}}" class="form-control"  name="newPassword" placeholder="{!! __('static.new_password') !!}">
                        </div>
                        <label>{!! __('static.confirm_password') !!}</label>
                        <div class="form-group pass_show">
                            <input type="password" value="{{old('confirmPassword')}}" class="form-control"  name="confirmPassword" placeholder="{!! __('static.confirm_password') !!}">
                        </div>
                        <button class="btn btn-success mt-4" type="submit" >{!! __('static.submit') !!}</button>
                    </form>
                    </div>
                </div>

            </div>
    </section>
</div>
@endsection
@section('styles')
    <style>
        .pass_show{position: relative}

        .pass_show .ptxt {

            position: absolute;

            top: 50%;

            right: 10px;

            z-index: 1;

            color: #f36c01;

            margin-top: -10px;

            cursor: pointer;

            transition: .3s ease all;

        }

        .pass_show .ptxt:hover{color: #333333;}
    </style>
    <style>
        @media (max-width: 575.98px) {
            .footer{
                padding: 10px 0;
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        }
    </style>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('.pass_show').append('<span class="ptxt">{{ __("static.show") }}</span>');

        });


        $(document).on('click','.pass_show .ptxt', function(){

            $(this).text($(this).text() == '{{ __("static.show") }}' ? '{{ __("static.hide") }}' : '{{ __("static.show") }}');
            $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });

        });
    </script>
@endsection