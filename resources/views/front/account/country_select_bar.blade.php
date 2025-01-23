<div class="tariff-select special-order-country">
    <label>{!! __('labels.select_country_for_make_order') !!}</label>
    <div class="country-select">
        <div class="country-active flex align-items-center">
            <span class="country-flag">
                <img src="{{$countr[0]->flag}}" alt="{{$countr[0]->name}}">
            </span>
            {{$countr[0]->name}}
{{--            ÖLKƏ SEÇİN--}}
        </div>

        <div class="country-list list-tab no-reload">
            <ul>
                @foreach($countr as $country)
                    <li>
                        <a href="{{route("special_order", $country->id)}}" class="flex align-items-center" onclick="country_select_for_special_order(this);">
                                                    <span class="country-flag">
                                                        <img alt="{{$country->name}}" src="{{$country->flag}}">
                                                    </span>
                            {{$country->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="order-btn">
        @if(isset($country_id))
            @php($selected_country_id = $country_id)
        @else
            @php($selected_country_id = $countr[0]->id)
        @endif
        <a href="{{route("special_order", $selected_country_id)}}" class="btn btn-orange special-order-btn" id="special_order_button"> + {!! __('buttons.order') !!}</a>
        <a href="{{route("special_order", $selected_country_id) . "?paid=no"}}" class="btn btn-orange" id="basket_special_order_button">
            <i class="fa" style="font-size:24px">&#xf07a;</i>
            @if($not_paid_orders_count > 0)
                <span class='badge badge-warning' id='lblCartCount'> {{$not_paid_orders_count}} </span>
            @endif
        </a>
    </div>
</div>
