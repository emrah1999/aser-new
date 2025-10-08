@extends('front.app')
@section('content')
<div class="content-page-section">
    <div class="container">
        <div class="row">
            <!-- page title-->
            <div class="col-md-12 page_title" style="padding-top: 25px">
                <h1>{!! __('static.news_and_updates', ['locale' => App::getLocale()]) !!}</h1>
                <p class="left_middle">Xidmətlərimizlə bağlı ən son yeniliklər və xəbərlər burada!</p>
            </div>

            <div class="col-md-12 news_page_section">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 news_style">
                        <div class="news_slider_container ">
                            <div class="news_slider_image">
                                <a href="" class="full">
                                    <img src="{{asset("front/image/about_after.png")}}" alt="Aser Cargo Express xidmətinizdə" title="Aser Cargo Express xidmətinizdə">
                                </a>
                            </div>
                            <div class="news_slider_desc">
                                <a href="">Aser Cargo Express xidmətinizdə</a>
                                <span class="news_date">06-07-2024</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 news_style">
                        <div class="news_slider_container ">
                            <div class="news_slider_image">
                                <a href="" class="full">
                                    <img src="{{asset("front/image/about_after.png")}}" alt="DİQQƏT! Aser Cargo Express xidmətinizdə!" title="DİQQƏT! Aser Cargo Express xidmətinizdə!">
                                </a>
                            </div>
                            <div class="news_slider_desc">
                                <a href="">DİQQƏT! Aser Cargo Express xidmətinizdə!</a>
                                <span class="news_date">06-07-2024</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 news_style">
                        <div class="news_slider_container ">
                            <div class="news_slider_image">
                                <a href="" class="full">
                                    <img src="{{asset("front/image/about_after.png")}}" alt="Aser Cargo ilə bağlamalarınız dünyadan qapınıza." title="Aser Cargo ilə bağlamalarınız dünyadan qapınıza.">
                                </a>
                            </div>
                            <div class="news_slider_desc">
                                <a href="">Aser Cargo ilə bağlamalarınız dünyadan qapınıza.</a>
                                <span class="news_date">06-07-2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
    <style>
        .news_style{
            padding: 0px 15px !important;
        }
    </style>
@endsection

@section('js')

@endsection
