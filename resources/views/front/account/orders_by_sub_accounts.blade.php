@extends('web.layouts.web')
@section('content')
    <section class="content-page-section">
        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part">
                        @include('web.account.account_left_bar')


                        <div class="page-content-right">
                            <div class="sub-account-tab referal-sm-main clearfix">
                                <ul>
                                    <li><a href="{{route("get_sub_accounts", ['locale' => App::getLocale()])}}">&nbsp;{!! __('buttons.referrals_list') !!}</a></li>
                                    <li class="active"><a href="{{route("get_orders_by_sub_accounts", ['locale' => App::getLocale()])}}">{!! __('buttons.orders_by_referrals') !!}</a></li>
                                </ul>
                                <div class="referal-input">
                                    <label>{!! __('static.my_referral_link') !!}: (<a target="_blank"
                                                                                      href="{{ route('faq_page', ['locale' => App::getLocale()]) }}">{!! __('static.read_more') !!}</a>):</label>
                                    <input type="text" copy-text="{!! __('static.link_copied') !!}" class="form-control" readonly=""
                                           value="{{ route('register', ['locale' => App::getLocale()]) }}?parent={{ Auth::user()->suite() }}"
                                           id="referral-link">
                                </div>
                            </div>

                            <div class="n-order-list custom_orders_desktop desktop-show">
                                <div class="n-order-top flex space-between order-top-block">


                                </div>
                                <div class="n-order-bottom">
                                    <div class="n-order-bottom-pad status_bar">


                                        <div class="n-order-status">
                                            <ul class="flex space-between">

                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts", ['locale' => App::getLocale()]) . '?country=' . $search['country'] . '&status=3'}}"
                                                       id="status_3">
                                                        {!! __('static.in_warehouse_status') !!}<span>{{$counts['is_warehouse']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts", ['locale' => App::getLocale()]) . '?country=' . $search['country'] . '&status=4'}}"
                                                       id="status_4">
                                                        {!! __('static.sent_status') !!} <span>{{$counts['sent']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts", ['locale' => App::getLocale()]) . '?country=' . $search['country'] . '&status=5'}}"
                                                       id="status_5">
                                                        {!! __('static.in_baku_status', ['locale' => App::getLocale()]) !!} <span>{{$counts['in_office']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders_by_sub_accounts", ['locale' => App::getLocale()]) . '?country=' . $search['country'] . '&status=6'}}"
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
                                                    <th>{!! __('table.invoice_status') !!}</th>
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
                                                            <span class="invoiceStatus">
                                                                @if($package->last_status_id == 7)
                                                                    <p style="color: red;" aria-placeholder="Qadağan edilən bağlamalara invoys yüklənə bilməz"></p>
                                                                @else
                                                                    @if($package->invoice_status == 1)
                                                                        <p style="color: red;">{!! __('status.no_invoice') !!}</p>
                                                                    @elseif($package->invoice_status == 2)
                                                                        {!! __('status.incorrect_invoice') !!}
                                                                    @elseif($package->invoice_status == 3)
                                                                        {!! __('status.correct_invoice') !!}
                                                                    @elseif($package->invoice_status == 4)
                                                                        {!! __('status.invoice_uploaded') !!}
                                                                    @endif
                                                                @endif
                                                            </span>
                                                            <span class="invoiceStatusIcon">
                                                                @if($package->last_status_id == 7)
                                                                    <a href="#" style="display: none" target="_blank" class="fas fa-eye" placeholder="Prohibet not update">

                                                                    </a>
                                                                @else
                                                                    @if($package->invoice_status == 4)
                                                                        <a href="{{ $package->invoice_doc }}" target="_blank" class="fas fa-eye">
                                                                            {!! __('table.show_invoice_file') !!}
                                                                        </a>

                                                                    @elseif($package->invoice_status == 1)
                                                                        <a href="{{route('get_package_update', $package->id)}}" class="fas fa-upload" style="color: red;">
                                                                            {!! __('table.upload_invoice_file') !!}
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </span>
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
                                                                onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route("get_package_items", ['locale' => App::getLocale()])}}');"
                                                                class="order-view"><i class="fas fa-eye"></i></span>

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

@section('styles')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .page-content-part {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            padding-left: 90px;
            padding-right: 90px;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .page-content-right {
            flex: 1;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .account-left-bar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .sub-account-tab ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0 0 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            justify-content: flex-end;
        }

        .sub-account-tab ul li {
            flex: 1;
        }

        .sub-account-tab ul li a {
            display: block;
            padding: 15px;
            text-align: center;
            color: #10458C;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sub-account-tab ul li.active a {
            background-color: #10458C;
            color: #fff;
        }

        .sub-account-tab ul li a:hover {
            background-color: #08315e;
            color: #fff;
        }

        @media (max-width: 768px) {
            .page-content-part {
                flex-direction: column;
                padding-left: 20px;
                padding-right: 20px;
            }

            .sub-account-tab ul {
                flex-direction: column;
            }

            .sub-account-tab ul li {
                margin-bottom: 10px;
            }
        }

        .sub-table {
            width: 100%;
            overflow-x: auto;
        }

        .sub-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .sub-table th,
        .sub-table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .sub-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .sub-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .sub-table tr:hover {
            background-color: #f1f1f1;
        }

        .mobile-show {
            display: none;
        }

        @media (max-width: 768px) {
            .desktop-show {
                display: none;
            }

            .mobile-show {
                display: block;
            }

            .order-item {
                background-color: #fff;
                margin-bottom: 20px;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        }

        .orange-button {
            background-color: #10458C;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .orange-button:hover {
            background-color: #08315e;
        }

        .sub-account-order-btn {
            display: flex;
            align-items: center;
        }

        .sub-account-order-btn i {
            margin-right: 5px;
        }

        .form-alert {
            background-color: #ffeb3b;
            color: #333;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        .n-order-status {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .n-order-status ul {
            display: flex;
            justify-content: space-between;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .n-order-status li {
            flex: 1;
        }

        .n-order-status li a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            color: #10458C;
            background-color: #f7f7f7;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .n-order-status li a:hover,
        .n-order-status li a:focus {
            background-color: #10458C;
            color: #fff;
        }



        .n-order-table {
            width: 100%;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .n-order-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .n-order-table th,
        .n-order-table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .n-order-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .n-order-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .n-order-table tr:hover {
            background-color: #f1f1f1;
        }

        .text-upper {
            text-transform: uppercase;
        }

        .strong-p {
            font-weight: bold;
            margin: 0;
        }

        .order-status {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .order-status-changed {
            font-size: 12px;
            color: #888;
        }

        .order-payment .btn-paid {
            background-color: #f16021;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .order-payment .btn-paid[disabled] {
            background-color: #d3d3d3;
            cursor: not-allowed;
        }

        .order-payment .btn-paid:hover:not([disabled]) {
            background-color: #d35400;
        }

        .order-op .order-view {
            color: #10458C;
            cursor: pointer;
            font-size: 18px;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .order-op .order-view:hover {
            color: #08315e;
        }

        .form-alert {
            background-color: #ffeb3b;
            color: #333;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .n-order-table th,
            .n-order-table td {
                padding: 10px;
            }
        }
    </style>
@endsection



@section('scripts')
    <script>
        $(document).ready(function () {
            let current_status = '{{$search['status']}}';
            $("#status_" + current_status).addClass('active');

            $(".mobile_status_select_options").removeAttr('selected');
            $("#mobile_status_select_" + current_status).attr('selected', true);
        });
    </script>
    <script>
        const referralInput = document.getElementById('referral-link');

        referralInput.addEventListener('click', function() {
            referralInput.select();
            referralInput.setSelectionRange(0, 99999);

            document.execCommand('copy');

            alert("{!! __('static.link_copied') !!}");
        });
    </script>
@endsection
