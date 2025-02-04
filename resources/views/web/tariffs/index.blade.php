@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-tarifs">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">Xaricdən sifarişlərin sərfəli çatdıırlması</h2>
                <div class="row">
                    @foreach($countries as $country)
                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail thumbnail-tarifs">
                                <a href="
{{--                                {{ route('show_tariffs', ['locale' => App::getLocale(), 'country_id' => $country->id]) }}--}}
                                    " class="thumbnail-tarifs__link">
                                    <div class="thumbnail-tarifs__img-block">
                                        <img class="thumbnail-tarifs__img img-responsive" src="{{$country->icon}}" alt="Tarif">
                                    </div>
                                    <div class="thumbnail-tarifs__caption text-center">
                                        <h4 class="thumbnail-tarifs__title font-n-b">{{$country->name_az}}</h4>
                                        <p class="thumbnail-tarifs__desc">
                                            {{$country->content_az}}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="section section-blogs">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">Bloqlar</h1>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="/web/images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="/web/images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="/web/images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
@endsection
