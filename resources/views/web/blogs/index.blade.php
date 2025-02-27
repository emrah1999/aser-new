@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-blogs">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">{{$title->blogs}}</h2>
                <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-sm-4">
                            <div class="thumbnail thumbnail-blogs">
                                <a href="{{ route('menuIndex', ['locale' => App::getLocale(), 'slug' => $blog->slug]) }}" class="thumbnail-blogs__link">
                                    <div class="thumbnail-blogs__img-block">
                                        <img class="thumbnail-blogs__img img-responsive" src="{{ $blog->icon }}" alt="Blog">
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
@section('styles')

@endsection
@section('scripts')

@endsection