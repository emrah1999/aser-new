@extends('web.layouts.web')
@section('title')
    {{$blog->ceo_title}}
@endsection

@section('description')
    {{$blog->seo_description}}
@endsection




@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item ">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['logistics'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link">{!! __('breadcrumbs.logistics') !!}</a>
    </li>
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{{$blog->name}}</li>
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-cargo-service">
            <div class="container-lg">
                <div class="media media-cargo-service">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="media-cargo-service__body">
                                <h1 class="media-cargo-service__title font-n-b">{{$blog->name}}</h1>
                                <p class="media-cargo-service__desc">
                                   {!! __($blog->content) !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-cargo-service__right">
                                <img class="media-cargo-service__img img-responsive" src="{{$blog->internal_images}}" alt="Cargo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection