<div class="container-fluid page_containers">
    <div class="row">
        <div class="col-md-9 order-side-bar">
            <div class="tariff-select special-order-country">
                <label>{!! __('labels.select_country_for_make_order') !!}</label>
                <div class="country-select">
                    <div class="country-active flex align-items-center">
                        @foreach($countr as $key => $country)
                            @if($country->id == $country_id)
                                <span class="country-flag">
                        <img src="{{$countr[$key]->flag}}" alt="{{$countr[$key]->name}}">
                    </span>
                                <span class="country-name">{{$countr[$key]->name }}</span>
                            <div class="check-icon">
                                <svg   xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="country-list list-tab no-reload" style="display: none;">
                        <ul>
                            @foreach($countr as $country)
                                <li>
                                    <a href="{{route('special_order', ['locale' => App::getLocale(), $country->id])}}"
                                       class="flex align-items-center">
                            <span class="country-flag">
                                <img alt="{{$country->name}}" src="{{$country->flag}}" height="19px" width="19px">
                            </span>
                                        {{$country->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="order-btn-group">
                    @if(isset($country_id))
                        @php($selected_country_id = $country_id)
                    @else
                        @php($selected_country_id = $countr[0]->id)
                    @endif
                    <a href="{{ route('special_order', ['locale' => App::getLocale(), 'country_id' => $selected_country_id]) . '?paid=no' }}"
                       class="btn btn-orange" id="basket_special_order_button">
                        <i class="fa" style="font-size:24px">&#xf07a;</i>
                        @if($not_paid_orders_count > 0)
                            <span class='badge badge-warning' id='lblCartCount'> {{$not_paid_orders_count}} </span>
                        @endif
                    </a>
                </div>
            </div>


        </div>
    </div>
</div>


@section('styles1')
    <style>
        .country-active {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .check-icon {
            margin-left: auto;
            color: black;
        }

        .check-icon {
            color: black;
            font-weight: bold;
            margin-left: 10px;
        }

        .country-active{
            margin-left: 140px;
            width: 220px;
        }

        .order-side-bar{
            margin: 20px 300px 1px 315px;
            width: 1000px;
        }
        .tarif_tab_links li.active a {
            border-radius: 5px;
            background-color: #ffce00 !important;
            color: #fff !important;
        }

        .page-containers {
            display: flex;
            flex-wrap: nowrap;
        }

        .page-containers .col-md-9 {
            flex: 1;
        }

        .tariff-select {
            background-color: #fff7e6;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-left: auto;
            margin-right: 0;
            position: absolute;
            width: 63%;
            margin-top: 20px;
        }

        .tariff-select label {
            display: block;
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
            margin-right: 20px;
        }

        .country-select {
            position: relative;
            flex-grow: 1;
            max-width: 300px;
            display: flex;
            justify-content: flex-start;
            margin-left: auto; 
            margin-right: 0;
        }

        .country-active {
            background-color: #fff;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .country-active:hover {
            background-color: #f0f0f0;
        }

        .country-flag img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .country-list {
            display: none;
            position: absolute;
            top: 100%;

            width: 100%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 10px;
            margin-left: 140px;

        }

        .country-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .country-list li {
            border-bottom: 1px solid #ddd;
        }

        .country-list li:last-child {
            border-bottom: none;
        }

        .country-list a {
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .country-list a:hover {
            background-color: #f0f0f0;
        }

        .country-list .country-flag img {
            width: 19px;
            height: 19px;
            margin-right: 10px;
        }

        .order-btn-group {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-end;
            margin-left: auto;
            margin-right: 0;
        }

        .btn-orange {
            background-color: #ffa500;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-orange:hover {
            background-color: #e59400;
        }

        .badge-warning {
            background-color: #ffce00;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            position: absolute;
            top: -10px;
            right: -10px;
        }


        @media (max-width: 768px) {
            .tariff-select {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px;
                margin-left: auto;
                margin-right: 0;
                position: absolute;
                width: 63%;
            }

            .order-btn-group {
                flex-direction: column;
                margin-top: 10px;
                justify-content: center;
                margin-left: auto;
                margin-right: 0;
            }

            .btn-orange {
                width: 100%;
                text-align: center;
            }

            .country-active {
                width: 100%;
            }
        }

    </style>
@endsection



