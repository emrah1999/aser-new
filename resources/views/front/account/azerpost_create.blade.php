@extends('front.app')
@section('content')
    <section class="content-page-section">
      

        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part campaign-content-part">
                        @include("front.account.account_left_bar")
                        <div class="page-content-right">

                            <div class="n-order-list">

                                <div class="n-order-top flex space-between">
                                    <h1>{!! __('courier.azerpost_title') !!}</h1>
                                    {{-- <div class="col-md-6 store-selection">
                                        <div class="form-group field-userorder-shop_title required has-error">
                                            <div class="calculate-input-block for-select">
                                                <select id="selectChange"
                                                        class="form-control"
                                                        required>
                                                    <option value="baki">Bakı</option>
                                                    <option value="rayonlar">Regionlar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="n-order-form n-order-form-turkey orange-spinner" id="formDiv">
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
                                    <div  id="baki" class=" show-hide">
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
                                                                                   value=""
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                </div>
{{--                                                                <div class="row">--}}
{{--                                                                    <div class="col-md-8" style="margin-bottom: 1.3rem;">--}}
{{--                                                                        <div class="courier-map-block" id="courier-map" name="delivery"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <input hidden type="text" id="delivery-lat" name="delivery_latitude">--}}
{{--                                                                    <input hidden type="text" id="delivery-long" name="delivery_longitude">--}}
{{--                                                                    <div class="col-md-4"></div>--}}
{{--                                                                </div>--}}
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <label class="control-label"
                                                                                   for="phone">{!! __('courier.phone') !!}</label>
                                                                            <input type="number" id="phone"
                                                                                   class="form-control" name="phone"
                                                                                   placeholder="{!! __('courier.phone') !!}"
                                                                                   value="{{Auth::user()->phone()}}"
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
                                                                                   class="form-control" name="date"
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="padding: 25px 0px;">
                                                                    <div class="col-md-6">
                                                                        <label>{!! __('courier.courier_payment_type_title') !!}</label>
                                                                        <input type="hidden"
                                                                               name="courier_payment_type_id"
                                                                               id="courier_payment_type_id" value="">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <button type="button"
                                                                                    class="courier-pay-buttons"
                                                                                    onclick="choose_courier_payment_type(this, 1, '{{route("courier_get_delivery_payment_types")}}');"
                                                                                    id="courier_pay_button_1">
                                                                                <img src="{{asset("front/image/onlinePay.png")}}"
                                                                                     alt="{!! __('courier.online') !!}">
                                                                                <small>{!! __('courier.online') !!}</small>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="courier-pay-buttons"
                                                                                    onclick="choose_courier_payment_type(this, 2, '{{route("courier_get_delivery_payment_types")}}');"
                                                                                    id="courier_pay_button_2">
                                                                                <img src="{{asset("front/image/cashPay.png")}}"
                                                                                     alt="{!! __('courier.cash') !!}">
                                                                                <small>{!! __('courier.cash') !!}</small>
                                                                            </button>
                                                                            {{-- <button type="button"
                                                                                    class="courier-pay-buttons"
                                                                                    onclick="choose_courier_payment_type(this, 3, '{{route("courier_get_delivery_payment_types")}}');"
                                                                                    id="courier_pay_button_3">
                                                                                <img src="{{asset("uploads/static/pos.svg")}}"
                                                                                     alt="{!! __('courier.pos') !!}">
                                                                                <small>{!! __('courier.pos') !!}</small>
                                                                            </button> --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>{!! __('courier.delivery_payment_type_title') !!}</label>
                                                                        <input type="hidden"
                                                                               name="delivery_payment_type_id"
                                                                               id="delivery_payment_type_id" value="">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <button type="button"
                                                                                    class="delivery-pay-buttons"
                                                                                    onclick="choose_delivery_payment_type(this, 1);"
                                                                                    id="delivery_pay_button_1">
                                                                                <img src="{{asset("front/image/onlinePay.png")}}"
                                                                                     alt="{!! __('courier.online') !!}">
                                                                                <small>{!! __('courier.online') !!}</small>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="delivery-pay-buttons"
                                                                                    onclick="choose_delivery_payment_type(this, 2);"
                                                                                    id="delivery_pay_button_2">
                                                                                <img src="{{asset("front/image/cashPay.png")}}"
                                                                                     alt="{!! __('courier.cash') !!}">
                                                                                <small>{!! __('courier.cash') !!}</small>
                                                                            </button>
                                                                            {{-- <button type="button"
                                                                                    class="delivery-pay-buttons"
                                                                                    onclick="choose_delivery_payment_type(this, 3);"
                                                                                    id="delivery_pay_button_3">
                                                                                <img src="{{asset("uploads/static/pos.svg")}}"
                                                                                     alt="{!! __('courier.pos') !!}">
                                                                                <small>{!! __('courier.pos') !!}</small>
                                                                            </button> --}}
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
                                                                                        <th class="cell100 column1">{!! __('table.external_w_debt') !!}</th>
                                                                                        <th class="cell100 column1">{!! __('table.internal_w_debt') !!}</th>
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

                                    </div>

                                    <div id="rayonlar" class=" show-hide">
                                        <form id="courier_form_region" action="{{route("courier_create_order_region")}}"
                                              method="post">
                                            @csrf
                                            <input type="hidden" required name="packages_list" id="checked_packages_region">
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
                                                                                        class="form-control region_id"
                                                                                        name="region_id"
                                                                                        required>
                                                                                    <option value="">{!! __('courier.region') !!}</option>
                                                                                    @foreach($regions as $area)
                                                                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                                                                        >
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group field-userorder-product_name required">
{{--                                                                            <input type="text" id="address"--}}
{{--                                                                                class="form-control" name="post_zip"--}}
{{--                                                                                placeholder="{!! __('courier.zip') !!}"--}}
{{--                                                                                value=""--}}
{{--                                                                                required>--}}
                                                                            <select id="post_index"
                                                                                    class="form-control"
                                                                                    name="post_zip"
                                                                                    required disabled>
                                                                                <option value="">{!! __('courier.zip') !!}</option>

                                                                            </select>
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
                                                                                   value=""
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
                                                                                   value="{{Auth::user()->phone()}}"
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
                                                                                   class="form-control" name="date"
                                                                                   required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                    
                                                                <div class="row" style="margin-top: 15px;">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group field-userorder-product_name required">
                                                                            <button type="button"
                                                                                    class="packages_button"
                                                                                    onclick="courier_choose_packages_modal_region()">{!! __('courier.choose_packages_button') !!}</button>
                                                                        </div>
                                                                    </div>
                                                                   
                                                                </div>
                                                                <div class="row" style="margin-top: 15px;">
                                                                    <div class="col-12" id="packages_list_table_region"
                                                                         style="display: none;">
                                                                        <div class="table100 ver1 m-b-110">
                                                                            <div class="table100-head">
                                                                                <table>
                                                                                    <thead>
                                                                                    <tr class="row100 head">
                                                                                        <th class="cell100 column1">{!! __('courier.track') !!}</th>
                                                                                        <th class="cell100 column1">{!! __('table.amount') !!}</th>
                                                                                        <th class="cell100 column1">{!! __('table.external_w_debt') !!}</th>
                                                                                        <th class="cell100 column1">{!! __('table.internal_w_debt') !!}</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                </table>
                                                                            </div>
                                                                            <div class="table100-body js-pscroll">
                                                                                <table>
                                                                                    <tbody id="packages_list_body_region">
    
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
                                                                                                    id="delivery_price_region"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="row100 body">
                                                                                        <td class="cell100">
                                                                                            <strong>{!! __('courier.courier_amount') !!}</strong>
                                                                                        </td>
                                                                                        <td class="cell100"><span
                                                                                                    id="courier_price_region"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="row100 body">
                                                                                        <td class="cell100">
                                                                                            <strong>{!! __('courier.summary_amount') !!}</strong>
                                                                                        </td>
                                                                                        <td class="cell100"><span
                                                                                                    id="summary_price_region"></span>
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
                                        
                                    </div>

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
                                <th>{!! __('courier.external_warehouse_debt') !!}</th>
                                <th>{!! __('courier.internal_warehouse_debt') !!}</th>
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
                                                       external_w_debt="{{$package->external_w_debt}}"
                                                       internal_w_debt="{{$package->internal_w_debt}}"
                                                       track="{{$package->track}}" value="{{$package->id}}"
                                                       id="package_{{$package->id}}"><label
                                                    for="package_{{$package->id}}"></label></center>
                                    </td>
                                    <td>{{$package->track}}</td>
                                    <td>{{$package->gross_weight}} kg</td>
                                    <td>{{$package->amount}} AZN</td>
                                    <td>{{$package->external_w_debt}} AZN</td>
                                    <td>{{$package->internal_w_debt}} AZN</td>
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

    <!-- regions start -->

    <div class="modal fade" id="packages-modal_region" tabindex="-1" role="dialog"
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
                                    <center><input type="checkbox" id="checkAllRegion" class="courier-check-box" checked>
                                    </center>
                                </th>
                                <th>{!! __('courier.track') !!}</th>
                                <th>{!! __('courier.gross_weight') !!}</th>
                                <th>{!! __('courier.amount') !!}</th>
                                <th>{!! __('courier.external_warehouse_debt') !!}</th>
                                <th>{!! __('courier.internal_warehouse_debt') !!}</th>
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
                                        <center><input type="checkbox" class="checks_region courier-check-box" checked
                                                       name="packages" amount="{{$package->amount}}" weight="{{$package->gross_weight}}"
                                                       external_w_debt="{{$package->external_w_debt}}"
                                                       internal_w_debt="{{$package->internal_w_debt}}"
                                                       track="{{$package->track}}" value="{{$package->id}}"
                                                       id="package_{{$package->id}}"><label
                                                    for="package_{{$package->id}}"></label></center>
                                    </td>
                                    <td>{{$package->track}}</td>
                                    <td>{{$package->gross_weight}} kg</td>
                                    <td>{{$package->amount}} AZN</td>
                                    <td>{{$package->external_w_debt}} AZN</td>
                                    <td>{{$package->internal_w_debt}} AZN</td>
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
                            onclick="check_packages_region();">{!! __('courier.choose_button') !!}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('packages-modal_region')"></div>
    </div>


    <!-- regions end -->

    <!-- Modal -->
    <div class="modal fade" style="opacity: 1!important; background: #00000080; transition: width 2s;" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('courier_update_packages')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group field-userorder-product_name required">
                            <label class="control-label"
                                    for="updated_date">{!! __('courier.date') !!}</label>
                            <input type="date" id="updated_date"
                                    min="{{ $min_date }}"
                                    max="{{ $max_date }}"
                                    class="form-control" name="date"
                                    required>
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="update_button" type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
            border: 2px solid rgba(16, 69, 140, 1);
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

        #baki{
            display: none;
        }
        #rayonlar{
            display: block;
        }

    </style>
@endsection

@section('js')
    <script src="{{asset("frontend/js/courier.js?ver=0.1.8")}}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        default_urgent_amount = '{{$amount_for_urgent}}';
    </script>

{{--    <script>--}}
{{--        function initMap () {--}}
{{--            var geocoder = new google.maps.Geocoder();--}}
{{--                    var infowindow = new google.maps.InfoWindow();--}}

{{--                    // if(data.latitude & data.longitude){--}}
{{--                    //     var map = new google.maps.Map(document.getElementById('courier-map'), {--}}
{{--                    //         zoom: 10,--}}
{{--                    //         center: {lat:Number(data.latitude), lng:Number(data.longitude)},--}}
{{--                    //         mapTypeId: 'terrain',--}}
{{--                    //         gestureHandling: 'greedy'--}}
{{--                    //     });--}}
{{--                    //     var marker1 = new google.maps.Marker({--}}
{{--                    //         position: {lat:Number(data.latitude), lng:Number(data.longitude)},--}}
{{--                    //         map: map,--}}
{{--                    //         draggable: true,--}}
{{--                    //         anchorPoint: new google.maps.Point(0, -29)--}}
{{--                    //     });--}}
{{--                    // }--}}
{{--                        var map = new google.maps.Map(document.getElementById('courier-map'), {--}}
{{--                            zoom: 9,--}}
{{--                            center: {lat:40.5572989 , lng: 49.7188462},--}}
{{--                            mapTypeId: 'terrain',--}}
{{--                            gestureHandling: 'greedy'--}}
{{--                        });--}}
{{--                        var marker1 = new google.maps.Marker({--}}
{{--                            map: map,--}}
{{--                            draggable: true,--}}
{{--                            anchorPoint: new google.maps.Point(0, -29)--}}
{{--                        });--}}
{{--                    --}}
{{--                    var input1 = document.getElementById('address');--}}
{{--                    var options = {--}}
{{--                        componentRestrictions: {country: "az"}--}}
{{--                    };--}}
{{--                    google.maps.event.addDomListener(input1, 'keydown', function(event) {--}}
{{--                        if (event.keyCode === 13) {--}}
{{--                            event.preventDefault();--}}
{{--                        }--}}
{{--                    });--}}

{{--                    var autocomplete1 = new google.maps.places.Autocomplete(input1, options);--}}
{{--                    var pacContainerInitialized = false;--}}
{{--                    $('#address').keypress(function() {--}}
{{--                        if (!pacContainerInitialized) {--}}
{{--                            $('.pac-container').css('z-index', '9999');--}}
{{--                            pacContainerInitialized = true;--}}
{{--                        }--}}
{{--                    });--}}

{{--                    autocomplete1.addListener('place_changed', function () {--}}
{{--                        var place = autocomplete1.getPlace();--}}
{{--                        var location = place.geometry.location;--}}
{{--                        $('#delivery-long').val(location.lng());--}}
{{--                        $('#delivery-lat').val(location.lat());--}}
{{--                        // coord.LatLng = location;--}}
{{--                        if (place.geometry.viewport) {--}}
{{--                            map.fitBounds(place.geometry.viewport);--}}
{{--                        } else {--}}
{{--                            map.setCenter(location);--}}
{{--                            map.setZoom(17);--}}
{{--                        }--}}
{{--                        marker1.setPosition(location);--}}
{{--                        marker1.setVisible(true);--}}
{{--                    });--}}
{{--                    google.maps.event.addListener(marker1, 'dragend', function () {--}}
{{--                        geocoder.geocode({'latLng': marker1.getPosition()}, function (results, status) {--}}
{{--                            if (status == google.maps.GeocoderStatus.OK) {--}}
{{--                                if (results[0]) {--}}
{{--                                    // coord.LatLng = results[0].geometry.location;--}}
{{--                                    jQuery('#address').val(results[0].formatted_address);--}}
{{--                                    $('#delivery-long').val(results[0].geometry.location.lng());--}}
{{--                                    $('#delivery-lat').val(results[0].geometry.location.lat());--}}
{{--                                    infowindow.setContent(results[0].formatted_address);--}}
{{--                                    infowindow.open(map, marker1);--}}
{{--                                }--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}

{{--                        google.maps.event.addListener(map, "idle", function(){--}}
{{--                            google.maps.event.trigger(map, 'resize');--}}
{{--                        });--}}
{{--                    map.setZoom( map.getZoom() - 1 );--}}
{{--                    map.setZoom( map.getZoom() + 1 );--}}
{{--        }--}}
{{--    </script>--}}

    <script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false&amp;libraries=places,geometry&key=AIzaSyAfz-DTeJFbN0ZUnDLrpxZLb3nlDvA0uO8&callback=initMap" type="text/javascript"></script>

    <script>
        // update ajax start
        $('#update_button').click(function(e){

            id = $("#id").val();
            let date =$('#updated_date').val();
            
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
                console.log(date);
                e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '{{route('courier_update_packages')}}',
                        data: {
                            'id': id,
                            date,
                            '_token': CSRF_TOKEN,
                        },
                        success: function (response) {
                        
                            swal.close();
                            if (response.case === 'success') {
                                $('.order_' + response.id).remove();
                                swal({
                                    position: 'top-end',
                                    type: response.case,
                                    title: response.title,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else {
                                swal(
                                    response.title,
                                    response.content,
                                    response.case
                                );
                            }
                            $('#updateModal').modal();
                        }
                });
        })
        
        $('#dataTable').on("click", ".edit-click", function(){
            addEventListenerToModal();
            id = $(this)[0].getAttribute('order-id');
            let date =$('#updated_date').val();
            
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
                console.log(date);

            $.ajax({
                    type: "GET",
                    url: '{{route('getdata')}}',
                    data: {
                        'id': id,
                        '_token': CSRF_TOKEN,
                    },
                    success: function (response) {
                        $('#updated_date').val("qweqw");
                        document.getElementById("updated_date").value = response.date;
                        let b= $('#id').val(response.id);
                        swal.close();
                        if (response.case === 'success') {
                            $('.order_' + response.id).remove();
                            swal({
                                position: 'top-end',
                                type: response.case,
                                title: response.title,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            swal(
                                response.title,
                                response.content,
                                response.case
                            );
                        }
                        $('#updateModal').modal();
                    }
            });

        });

        // update ajax end

        function addEventListenerToModal() {
            var today = new Date();
            var dateInput = document.getElementById("updated_date");

            dateInput.addEventListener("input", function() {
                var selectedDate = new Date(dateInput.value);
                var year = selectedDate.getFullYear();
                var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                var day = selectedDate.getDate().toString().padStart(2, '0');

                var formattedDate = year + '-' + month + '-' + day;
                if (formattedDate < '{{$min_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                } else if (formattedDate > '{{$max_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                }
            });
        }
    
    </script>

    <script>

        $(function() {
            $('#selectChange').change(function(){
                $('.show-hide').hide();
                $('#' + $(this).val()).show();
            });
        });


    </script>

    <script>
        $(".region_id").on("change", function () {
            var regionId = $(this).val();
            //console.log(regionId);

            $("#post_index").prop("disabled", false);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

            $.ajax({
                type: "GET",

                url: '{{route('azerpost_index_by_region')}}',
                data: { region_id: regionId, '_token': CSRF_TOKEN },
                dataType: "json",
                success: function (response) {

                    $("#post_index").empty().append('<option value="">' + "{!! __('courier.zip') !!}" + '</option>');
                    $.each(response.data, function (index, item) {
                        $("#post_index").append('<option value="' + item.id + '">' + item.index_code + ' - ' + item.address + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>

    <script>

        window.onload = function() {
            var today = new Date();
            var dateInput = document.getElementById("date");



            dateInput.addEventListener("input", function() {
                var selectedDate = new Date(dateInput.value);
                var year = selectedDate.getFullYear();
                var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                var day = selectedDate.getDate().toString().padStart(2, '0');

                var formattedDate = year + '-' + month + '-' + day;
                if (formattedDate < '{{$min_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                } else if (formattedDate > '{{$max_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                }
            });
        };
        if (window.innerWidth >= 768) {
            window.onload = function() {
                var today = new Date();
                var dateInput = document.getElementById("date");



                dateInput.addEventListener("input", function() {
                    var selectedDate = new Date(dateInput.value);
                    var year = selectedDate.getFullYear();
                    var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                    var day = selectedDate.getDate().toString().padStart(2, '0');

                    var formattedDate = year + '-' + month + '-' + day;
                    if (formattedDate < '{{$min_date}}') {
                        dateInput.value = '';
                        alert("Əllə seçim edə bilməzsiniz!");
                    } else if (formattedDate > '{{$max_date}}') {
                        dateInput.value = '';
                        alert("Əllə seçim edə bilməzsiniz!");
                    }
                });
            };
        }
        else{
            window.onload = function() {

                var dateInput = document.getElementById("date");
                dateInput.addEventListener("click", function() {
                   // console.log(this.type);
                    this.type = "date";
                });
                    //console.log(this.value);
                dateInput.addEventListener("input", function() {

                    var minDate = '{{$min_date}}';
                    var maxDate = '{{$max_date}}';
                    var selectedDate = new Date(dateInput.value);



                    var year = selectedDate.getFullYear();
                    var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                    var day = selectedDate.getDate().toString().padStart(2, '0');

                    var formattedDate = year + '-' + month + '-' + day;

                   /* if (formattedDate < '{{$min_date}}') {
                        console.log(formattedDate < '{{$min_date}}');
                        this.value = minDate.toISOString().slice(0, 10);
                    } else if (formattedDate > '{{$max_date}}') {
                        console.log(formattedDate > '{{$max_date}}');
                        this.value = maxDate.toISOString().slice(0, 10);
                    }*/

                    //console.log(formattedDate);

                    if (formattedDate < '{{$min_date}}') {
                       // console.log(formattedDate < '{{$min_date}}');
                        dateInput.value = '';
                    } else if (formattedDate > '{{$max_date}}') {
                        //console.log(formattedDate > '{{$max_date}}');
                        dateInput.value = '';
                    }
                });
            };
        }

    </script>



@endsection
