@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->
        <!-- page content header -->
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text account-index-top">
                        <h3> {!! __('account_menu.courier') !!} </h3>

                        <div class="campaign hidden"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part campaign-content-part">
                        @include("front.account.account_left_bar")
                        <div class="page-content-right">

                            <div class="n-order-list">

                                <div class="n-order-top flex space-between">
                                    <h1>{!! __('courier.title') !!}</h1>
                                </div>

                                <div class="n-order-form n-order-form-turkey orange-spinner">
                                    @if(session('display') == 'block')
                                        <div class="{{session('class')}}">
                                            <h3>{{session('description')}}</h3>
                                            <p>{{session('message')}}</p>
                                        </div>
                                    @endif

                                    @if(count($packages) == 0)
                                        <div class="alert alert-warning" role="alert">
                                            {!! __('courier.no_packages_in_baku') !!}
                                        </div>
                                    @else
                                        <form id="courier_form" action="{{route("courier_create_order")}}"
                                              method="post">
                                            @csrf
                                            <input type="hidden" required name="packages_list" id="checked_packages">
                                            <div class="order-form">
                                                <div class="store-inputs">
                                                    <div class="order-product-list">
                                                        <div class="list-item">
                                                            <div class="form-element ">
                                                                <div class="row">
                                                                    <div class="col-md-6 store-selection">
                                                                        <div class="form-group field-userorder-shop_title required has-error">
                                                                            <div class="calculate-input-block for-select">
                                                                                <select id="area_id"
                                                                                        class="form-control"
                                                                                        name="area_id"
                                                                                        oninput="courier_change_area(this, '{{route("courier_get_courier_payment_types")}}');"
                                                                                        required>
                                                                                    <option value="">{!! __('courier.area') !!}</option>
                                                                                    @foreach($areas as $area)
                                                                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                                                                        >
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 store-selection">
                                                                        <div class="form-group field-userorder-shop_title required has-error">
                                                                            <div class="calculate-input-block for-select">
                                                                                <select id="metro_station_id"
                                                                                        class="form-control"
                                                                                        name="metro_station_id">
                                                                                    <option value="">{!! __('courier.metro_station') !!}</option>
                                                                                    <option value="">---</option>
                                                                                    @foreach($metro_stations as $metro_station)
                                                                                        <option value="{{$metro_station->id}}">{{$metro_station->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <label class="control-label"
                                                                                   for="address">{!! __('courier.address') !!}</label>
                                                                            <input type="text" id="address"
                                                                                   class="form-control" name="address"
                                                                                   placeholder="{!! __('courier.address') !!}"
                                                                                   value="{{$order->address}}"
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <label class="control-label"
                                                                                   for="phone">{!! __('courier.phone') !!}</label>
                                                                            <input type="number" id="phone"
                                                                                   class="form-control" name="phone"
                                                                                   placeholder="{!! __('courier.phone') !!}"
                                                                                   value="{{$order->phone}}"
                                                                                   maxlength="30" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <label class="control-label"
                                                                                   for="date">{!! __('courier.date') !!}</label>
                                                                            <input type="date" id="date"
                                                                                   min="{{ $min_date }}"
                                                                                   max="{{ $max_date }}"
                                                                                   class="form-control" name="date" value="{{$order->date}}"
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>{!! __('courier.courier_payment_type_title') !!}</label>
                                                                        <input type="hidden"
                                                                               name="courier_payment_type_id"
                                                                               id="courier_payment_type_id" value="{{$order->courier_payment_type_id}}">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <button type="button"
                                                                                    class="courier-pay-buttons"
                                                                                    onclick="choose_courier_payment_type(this, 1, '{{route("courier_get_delivery_payment_types")}}');"
                                                                                    id="courier_pay_button_1">
                                                                                <img src="{{asset("uploads/static/online.jpg")}}"
                                                                                     alt="{!! __('courier.online') !!}">
                                                                                <small>{!! __('courier.online') !!}</small>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="courier-pay-buttons"
                                                                                    onclick="choose_courier_payment_type(this, 2, '{{route("courier_get_delivery_payment_types")}}');"
                                                                                    id="courier_pay_button_2">
                                                                                <img src="{{asset("uploads/static/cash.png")}}"
                                                                                     alt="{!! __('courier.cash') !!}">
                                                                                <small>{!! __('courier.cash') !!}</small>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="courier-pay-buttons"
                                                                                    onclick="choose_courier_payment_type(this, 3, '{{route("courier_get_delivery_payment_types")}}');"
                                                                                    id="courier_pay_button_3">
                                                                                <img src="{{asset("uploads/static/pos.svg")}}"
                                                                                     alt="{!! __('courier.pos') !!}">
                                                                                <small>{!! __('courier.pos') !!}</small>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>{!! __('courier.delivery_payment_type_title') !!}</label>
                                                                        <input type="hidden"
                                                                               name="delivery_payment_type_id"
                                                                               id="delivery_payment_type_id" value="{{$order->courier_payment_type_id}}">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <button type="button"
                                                                                    class="delivery-pay-buttons"
                                                                                    onclick="choose_delivery_payment_type(this, 1);"
                                                                                    id="delivery_pay_button_1">
                                                                                <img src="{{asset("uploads/static/online.jpg")}}"
                                                                                     alt="{!! __('courier.online') !!}">
                                                                                <small>{!! __('courier.online') !!}</small>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="delivery-pay-buttons"
                                                                                    onclick="choose_delivery_payment_type(this, 2);"
                                                                                    id="delivery_pay_button_2">
                                                                                <img src="{{asset("uploads/static/cash.png")}}"
                                                                                     alt="{!! __('courier.cash') !!}">
                                                                                <small>{!! __('courier.cash') !!}</small>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="delivery-pay-buttons"
                                                                                    onclick="choose_delivery_payment_type(this, 3);"
                                                                                    id="delivery_pay_button_3">
                                                                                <img src="{{asset("uploads/static/pos.svg")}}"
                                                                                     alt="{!! __('courier.pos') !!}">
                                                                                <small>{!! __('courier.pos') !!}</small>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="margin-top: 15px;">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <button type="button"
                                                                                    class="packages_button"
                                                                                    onclick="courier_choose_packages_modal();">{!! __('courier.choose_packages_button') !!}</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" id="urgent_order_input"
                                                                               name="urgent_order" required value="0">
                                                                        <span><input type="checkbox" id="quick-checkbox"
                                                                                     onclick="set_urgent_order(this, {{$amount_for_urgent}});">
                                                                        <label for="quick-checkbox"
                                                                               class="def-checkbox">
                                                                            <span data-tooltip="{!! __('courier.urgent_order_text') !!}"
                                                                                  data-tooltip-position="bottom">{!! __('courier.urgent_order_button') !!} <strong>?</strong></span>
                                                                        </label>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="margin-top: 15px;">
                                                                    <div class="col-12" id="packages_list_table"
                                                                         style="display: none;">
                                                                        <div class="table100 ver1 m-b-110">
                                                                            <div class="table100-head">
                                                                                <table>
                                                                                    <thead>
                                                                                    <tr class="row100 head">
                                                                                        <th class="cell100 column1">{!! __('courier.track') !!}</th>
                                                                                        <th class="cell100 column1">{!! __('table.amount') !!}</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                </table>
                                                                            </div>
                                                                            <div class="table100-body js-pscroll">
                                                                                <table>
                                                                                    <tbody id="packages_list_body">

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12" style="margin-top: 15px;">
                                                                        <div class="table100 ver1 m-b-110"
                                                                             style="padding-top: 0 !important;">
                                                                            <div class="table100-body js-pscroll">
                                                                                <table>
                                                                                    <tbody>
                                                                                    <tr class="row100 body">
                                                                                        <td class="cell100">
                                                                                            <strong>{!! __('courier.delivery_amount') !!}</strong>
                                                                                        </td>
                                                                                        <td class="cell100"><span
                                                                                                    id="delivery_price"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="row100 body">
                                                                                        <td class="cell100">
                                                                                            <strong>{!! __('courier.courier_amount') !!}</strong>
                                                                                        </td>
                                                                                        <td class="cell100"><span
                                                                                                    id="courier_price"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="row100 body">
                                                                                        <td class="cell100">
                                                                                            <strong>{!! __('courier.summary_amount') !!}</strong>
                                                                                        </td>
                                                                                        <td class="cell100"><span
                                                                                                    id="summary_price"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="order-button">
                                                    <button type="submit"
                                                            class="orange-button">{!! __('courier.save_button') !!}</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




 
    <div class="modal fade" id="packages-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    <center><input type="checkbox" id="checkAll" class="courier-check-box" checked>
                                    </center>
                                </th>
                                <th>{!! __('courier.track') !!}</th>
                                <th>{!! __('courier.gross_weight') !!}</th>
                                <th>{!! __('courier.amount') !!}</th>
                                <th>{!! __('courier.payment_type') !!}</th>
                                <th>{!! __('courier.client') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($referrals_packages_count = 0)
                            @foreach($packages as $package)
                                @if($package->client_id == Auth::id())
                                    @php($referrals_packages_class = '')
                                @else
                                    @php($referrals_packages_count++)
                                    @php($referrals_packages_class = 'class="referrals_packages_class"')
                                @endif
                                <tr {!! $referrals_packages_class !!}>
                                    <td>
                                        <center><input type="checkbox" class="checks courier-check-box" checked
                                                       name="packages" amount="{{$package->amount}}"
                                                       track="{{$package->track}}" value="{{$package->id}}"
                                                       id="package_{{$package->id}}"><label
                                                    for="package_{{$package->id}}"></label></center>
                                    </td>
                                    <td>{{$package->track}}</td>
                                    <td>{{$package->gross_weight}} kg</td>
                                    <td>{{$package->amount}} AZN</td>
                                    <td>{{$package->payment_type}}</td>
                                    <td>{{$package->client_name}} {{$package->client_surname}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="order-button" id="show_referral_packages_button">
                        <button type="button" class="orange-button"
                                data-message-referrals="{!! __('courier.no_referrals') !!}"
                                data-message-packages="{!! __('courier.no_referral_packages') !!}"
                                onclick="show_referral_packages(this, {{$referrals_packages_count}}, '{{$has_sub_accounts}}');">{!! __('courier.show_referral_packages_button') !!}</button>
                    </div>
                    <div class="order-button">
                        <button type="button" class="orange-button"
                            onclick="check_packages();">{!! __('courier.choose_button') !!}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('packages-modal')"></div>
    </div>

    <div class="modal fade" id="show-packages-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! __('courier.track') !!}</th>
                                <th>{!! __('courier.gross_weight') !!}</th>
                                <th>{!! __('courier.amount') !!}</th>
                                <th>{!! __('courier.payment_type') !!}</th>
                                <th>{!! __('courier.client') !!}</th>
                                <th>{!! __('courier.status') !!}</th>
                            </tr>
                            </thead>
                            <tbody id="show_packages_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('show-packages-modal')"></div>
    </div>

    <div class="modal fade" id="show-statuses-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! __('courier.status') !!}</th>
                                <th>{!! __('courier.date') !!}</th>
                            </tr>
                            </thead>
                            <tbody id="show_statuses_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('show-statuses-modal')"></div>
    </div>
@endsection

@section('css')
  
    <style>
        .packages_button {
            height: 40px;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 19px;
            cursor: pointer;
            background-color: white;
            color: #919191;
            border: 2px solid greenyellow;
        }

        .courier-pay-buttons, .delivery-pay-buttons {
            outline: none;
            margin: 0;
            border: none;
            cursor: not-allowed;
            width: 30%;
            /*background-color: darkgrey;*/
            opacity: 0.3;
        }

        .courier-pay-buttons > img, .delivery-pay-buttons > img {
            width: 30%;
            margin-top: 5px;
        }

        .courier-pay-buttons > small, .delivery-pay-buttons > small {
            display: block;
            margin: 5px 0;
        }

        .referrals_packages_class {
            display: none;
        }

        #courier-map {
            height: 340px;
        }

    </style>
@endsection

@section('js')
    <script src="{{asset("frontend/js/courier.js?ver=0.1.8")}}"></script>
    <script>
        default_urgent_amount = '{{$amount_for_urgent}}';
    </script>


@endsection