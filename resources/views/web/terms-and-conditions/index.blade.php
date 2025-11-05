@extends('web.layouts.web')
@section('content')
    <section class="section section-rules">
        <div class="container-lg terms"  >
            {{-- <h1 class="section-title text-center font-n-b">{!! __('static.terms1', ['locale' => App::getLocale()]) !!}</h1> --}}
            <h1 class="section-title text-center font-n-b mb-3">{{$title->terms}}</h1>
            <p class="section__desc text-center mb-5">{{$title->description_terms}}</p>
            <p class="section__desc">{!! __('static.terms_title', ['locale' => App::getLocale()]) !!}</p>
            <ol class="nav nav-rules">
                <li class="nav-rules__item">{!! __('static.terms_text1', ['locale' => App::getLocale()]) !!}
                </li>
                <li class="nav-rules__item">
                    {!! __('static.terms_text2', ['locale' => App::getLocale()]) !!}
                    https://c2b.customs.gov.az/Tnved_public.aspx
                </li>
                <li class="nav-rules__item">
                    {!! __('static.terms_text3', ['locale' => App::getLocale()]) !!}
                </li>
                <li class="nav-rules__item">
                    {!! __('static.terms_text4', ['locale' => App::getLocale()]) !!}
                </li>
                <li class="nav-rules__item">
                    {!! __('static.terms_text5', ['locale' => App::getLocale()]) !!}
                </li>
                <li class="nav-rules__item">
                    {!! __('static.terms_text6', ['locale' => App::getLocale()]) !!}
                </li>
                <li class="nav-rules__item">
                    {!! __('static.terms_text7', ['locale' => App::getLocale()]) !!}
                </li>
            </ol>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .terms{
            margin-top : 100px;
        }#header{
             margin-bottom: 15px;
         }

        @media (max-width: 768px) {
            .terms {
                margin-top: 0;
            }
            .section-rules{
                padding-top: 100px;
            }
        }

    </style>

@endsection