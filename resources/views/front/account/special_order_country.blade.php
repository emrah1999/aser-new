@extends('web.layouts.web')
@section('content')
{{--<section class="content-page-section">--}}

{{--    <div class="page-content-block">--}}
{{--        <div class="container-fluid page_containers">--}}
{{--            <div class="container-lg">--}}
{{--                <div class="row">--}}
{{--                    @include('web.account.account_left_bar')--}}
{{--                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">--}}
{{--                        <div class="page-content-header">--}}
{{--                            <div class="page-content-text account-index-top">--}}

{{--                                @include("front.account.country_select_bar")--}}


{{--                                <div class="campaign hidden"></div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="page-content-right">--}}

{{--                            <div class="thumbnail thumbnail-data">--}}
{{--                                <div class="table-responsive">--}}
{{--                                    @if(count($orders) > 0)--}}
{{--                                    <div class="n-order-table sp-order-table desktop-show" style="overflow-x: auto;">--}}
{{--                                        <table>--}}
{{--                                            <thead>--}}
{{--                                                <tr>--}}
{{--                                                    <th>{!! __('table.id') !!}</th>--}}
{{--                                                    <th>{!! __('table.url') !!}</th>--}}
{{--                                                    <th>{!! __('table.price') !!}</th>--}}
{{--                                                    <th>{!! __('table.debt') !!}</th>--}}
{{--                                                    <th>{!! __('table.status') !!}</th>--}}
{{--                                                    <th>{!! __('table.amount_for_special_order') !!}</th>--}}
{{--                                                    <th>{!! __('table.pay') !!}</th>--}}
{{--                                                    <th>{!! __('table.actions') !!}</th>--}}
{{--                                                </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                                @foreach($orders as $order)--}}
{{--                                                <tr class="order_{{$order->id}}">--}}
{{--                                                    <td>{{$order->id}}</td>--}}
{{--                                                    <td>--}}
{{--                                                        @php($urls = $order->urls)--}}
{{--                                                        @php($url_arr = explode(',', $urls))--}}
{{--                                                        @for($i = 0; $i < count($url_arr); $i++)--}}
{{--                                                            @php($url=$url_arr[$i])--}}
{{--                                                            @php($url_show=$url)--}}
{{--                                                            @if(strlen($url)> 20)--}}
{{--                                                            @php($url_show = substr($url, 0, 20) . '...')--}}
{{--                                                            @endif--}}
{{--                                                            <p class="order_link">--}}
{{--                                                                <a href="{{$url}}" target="_blank">{{$url_show}}</a>--}}
{{--                                                            </p>--}}
{{--                                                            @endfor--}}
{{--                                                    </td>--}}
{{--                                                    <td class="strong-p">--}}
{{--                                                        {{$order->price}} {{$order->currency}}--}}
{{--                                                    </td>--}}
{{--                                                    <td class="strong-p">--}}
{{--                                                        {{$order->cargo_debt + $order->common_debt}} {{$order->currency}}--}}
{{--                                                    </td>--}}
{{--                                                    <td>--}}
{{--                                                        <span class="order-status">--}}
{{--                                                            {{$order->status}}--}}
{{--                                                        </span>--}}
{{--                                                    </td>--}}
{{--                                                    <td>--}}
{{--                                                        {{$order->total_amount}} {{$order->currency}}--}}
{{--                                                    </td>--}}
{{--                                                    <td class="order-payment">--}}
{{--                                                        @if(($order->is_paid == 0 || $order->cargo_debt > 0 || $order->common_debt > 0) && $order->waiting_for_payment == 0)--}}

{{--                                                        <button class="btn"--}}
{{--                                                            onclick="pay_special_order('{{route("pay_to_special_order", [$country_id, $order->id, 'locale' => App::getLocale()])}}', this);">--}}
{{--                                                            {!! __('buttons.pay') !!}--}}
{{--                                                        </button>--}}
{{--                                                        @else--}}
{{--                                                        <button disabled--}}
{{--                                                            class="btn">{!! __('static.paid') !!}</button>--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
{{--                                                    <td class="order-op">--}}
{{--                                                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; height: 100%;">--}}
{{--                                                            <span onclick="show_items_for_special_orders('{{$order->group_code}}', '{{route("show_orders_for_group_special_orders", [$country_id, 'locale' => App::getLocale()])}}');" class="order-view">--}}
{{--                                                                <i class="fas fa-eye"></i>--}}
{{--                                                            </span>--}}

{{--                                                            @if($order->disable == 0 && $order->is_paid == 0 && $order->waiting_for_payment == 0)--}}
{{--                                                            <a href="{{route("get_special_order_update", [$country_id, $order->id, 'locale' => App::getLocale()])}}" class="order-update" title="">--}}
{{--                                                                <i class="fas fa-pencil-alt"></i>--}}
{{--                                                            </a>--}}

{{--                                                            <button class="order-delete-btn" data-confirm="{!! __('static.confirm_delete_for_special_order') !!}" onclick="delete_special_order(this, '{{route("delete_special_order", [$country_id, $order->id, 'locale' => App::getLocale()])}}');">--}}
{{--                                                                <i class="fas fa-trash"></i>--}}
{{--                                                            </button>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}

{{--                                                </tr>--}}
{{--                                                @endforeach--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}

{{--                                    </div>--}}

{{--                                    <div class="mobile-show">--}}
{{--                                        <div class="order-item">--}}
{{--                                            <table class="table table-bordered">--}}
{{--                                                <tbody>--}}
{{--                                                    @foreach($orders as $order)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.url') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            @php($urls = $order->urls)--}}
{{--                                                            @php($url_arr = explode(',', $urls))--}}
{{--                                                            @for($j = 0; $j < count($url_arr); $j++)--}}
{{--                                                                @php($url=$url_arr[$j])--}}
{{--                                                                @php($url_show=$url)--}}
{{--                                                                @if(strlen($url)> 20)--}}
{{--                                                                @php($url_show = substr($url, 0, 20) . '...')--}}
{{--                                                                @endif--}}
{{--                                                                <p>--}}
{{--                                                                    <a href="{{$url}}"--}}
{{--                                                                        target="_blank">{{$url_show}}</a>--}}
{{--                                                                </p>--}}
{{--                                                                @endfor--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.price') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->price}} {{$order->currency}}--}}
{{--                                                            <span class="price-block"> ({{$order->price_azn}} AZN)</span>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            {!! __('table.cargo_debt') !!}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->cargo_debt}} {{$order->currency}}--}}
{{--                                                            <span class="price-block"> ({{$order->cargo_debt_azn}} AZN)</span>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.common_debt') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->common_debt}} {{$order->currency}}--}}
{{--                                                            <span class="price-block"> ({{$order->common_debt_azn}} AZN)</span>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.status') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            <span class="order-status">--}}
{{--                                                                {{$order->status}}--}}
{{--                                                            </span>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.amount_for_special_order') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->total_amount}} {{$order->currency}}--}}
{{--                                                            <span class="price-block">({{$order->total_amount_azn}} AZN)</span>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.pay') !!}</td>--}}
{{--                                                        <td class="order-payment">--}}
{{--                                                            @if(($order->is_paid == 0 || $order->cargo_debt > 0 || $order->common_debt > 0) && $order->waiting_for_payment == 0)--}}
{{--                                                            <button class="btn"--}}
{{--                                                                onclick="pay_special_order('{{route("pay_to_special_order", [$country_id, $order->id, 'locale' => App::getLocale()])}}', this);">--}}
{{--                                                                {!! __('buttons.pay') !!}--}}
{{--                                                            </button>--}}
{{--                                                            @else--}}
{{--                                                            <button disabled--}}
{{--                                                                class="btn">{!! __('static.paid') !!}</button>--}}
{{--                                                            @endif--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.details') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            <span--}}
{{--                                                                onclick="show_items_for_special_orders('{{$order->group_code}}', '{{route("show_orders_for_group_special_orders", [$country_id, 'locale' => App::getLocale()])}}');"--}}
{{--                                                                class="order-view"><i--}}
{{--                                                                    class="fas fa-eye"></i></span>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    @if($order->disable == 0 && $order->is_paid == 0 && $order->waiting_for_payment == 0)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.edit') !!}</td>--}}
{{--                                                        <td>--}}
{{--                                                            <a href="{{route("get_special_order_update", [$country_id, $order->id, 'locale' => App::getLocale()])}}"--}}
{{--                                                                class="order-update" title=""><i--}}
{{--                                                                    class="fas fa-pencil-alt"></i></a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! __('table.delete') !!}</td>--}}
{{--                                                        <td class="order-delete" style="padding-top: 0;">--}}
{{--                                                            <button class="order-delete-btn"--}}
{{--                                                                data-confirm="{!! __('static.confirm_delete_for_special_order') !!}"--}}
{{--                                                                onclick="delete_special_order(this, '{{route("delete_special_order", [$country_id, $order->id, 'locale' => App::getLocale()])}}');">--}}
{{--                                                                <i class="fas fa-trash"></i></button>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    @endif--}}
{{--                                                    <br>--}}
{{--                                                    @endforeach--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @else--}}
{{--                                    <div class="profile-information-block sp-padding">--}}
{{--                                        <div class="form-alert show-alert">--}}
{{--                                            <p>{!! __('static.selectItem') !!}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @endif--}}


{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

<section class="content-page-section">
    <div class="page-content-block">
        <div class="container-fluid page_containers">
            <div class="container-lg">
                <div class="row">
                    @include('web.account.account_left_bar')

                    <div class="col-md-9">
                        <div class="alert alert-warning text-center" style="margin-top: 100px; padding: 40px; font-size: 18px; border-radius: 10px;">
                            {!! __('static.special_error_text') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('styles')
<style>
    .order_link {
        margin-bottom: 0;
    }

    .tariff-select {
        margin-bottom: -107px;
    }

    .table-data__thead-th {
        vertical-align: top;
    }

    .left-bar-new-style {
        /* margin-top: -113px; */
    }

    .page-content-block {
        padding: 20px 90px;
    }

    .page-content-part {
        display: flex;
    }

    .page-content-right {
        flex-grow: 1;
        background-color: #fff7e6;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        height: auto;
        margin-top: 100px;
    }

    .account-home-top {
        margin-bottom: 20px;
    }

    .account-address-info {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .account-address-main .row {
        display: flex;
        flex-wrap: wrap;
    }

    .country-block-link {
        display: block;
        text-decoration: none;
        color: inherit;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .country-block-link:hover {
        transform: scale(1.05);
    }

    .country-block {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .country-block:hover {
        background-color: #f0f0f0;
    }

    .country-flag img {
        width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
    }

    .country-name {
        font-weight: bold;
        color: #333;
        white-space: nowrap;
        text-overflow: ellipsis;
        /* overflow: hidden; */
        max-width: 150px;
        margin-right: -3px;
    }

    .alert {
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert strong {
        font-weight: bold;
    }

    .alert ul {
        padding-left: 20px;
    }

    @media (max-width: 768px) {
        .country-list{
            margin-left: 0;
        }
        .page-content-part {
            flex-direction: column;
        }

        .page-content-block {
            padding: 20px;
        }

        .country-block {
            margin-bottom: 10px;
        }
    }

    .n-order-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .n-order-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .n-order-table th,
    .n-order-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 0px solid #ddd;
    }

    .n-order-table th {
        background: #FFF7E6;
        color: #000;
        font-weight: bold;
    }

    .n-order-table tr:hover {
        background: #f1f1f1;
    }

    .n-order-table a {
        color: #007bff;
        text-decoration: none;
    }

    .n-order-table a:hover {
        text-decoration: underline;
    }

    .order-status {
        padding: 5px 10px;
        border-radius: 5px;
    }

    .order-status[data-status="pending"] {
        background: #ffc107;
    }

    .order-status[data-status="paid"] {
        background: #28a745;
    }

    .order-status[data-status="cancelled"] {
        background: #dc3545;
    }

    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .order-payment .btn {
        background: #28a745;
        color: #fff;
    }

    .order-payment .btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    .order-op {
        display: flex;
        margin-top: 10%;
        padding-bottom: 15%;
        gap: 17px;
        align-items: center;
        vertical-align: center;

    }

    .order-op .fas {
        cursor: pointer;
        font-size: 16px;
        color: #007bff;
    }

    .order-op .fas:hover {
        color: #0056b3;
    }

    .order-delete-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #dc3545;
    }

    .order-delete-btn:hover {
        color: #b71c1c;
    }

    @media (max-width: 768px) {
        .desktop-show {
            display: none;
        }

        .mobile-show {
            display: block;
        }

        .order-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .order-item table {
            width: 100%;
        }

        .order-item td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .order-item .order-view,
        .order-item .order-update,
        .order-item .order-delete-btn {
            font-size: 18px;
            cursor: pointer;
        }

        .order-item .order-view {
            color: #007bff;
        }

        .order-item .order-update {
            color: #ffc107;
        }

        .order-item .order-delete-btn {
            color: #dc3545;
        }
    }

    @media (min-width: 769px) {
        .mobile-show {
            display: none;
        }

        .desktop-show {
            display: block;
        }
    }
    @if(count($orders)==0)
        @media (max-width: 575.98px) {
            .footer{
                padding: 10px 0;
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        }
       @endif
</style>

@endsection

@section('scripts')


@if(Request::get('approve-referral') == 'OK')
<script>
    let swal_case = '{{Request::get('
    case ')}}';
    let swal_message = '{{Request::get('
    message ')}}';

    swal(
        'Referral account',
        swal_message,
        swal_case
    );
</script>
@endif

@if(session('special_orders_active') == 'false')
<script>
    let swal_message = '{{session('
    message ')}}';
    let swal_title = "{!! __('buttons.order') !!}";

    swal(
        swal_title,
        swal_message,
        'warning'
    );
</script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countryActive = document.querySelector('.country-active');
        const countryList = document.querySelector('.country-list');

        countryActive.addEventListener('click', function() {
            countryList.style.display = countryList.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(event) {
            if (!countryActive.contains(event.target) && !countryList.contains(event.target)) {
                countryList.style.display = 'none';
            }
        });
    });
</script>
@endsection