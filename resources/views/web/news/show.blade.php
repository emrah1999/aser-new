@extends('web.layouts.web')
@section('content')
<div class="content" id="content">
    <section class="section section-news-details">
        <div class="container-lg">
            <h1 class="section-title text-center font-n-b">Xəbərlər və yeniliklər</h1>
            <div class="media media-news-details">
                <div class="row">
                    <div class="col-md-6">
                        <div class="media-news-details__left">
                            <div class="media-news-details__img-block">
                                <img class="media-news-details__img img-responsive" src="{{$news->image}}" alt="News">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media-news-details__right">
                            <h5 class="media-news-details__title font-n-b">{{$news->name}}</h5>
                            <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                <span class="thumbnail-news__time-text">{{$news->created_at}}</span>
                            </p>
                            <p class="media-news-details__desc">{{$news->content}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection