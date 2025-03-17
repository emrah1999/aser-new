@extends('web.layouts.web')
@section('content')
<div class="content" id="content">
    <section class="section section-shops">
        <div class="container-lg">
            <div class="row">
            <div class="col-xl-3 col-md-4">
                <form class="form form-search-categories" name="formSearchCategories" id="formSearchCategories" method="GET" action="{{ route('sellers_page', ['locale' => App::getLocale()]) }}">
                    @foreach ($categories as $category)
                        <div class="form__group form-search-categories__form-group">
                            <label class="form-checkbox d-flex justify-content-start align-items-center" for="shopCategory{{ $category->id }}">
                                <input class="form-checkbox__input" name="shop_categories[]" type="checkbox" id="shopCategory{{ $category->id }}" value="{{ $category->id }}" 
                                    {{ is_array(request('shop_categories')) && in_array($category->id, request('shop_categories')) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span class="form-checkbox__span"></span>
                                <span class="form-checkbox__text form-search-categories__form-checkbox-text">{{ $category->name }}</span>
                            </label>
                        </div>
                    @endforeach

                    <input type="hidden" name="location" value="{{ request('location') }}">
                </form>
            </div>
                <div class="col-xl-9 col-md-8">
                    <div class="title-block">
                        <div class="row justify-content-center align-items-start">
                            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-7 col-6">
                                <h1 class="title-block__title font-n-b">Mağazalar</h1>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-5 col-6">
                                <form class="form form-search" name="formSearch" id="formSearch" method="post" action="/" novalidate="novalidate">
                                    <div class="form__group nm">
                                        <input class="form__input" name="shop_search" type="text" id="shopSearch" placeholder="Mağaza adı..">
                                        <input class="form_input d-none" name="formSearchSubmit" type="submit">
                                        <img class="form-search__img" src="{{asset('web/images/content/other-search.png')}}" alt="Search">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="nav nav-tab-categories">
                        @foreach($countries as $country)
                            <a href="{{ route('sellers_page', array_merge(request()->query(), ['locale' => App::getLocale(), 'location' => $country->id])) }}" class="nav-tab-categories__link nav-tab-categories__link flex-fill d-flex justify-content-center align-items-center mr-5">
                                <img class="nav-tab-categories__link-img" src="{{$country->new_flag}}" alt="Turkey">
                                <span class="nav-tab-categories__link-title d-none d-md-block"> {{$country->name}}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="tab-content tab-content-categories">
                        <div class="tab-pane fade show active" id="turkey">
                            <div class="row">
                                @foreach ($sellers as $seller)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="thumbnail thumbnail-shops">
                                            
                                                <a href="{{ url('/r?url=' . urlencode($seller->url)) }}" class="thumbnail-shops__link"  target="_blank">
                                                    <div class="thumbnail-shops__img-block d-flex justify-content-center align-items-center">
                                                        <img class="thumbnail-shops__img object-fit-contain" src="https://manager.asercargo.az/{{ $seller->img }}" alt="{{ $seller->title }}" style="height: 80px;width: 140px;">
                                                    </div>
                                                </a>
                                        
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                @if ($sellers->hasPages())
                                    <ul class="pagination pagination-data">
                                
                                        @if ($sellers->onFirstPage())
                                            <li class="pagination-data__item">
                                                <a class="pagination-data__link pagination-data__link--disabled">
                                                    <img class="pagination-data__img" src="{{ asset('web/images/content/pagination-left.svg') }}" alt="Previous">
                                                </a>
                                            </li>
                                        @else
                                            <li class="pagination-data__item">
                                                <a href="{{ $sellers->previousPageUrl() }}" class="pagination-data__link">
                                                    <img class="pagination-data__img" src="{{ asset('web/images/content/pagination-left.svg') }}" alt="Previous">
                                                </a>
                                            </li>
                                        @endif

                                        @foreach ($sellers->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="pagination-data__item">
                                                    <span class="pagination-data__link">{{ $element }}</span>
                                                </li>
                                            @endif

                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $sellers->currentPage())
                                                        <li class="pagination-data__item pagination-data__item--active">
                                                            <a href="{{ $url }}" class="pagination-data__link">{{ $page }}</a>
                                                        </li>
                                                    @else
                                                        <li class="pagination-data__item">
                                                            <a href="{{ $url }}" class="pagination-data__link">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($sellers->hasMorePages())
                                            <li class="pagination-data__item">
                                                <a href="{{ $sellers->nextPageUrl() }}" class="pagination-data__link">
                                                    <img class="pagination-data__img" src="{{ asset('web/images/content/pagination-right.svg') }}" alt="Next">
                                                </a>
                                            </li>
                                        @else
                                            <li class="pagination-data__item">
                                                <a class="pagination-data__link pagination-data__link--disabled">
                                                    <img class="pagination-data__img" src="{{ asset('web/images/content/pagination-right.svg') }}" alt="Next">
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="formSearchCategories" method="GET" action="{{ route('sellers_page', ['locale' => App::getLocale()]) }}">
            <input type="hidden" name="location" id="selectedCountry" value="{{ request('location') }}">
        </form>
    </section>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.form-checkbox__input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            document.getElementById('formSearchCategories').submit();
        });
    });
</script>
@endsection

@section('styles')
    <style>
        .form-checkbox__span{
            margin-right: 9px;
        }
    </style>
@endsection