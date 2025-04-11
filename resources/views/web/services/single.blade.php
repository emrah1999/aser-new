@extends('web.layouts.web')
@section('title')
    {{$service->ceo_title}}
@endsection

@section('description')
    {{$service->seo_description}}
@endsection




@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item ">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['logistics'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link">{!! __('breadcrumbs.logistics') !!}</a>
    </li>
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{{$service->name}}</li>
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-cargo-service">
            <div class="container-lg">
                <div class="media media-cargo-service">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="media-cargo-service__body">
                                <h1 class="media-cargo-service__title font-n-b">{{$service->name}}</h1>
                                <div class="media-cargo-service__desc">
                                    {!! $service->content !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-cargo-service__right">
                                <img class="media-cargo-service__img img-responsive" src="{{$service->internal_images}}" alt="Cargo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        .media-cargo-service__desc p {
            margin: 0;
            padding: 0;
            overflow: hidden;
            word-wrap: break-word;
        }

    </style>
@endsection