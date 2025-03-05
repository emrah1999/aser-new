@extends('web.layouts.web')
@section('title')
    {{$blog->ceo_title}}
@endsection

@section('description')
    {{$blog->seo_description}}
@endsection


@section('breadcrumbs')
    <li class="nav-breadcrumbs__item ">
        <a href="{{ route('menuIndex', ['locale' => App::getLocale(),optional($menu['blog'])->{'slug_' . App::getLocale()}]) }}" class="nav-breadcrumbs__link ">{{ optional($menu['blog'])->{'name_' . App::getLocale()} }}</a>
    </li>
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{{$blog->name}}</li>
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-blog-detail">
            <div class="container">
                <div class="blog-detail">
                    <div class="blog-detail__image">
                        <img src="{{ $blog->internal_images }}" alt="Blog Image">
                    </div>

                    <h1 class="blog-detail__title">{{ $blog->name }}</h1>

                    <div class="blog-detail__content">
                        {!! __($blog->content) !!}
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection



@section('styles')
    <style>


        .blog-detail__image {
            text-align: center;
            margin-bottom: 20px;
        }

        .blog-detail__image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .blog-detail__title {
            font-size: 28px;
            text-align: center;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .blog-detail__content {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .blog-detail__quote {
            background: #f9f4f2;
            padding: 20px;
            margin-top: 30px;
            border-left: 5px solid #ff9900;
            font-style: italic;
            text-align: center;
            border-radius: 5px;
        }

        .blog-detail__quote p {
            font-size: 18px;
            color: #444;
        }

        .blog-detail__quote span {
            font-size: 14px;
            color: #777;
            display: block;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .container {
                max-width: 90%;
                padding: 15px;
            }

            .blog-detail__title {
                font-size: 24px;
                margin-bottom: 15px;
            }

            .blog-detail__content {
                font-size: 15px;
            }

            .blog-detail__quote {
                padding: 15px;
                margin-top: 20px;
            }

            .blog-detail__quote p {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .container {
                max-width: 95%;
                padding: 10px;
            }

            .blog-detail__title {
                font-size: 22px;
                margin-bottom: 10px;
            }

            .blog-detail__content {
                font-size: 14px;
                line-height: 1.5;
            }

            .blog-detail__quote {
                padding: 10px;
                font-size: 14px;
            }

            .blog-detail__quote p {
                font-size: 14px;
            }

            .blog-detail__quote span {
                font-size: 12px;
            }
        }

.section-breadcrumbs{
    padding-bottom: 0;
}


</style>
@endsection
