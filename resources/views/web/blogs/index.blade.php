@extends('web.layouts.web')
@section('breadcrumbs')
    <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">{{ optional($menu['blog'])->{'name_' . App::getLocale()} }}</li>
@endsection
@section('content')
    <div class="content" id="content">
        <section class="section section-blogs">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b mb-3">{{$title->blogs}}</h1>
                <p class="section__desc text-center mb-5">{{$title->description_blogs}}</p>
                <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-sm-4">
                            <div class="thumbnail thumbnail-blogs">
                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $blog->slug]) }}" class="thumbnail-blogs__link">
                                    <div class="thumbnail-blogs__img-block">
                                        <img class="thumbnail-blogs__img img-responsive" src="{{ $blog->icon }}" alt="Blog">
                                    </div>
                                    <h4 class="thumbnail-blog-2__title font-n-b">{{$blog->name}}</h4>
                                </a>
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </div>
@endsection
@section('styles')
     <style>
         .thumbnail-blog-2__title{
             margin-top: 10px;
             color: black;
             text-align: center;
         }
     </style>

@endsection
@section('scripts')

@endsection