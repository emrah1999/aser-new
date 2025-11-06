@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-about">
            <div class="container-lg">
                {{-- <h1 class="section-title text-center font-n-b">{!! __('static.about_us1', ['locale' => App::getLocale()]) !!}</h1> --}}
                <h1 class="section-title text-center font-n-b mb-3">{{$title->about}}</h1>
                <p class="section__desc text-center mb-5">{{$title->description_about}}</p>
                <div class="section-desc">
                    {!! __('static.about_us') !!}
                </div>
            </div>
        </section>
    </div>
@endsection