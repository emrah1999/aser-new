@extends('web.layouts.web')
@section('breadcrumbs')
    {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="">Kateqoriyalar</a></li> --}}
    {{--    <li class="breadcrumb-item" aria-current="">Cari Səhifə</li>--}}
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['branch'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link nav-breadcrumbs__item--active">{!! __('breadcrumbs.branches') !!}</a>
    </li>
@endsection

@section('title')
    {{$menu['branch']->{'title_' . App::getLocale()} }}
@endsection

@section('description')
    {{$menu['branch']->{'description_' . App::getLocale()} }}
@endsection

@section('content')
    <div class="content" id="content">
        <section class="section section-branches">
            <div class="container-lg">
                <div class="media media-branches">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="media-branches__left">
                                <iframe class="media-branches__map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d759.7081685227259!2d49.84359226553985!3d40.39040094792123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307d30e58f34c5%3A0xdbd9946f959d9e!2sAser%20Cargo%20Express!5e0!3m2!1str!2saz!4v1726507917582!5m2!1str!2saz" width="100%" height="660" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="media-branches__right">
                                @foreach($branches as $branch)
                                    <div class="thumbnail thumbnail-branches">
                                        <h6 class="thumbnail-branches__title font-n-b">{{$branch->name}}</h6>
                                        <p class="thumbnail-branches__title2 font-n-b">Ünvan</p>
                                        <p class="thumbnail-branches__desc2 font-n-b">{{$branch->address}}</p>
                                        <br>
                                        <p class="thumbnail-branches__title2 font-n-b">Əlaqə nömrəsi</p>
                                        <p class="thumbnail-branches__desc2 font-n-b">{{$branch->phone1}}</p>
                                        <p class="thumbnail-branches__desc2 font-n-b">{{$branch->phone2}}</p>
                                        <br>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="#" class="btn btn-trns-blue thumbnail-branches__link font-n-b" data-map="{{$branch->map_location}}">Xəritədə bax</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection