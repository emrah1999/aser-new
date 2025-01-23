@extends('web.layouts.web')
@section('content')

<div class="content" id="content">
    <section class="section section-news">
        <div class="container-lg">
            <h1 class="section-title text-center font-n-b">Xəbərlər və yeniliklər</h1>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale()])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">27.06.2024  11:04</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale()])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">27.06.2024  11:04</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale()])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">27.06.2024  11:04</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale()])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">27.06.2024  11:04</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale()])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">27.06.2024  11:04</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail thumbnail-news">
                        <a href="{{route('news_details', ['locale' => App::getLocale()])}}" class="thumbnail-news__link">
                            <div class="thumbnail-news__img-block">
                                <img class="thumbnail-news__img img-responsive" src="{{asset('web/images/content/news.png')}}" alt="News">
                            </div>
                            <div class="thumbnail-news__caption">
                                <h5 class="thumbnail-news__title font-n-b">Geniş filial şəbəkəsi, vaxtında çatdırılma</h5>
                                <p class="thumbnail-news__time d-flex justify-content-start align-items-center">
                                    <img class="thumbnail-news__time-icon" src="{{asset('web/images/content/other-time.png')}}" alt="Time">
                                    <span class="thumbnail-news__time-text">27.06.2024  11:04</span>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection