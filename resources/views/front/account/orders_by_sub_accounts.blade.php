@extends('front.app')
@section('content')
    <section class="content-page-section">
        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')


                        <div class="page-content-right">
                            <div class="sub-account-tab referal-sm-main clearfix">
                                <ul>
                                    <li><a href="{{route("get_sub_accounts")}}">&nbsp;{!! __('buttons.referrals_list') !!}</a></li>
                                    <li class="active"><a href="{{route("get_orders_by_sub_accounts")}}">{!! __('buttons.orders_by_referrals') !!}</a></li>
                                </ul>
                                <div class="referal-input">
                                    <label>{!! __('static.my_referral_link') !!}: (<a target="_blank" href="{{route("faq_page")}}">{!! __('static.read_more') !!}</a>):</label>
                                    <input type="text" copy-text="{!! __('static.link_copied') !!}" class="form-control" readonly="" value="{{route("register")}}?parent={{Auth::user()->suite()}}" name="">
                                </div>
                            </div>

                            <div class="n-order-list custom_orders_desktop desktop-show">
                                <div class="n-order-top flex space-between order-top-block">
                                    {{-- <div class="country-select n-order-country-select">
                                        <div class="country-active flex align-items-center">
                                            <!-- <span class="country-flag tr"></span> -->
                                            {!! __('static.orders_by_countries') !!}
                                        </div>
                                        <div class="country-list">
                                            <ul>
                                                @foreach($countries as $country)
                                                    <li>
                                                        <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $country->id . '&status=' . $search['status']}}"
                                                           class="flex align-items-center">
                                                            <span class="country-flag">
                                                                <img alt="{{$country->name}}" src="{{$country->flag}}">
                                                            </span>
                                                            {{$country->name}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div> --}}

                                </div>
                                <div class="n-order-bottom">
                                    <div class="n-order-bottom-pad status_bar">
{{--                                        <div class="n-table-color">--}}
{{--                                            <ul>--}}
{{--                                                <li class="paid-li">Ödənilib</li>--}}
{{--                                                <li class="not-paid-li">Ödənilməyib</li>--}}
{{--                                                <li class="fill-declaration-li">Bəyannaməni doldurun</li>--}}
{{--                                                <li class="incorrect-invoice-li">İnvoice düzgün deyil</li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}

                                        <div class="n-order-status">
                                            <ul class="flex space-between">
{{--                                                <li>--}}
{{--                                                    <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=1'}}"--}}
{{--                                                       id="status_1">--}}
{{--                                                        {!! __('static.declared_status') !!} <span>{{$counts['not_declared']}}</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=2'}}"--}}
{{--                                                       id="status_2">--}}
{{--                                                        Səhv invoys <span>{{$counts['incorrect_invoice']}}</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=3'}}"
                                                       id="status_3">
                                                        {!! __('static.in_warehouse_status') !!}<span>{{$counts['is_warehouse']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=4'}}"
                                                       id="status_4">
                                                        {!! __('static.sent_status') !!} <span>{{$counts['sent']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=5'}}"
                                                       id="status_5">
                                                        {!! __('static.in_baku_status') !!} <span>{{$counts['in_office']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=6'}}"
                                                       id="status_6">
                                                        {!! __('static.archive_status') !!} <span>{{$counts['delivered']}}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                    @if(count($packages) > 0)
                                        <div class="n-order-table">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th class="text-upper">{!! __('table.customer') !!}</th>
                                                    <th class="text-upper">{!! __('table.flight') !!}</th>
                                                    <th class="text-upper">{!! __('table.tracking') !!}</th>
                                                    <th>{!! __('table.weight') !!}</th>
                                                    <th>{!! __('table.delivery_amount') !!}</th>
                                                    <th>{!! __('table.status') !!}</th>
                                                    @if($general_settings->referral_secret == 1)
                                                        <th>{!! __('table.pay') !!}</th>
                                                    @endif
                                                    <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($packages as $package)
                                                    @if($package->chargeable_weight == 1)
                                                        @php($package_weight = $package->gross_weight)
                                                    @else
                                                        @php($package_weight = $package->volume_weight)
                                                    @endif
                                                    <tr class="order_package_{{$package->id}}">
                                                        <td>
                                                            <p class="strong-p">AS{{$package->suite}}</p>
                                                            <p>{{$package->client_name}} {{$package->client_surname}}</p>
                                                        </td>
                                                        <td class="strong-p">
                                                            @if(isset($package->flight))
                                                                @if(strlen($package->flight) > 11)
                                                                    {{substr($package->flight, 0, 11)}}
                                                                @else
                                                                    {{$package->flight}}
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <p class="strong-p">{{$package->track}}</p>
                                                            <p>
                                                                @if($package->seller_id == 0)
                                                                    {{$package->other_seller}}
                                                                @else
                                                                    {{$package->seller}}
                                                                @endif
                                                                @if($package->price != null && $package->price > 0)
                                                                    ({{$package->price}} {{$package->currency}})
                                                                @else
                                                                    (-)
                                                                @endif
                                                            </p>
                                                        </td>
                                                        <td class="strong-p">
                                                            @if($package_weight > 0)
                                                                {{$package_weight}} {{$package->unit}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="strong-p">
                                                            @if($package->amount > 0)
                                                                {{$package->cur_icon}} {{$package->amount}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="order-status">
                                                                {{$package->status}}
                                                                <p class="order-status-changed"><span>{{date('d.m.Y H:i', strtotime($package->last_status_date))}}</span></p>
                                                            </span>
                                                        </td>
                                                        @if($general_settings->referral_secret == 1)
                                                            <td class="order-payment">
                                                                @if($package->paid_status == 1)
                                                                    <button type="button" disabled class="btn btn-paid"
                                                                            style="cursor: not-allowed !important;">{!! __('static.paid') !!}
                                                                    </button>
                                                                @else
                                                                    @if($package->amount > 0)
                                                                        <button style="background-color: #f16021;"
                                                                                type="button" class="btn btn-paid"
                                                                                data-has-courier="{{$package->has_courier}}"
                                                                                data-has-courier-message="{!! __('static.packages_has_courier_message') !!}"
                                                                                data-balance="{{Auth::user()->balance()}}"
                                                                                data-balance-message="{!! __('static.packages_balance_message') !!}"
                                                                                data-amount="{{$package->amount_usd - $package->paid}}"
                                                                                data-confirm="{!! __('static.confirm_pay') !!}"
                                                                                onclick="paid_package(this, '{{route("pay_order", $package->id)}}');">
                                                                            {!! __('buttons.pay') !!}
                                                                            {{--                                                                        (${{sprintf('%0.2f', ($package->amount_usd - $package->paid))}})--}}
                                                                        </button>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td class="order-op" style="padding: 0px 9px !important;">
                                                            <span
                                                                onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route("get_package_items")}}');"
                                                                class="order-view"><i class="fas fa-eye"></i></span>
{{--                                                            @if(($package->internal_id == null || $package->invoice_doc == null || $package->invoice_confirmed != 1) && $package->is_warehouse < 2)--}}
{{--                                                                <a href="{{route("get_package_update_by_sub_accounts", $package->id)}}"--}}
{{--                                                                   class="order-update" title=""><i--}}
{{--                                                                        class="fas fa-pencil-alt"></i></a>--}}
{{--                                                            @endif--}}
{{--                                                            @if($package->internal_id == null && $package->is_warehouse == 0)--}}
{{--                                                                <button class="order-delete-btn"--}}
{{--                                                                        data-confirm="{!! __('static.confirm_delete_order') !!}"--}}
{{--                                                                        onclick="delete_order(this, '{{route("delete_package_by_sub_accounts", $package->id)}}');">--}}
{{--                                                                    <i class="fas fa-trash"></i></button>--}}
{{--                                                            @endif--}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="profile-information-block sp-padding">
                                            <div class="form-alert show-alert">
                                                <p>{!! __('static.table_no_item') !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mobile-show custom_orders_mobile">
                            
                                <div class="n-order-status">
                                    <ul class="custom_orders_status" style="padding: 1rem;">
                                        <li>
                                            <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=3'}}"
                                                id="status_3">
                                                {!! __('static.in_warehouse_status') !!} <span>{{$counts['is_warehouse']}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=4'}}"
                                                id="status_4">
                                                {!! __('static.sent_status') !!} <span>{{$counts['sent']}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=5'}}"
                                                id="status_5">
                                                {!! __('static.in_baku_status') !!} <span>{{$counts['in_office']}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("get_orders_by_sub_accounts") . '?country=' . $search['country'] . '&status=6'}}"
                                                id="status_6">
                                                {!! __('static.archive_status') !!} <span>{{$counts['delivered']}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                @if(count($packages) > 0)
                                    <div class="order-item" style="padding: 1rem;">
                                    @foreach($packages as $package)
                                        <table class="table table-bordered mobil_table_border">
                                            <tbody>
                                            
                                                @if($package->chargeable_weight == 1)
                                                    @php($package_weight = $package->gross_weight)
                                                @else
                                                    @php($package_weight = $package->volume_weight)
                                                @endif

                                                @switch($package->last_status_id)
                                                    @case(6)
                                                    @php($tr_class = 'fill-declaration-tr')
                                                    @break
                                                    @case(2)
                                                    @php($tr_class = 'paid-tr')
                                                    @break
                                                    @default
                                                    @if($package->paid_status == 0)
                                                        @php($tr_class = 'not-paid-tr')
                                                    @else
                                                        @php($tr_class = '')
                                                    @endif
                                                @endswitch
                                                <tr>
                                                    <td>{!! __('table.customer') !!}</td>
                                                    <td>
                                                        <p class="strong-p">AS{{$package->suite}}</p>
                                                        <p>{{$package->client_name}} {{$package->client_surname}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{!! __('table.flight') !!}</td>
                                                    <td>
                                                        @if(isset($package->flight))
                                                            @if(strlen($package->flight) > 11)
                                                                {{substr($package->flight, 0, 11)}}
                                                            @else
                                                                {{$package->flight}}
                                                            @endif
                                                        @else
                                                            ---
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{!! __('table.tracking') !!}</td>
                                                    <td>{{$package->track}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{!! __('table.store') !!}</td>
                                                    <td>
                                                        @if($package->seller_id == 0)
                                                            {{$package->other_seller}}
                                                        @else
                                                            {{$package->seller}}
                                                        @endif
                                                        @if($package->price != null && $package->price > 0)
                                                            ({{$package->price}} {{$package->currency}})
                                                        @else
                                                            (-)
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{!! __('table.weight') !!}</td>
                                                    <td>
                                                        @if($package_weight > 0)
                                                            {{$package_weight}} {{$package->unit}}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="order-status">
                                                    <td>{!! __('table.status') !!}</td>
                                                    <td>{{$package->status}}
                                                        <p>{{date('d.m.Y H:i', strtotime($package->last_status_date))}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{!! __('table.delivery_amount') !!}</td>
                                                    <td>
                                                        @if($package->amount > 0)
                                                            {{$package->cur_icon}} {{$package->amount}}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($general_settings->referral_secret == 1)
                                                    <tr>
                                                        <td>{!! __('table.pay') !!}</td>
                                                        <td class="order-payment">
                                                            @if($package->paid_status == 1)
                                                                <button type="button" disabled class="btn btn-paid"
                                                                        style="cursor: not-allowed !important;">{!! __('static.paid') !!}
                                                                </button>
                                                            @else
                                                                @if($package->amount > 0)
                                                                    <button style="background-color: #f16021;"
                                                                            type="button" class="btn btn-paid"
                                                                            data-has-courier="{{$package->has_courier}}"
                                                                            data-has-courier-message="{!! __('static.packages_has_courier_message') !!}"
                                                                            data-balance="{{Auth::user()->balance()}}"
                                                                            data-balance-message="{!! __('static.packages_balance_message') !!}"
                                                                            data-amount="{{$package->amount_usd - $package->paid}}"
                                                                            data-confirm="{!! __('static.confirm_pay') !!}"
                                                                            onclick="paid_package(this, '{{route("pay_order", $package->id)}}');">
                                                                        {!! __('buttons.pay') !!}
                                                                        {{--                                                                    (${{sprintf('%0.2f', ($package->amount_usd - $package->paid))}})--}}
                                                                    </button>
                                                                @else
                                                                    -
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>{!! __('table.look') !!}</td>
                                                    <td class="order-info-link">
                                                        <span
                                                            onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route("get_package_items")}}');"
                                                            class="order-view"><i class="fas fa-eye"></i></span>
                                                    </td>
                                                </tr>
{{--                                                @if(($package->internal_id == null || $package->invoice_doc == null || $package->invoice_confirmed != 1) && $package->is_warehouse < 2)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.edit') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            <a href="{{route("get_package_update_by_sub_accounts", $package->id)}}"--}}
{{--                                                               class="order-update" title=""><i--}}
{{--                                                                    class="fas fa-pencil-alt"></i></a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endif--}}
{{--                                                @if($package->internal_id == null && $package->is_warehouse == 0)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.delete') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            <button class="order-delete-btn"--}}
{{--                                                                    data-confirm="{!! __('static.confirm_delete_order') !!}"--}}
{{--                                                                    onclick="delete_order(this, '{{route("delete_package_by_sub_accounts", $package->id)}}');">--}}
{{--                                                                <i class="fas fa-trash"></i></button>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endif--}}
                                                </tbody>
                                            </table>
                                        @endforeach
                                          

                                    </div>
                                @else
                                    <div class="profile-information-block sp-padding">
                                        <div class="form-alert show-alert">
                                            <p>{!! __('static.table_no_item') !!}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="item-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
                        <h1>{!! __('static.products') !!}: <b id="item_track_number"></b></h1>
                        <!-- <hr> -->
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{!! __('table.item') !!}</th>
                                <th>{!! __('table.category') !!}</th>
                                <th>{!! __('table.price') !!}</th>
                            </tr>
                            </thead>
                            <tbody id="items_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('item-modal')"></div>
    </div>
@endsection

@section('css')
<style>
    .status_bar{
        padding: 0px 33px 68px 33px !important;
    }

    .mobil_table_border{
        margin-bottom: 19px;
        box-shadow: -5px 5px 28px 5px rgba(0, 0, 0, 0.14);
    }
</style>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let current_status = '{{$search['status']}}';
            $("#status_" + current_status).addClass('active');

            $(".mobile_status_select_options").removeAttr('selected');
            $("#mobile_status_select_" + current_status).attr('selected', true);
        });
    </script>
@endsection
