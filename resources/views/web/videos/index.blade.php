@extends('web.layouts.web')
@section('title')
    {{$title->video}}
@endsection

@section('description')
    {{$title->description_video}}
@endsection
@section('content')
<div class="content" id="content">
    <section class="section section-video">
        <div class="container-lg">
            {{-- <h1 class="section-title text-center font-n-b">{!! __('static.vodeos1', ['locale' => App::getLocale()]) !!}</h1> --}}
            <h1 class="section-title text-center font-n-b mb-3">{{$title->video}}</h1>
            <div class="row">
                @foreach ($videos as $v)
                <div class="col-lg-4 col-md-6">
                    <div class="thumbnail thumbnail-video">
                        <iframe class="thumbnail-video__iframe" width="100%" height="300" src="{{ $v->link }}" allowfullscreen></iframe>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
</div>
@endsection