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
                                <img class="media-news-details__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="media-news-details__right">
                            <h5 class="media-news-details__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                            <p class="media-news-details__time d-flex justify-content-start align-items-center">
                                <img class="media-news-details__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                <span class="media-news-details__time-title">27.06.2024 11:04</span>
                            </p>
                            <p class="media-news-details__desc">Trendyoldan daha öncə sifariş etməyən bütün müştərilər üçün 17-23 avqust tarixlərində çatdırılma pulsuz olacaq</p>
                            <p class="media-news-details__desc">Trendyoldan daha öncə sifariş etməyən bütün müştərilər üçün 17-23 avqust tarixlərində çatdırılma pulsuz olacaq</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection