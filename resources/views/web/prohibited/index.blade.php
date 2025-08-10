@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-restrictions-products">
            <div class="container-lg">
                <div class="nav nav-tab-categories">
                    @foreach($countries as $index => $country)
                        <a href="#country-{{ $country->id }}" class="nav-tab-categories__link nav-tab-categories__link--{{ $index === 0 ? 'active' : '' }} {{ $index === 0 ? 'active' : '' }} flex-fill d-flex justify-content-center align-items-center" data-bs-toggle="tab" role="tab" aria-controls="country-{{ $country->id }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            <img class="nav-tab-categories__link-img" src="{{ $country->flag }}" alt="{{ $country->name }}" style=" margin: 6px 8px; top:0">
                            <span class="nav-tab-categories__link-title d-none d-sm-block">{{ $country->name }}</span>
                        </a>
                    @endforeach
                </div>
                <div class="tab-content tab-content-categories">
                    @foreach($countries as $index => $country)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="country-{{ $country->id }}" role="tabpanel">
                            <h1 class="section-title text-center font-n-b">{!! __('menu.prohibited_products') !!}</h1>
                            <ul class="nav nav-restrictions-products">
                                @foreach($items->where('country_id', $country->id) as $key => $item)
                                    @foreach(preg_split('/<\/?p>/', $item->item) as $paragraph)
                                        @if(trim($paragraph))
                                            <li class="nav-restrictions-products__item">{{ html_entity_decode(strip_tags($paragraph)) }}</li>
                                        @endif
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

@endsection
