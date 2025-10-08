@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-about">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{!! __('static.about_us1', ['locale' => App::getLocale()]) !!}</h1>
                <div class="section-desc">
                    {!! __('static.about_us') !!}
                </div>
            </div>
        </section>
    </div>
@endsection