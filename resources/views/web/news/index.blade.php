@extends('web.layouts.web')
@section('content')

<div class="content" id="content">
    <section class="section section-news">
        <div class="container-lg">
            <h1 class="section-title text-center font-n-b">{!! __('static.news_and_updates', ['locale' => App::getLocale()]) !!}</h1>
            <div class="row">
                @foreach($newses as $news)
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale(),$news->id])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{$news->image}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">{{$news->name}}</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">{{$news->created_at}}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection