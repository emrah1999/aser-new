@extends('web.layouts.web')
@section('content')
<section class="content-page-section">
    <div class="page-content-block">
        <div class="container-fluid page_containers">
            <div class="page-content-part">
                <!-- Left Bar -->
                <div class="container-lg">
                    <div class="row">
                        @include('web.account.account_left_bar')

                        <!-- Right Content -->
                        <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                            <div class="page-content-right">
                                <div class="sub-account-tab referal-sm-main clearfix">
                                    <ul>
                                        <li class="active">
                                            <a href="{{ route('get_sub_accounts', ['locale' => App::getLocale()]) }}">&nbsp;{!! __('buttons.referrals_list') !!}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_orders_by_sub_accounts', ['locale' => App::getLocale()]) }}">{!! __('buttons.orders_by_referrals') !!}</a>
                                        </li>
                                    </ul>
                                    <div class="referal-input">
                                        <label>{!! __('static.my_referral_link') !!}: (<a target="_blank"
                                                href="{{ route('faq_page', ['locale' => App::getLocale()]) }}">{!! __('static.read_more') !!}</a>):</label>
                                        <input type="text" copy-text="{!! __('static.link_copied') !!}" class="form-control" readonly=""
                                            value="{{ route('register', ['locale' => App::getLocale()]) }}?parent={{ Auth::user()->suite() }}"
                                            id="referral-link">
                                    </div>
                                </div>
                                @if($general_settings->referral_secret == 1)
                                <div class="sub-account-tab referal-sm-main clearfix">
                                    <div class="order-form">
                                        <div class="store-inputs">
                                            <div class="form-group field-userorder-country">
                                                <div class="order-product-list">
                                                    <div class="list-item">
                                                        <div class="form-element">
                                                            <div class="row">
                                                                <div class="col-md-3" style="margin-right: 5px;">
                                                                    <div class="form-group field-userorder-product_count required">
                                                                        <input type="text" id="my_balance_for_pay_debt" disabled readonly value="{!! __('labels.my_balance') !!} ${{ Auth::user()->balance() }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" style="margin-right: 5px;">
                                                                    <div class="form-group field-userorder-product_count required">
                                                                        <input type="text" id="total_debt_for_pay_debt" disabled readonly value="{!! __('labels.total_debt') !!} ${{$total_debt}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="order-button">
                                                                        <button type="button" class="orange-button" data-message="{!! __('static.referral_pay_all_debt_message') !!}" onclick="pay_all_referral_debt(this, '{{ route('pay_all_referral_debt', ['locale' => App::getLocale()]) }}');"> {!! __('buttons.pay_all_debts') !!}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="sub-account-main active">
                                    <div class="sub-panel for-subaccount">
                                        @if(count($sub_accounts) > 0)
                                        <div class="sub-table desktop-show">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>{!! __('table.customer_code') !!} </th>
                                                        <th>{!! __('table.name_surname') !!} </th>
                                                        @if($general_settings->referral_secret == 1)
                                                        <th>{!! __('table.balance') !!}</th>
                                                        <th>{!! __('table.debt') !!}</th>
                                                        <th>{!! __('table.add_balance') !!}</th>
                                                        <th>{!! __('table.login_account') !!}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sub_accounts as $sub_account)
                                                    <tr>
                                                        <td> {{$sub_account->id}}</td>
                                                        <td> {{$sub_account->name}} {{$sub_account->surname}} </td>
                                                        @if($general_settings->referral_secret == 1)
                                                        <td> ${{$sub_account->balance}} </td>
                                                        <td> ${{$sub_account->debt}} </td>
                                                        <td>
                                                            <span class="btn orange-button sub-account-order-btn"
                                                                onclick="add_referal_balance({{$sub_account->id}});"><i
                                                                    class="fas fa-credit-card"></i> {!! __('buttons.add_balance_for_referral') !!}</span>
                                                        </td>
                                                        <td>
                                                            <span data-confirm="{!! __('static.confirm_change_account') !!}"
                                                                class="btn orange-button sub-account-order-btn"
                                                                onclick="login_to_sub_account(this, '{{route("login_referal_account")}}', '{{$sub_account->id}}');">{!! __('buttons.login_referral_account') !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>


                                        @else
                                        <div class="form-alert show-alert">
                                            <p>{!! __('static.table_no_item') !!}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($general_settings->referral_secret == 1)
<div class="modal fade" id="referal-balance-modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="referal_balance_form" action="{{route("add_referal_balance")}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form row">
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <div class="col-md-5" style="display: inline-block;">
                                <label for="referal_id">{!! __('labels.referral_id') !!}</label>
                                <input type="number" name="referal_id" id="referal_id" class="form-control" readonly
                                    required>
                            </div>
                            <div class="col-md-5" id="my_balance" style="display: inline-block;">
                                <label for="my_balance">{!! __('labels.my_balance') !!}</label>
                                <input type="text" class="form-control" id="my_balance" readonly disabled
                                    value="${{Auth::user()->balance()}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-5" style="display: inline-block;">
                                <label for="amount">{!! __('labels.amount') !!}</label>
                                <input type="number" name="amount" id="amount" class="form-control" required min="0"
                                    step="0.01">
                            </div>
                            <div class="col-md-5" style="display: inline-block;">
                                <label for="payment_type">{!! __('labels.payment_type') !!}</label>
                                <select name="type" class="form-control" id="payment_type" required
                                    oninput="select_referal_balance_type(this);">
                                    <option value="1">{!! __('inputs.from_my_balance') !!}</option>
                                    <option value="2">{!! __('inputs.with_cart') !!}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="modal-footer">
                    <p class="submit">
                        <input type="submit" value="{!! __('buttons.continue') !!}" style=" margin-right: 25px;"
                            class="btn btn-primary">
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div id="close_modal" class="close_modal" onclick="close_modal('referal-balance-modal')"></div>
</div>
@endif
@endsection

@section('styles')
<style>
    .footer-new {
        margin-top: 200px;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .page-content-part {
        display: flex;
        flex-wrap: nowrap;
        gap: 20px;
        margin-top: 20px;
        padding-left: 90px;
        padding-right: 90px;
        /* height: calc(100vh - 20px); */
        box-sizing: border-box;
    }

    .page-content-right {
        flex: 1;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 8px;
        height: 97%;
        box-sizing: border-box;
    }

    .account-left-bar {
        flex: 0 0 250px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        height: 100%;
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
        /* Linkleri sağa yasla */
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
            /* display: none; */
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
</style>
@endsection



@section('scripts')
<script>
    $(document).ready(function() {
        $("#tbodyWeb tr").slice(12).hide();
        var mincount = 10;
        var maxcount = 20;

        $(".n-order-table").scroll(function() {
            var scrollHeight = $(".n-order-table")[0].scrollHeight;
            var scrollTop = $(".n-order-table").scrollTop();
            var containerHeight = $(".n-order-table").outerHeight();

            if (scrollTop + containerHeight >= scrollHeight - 50) {
                $("tbody tr").slice(mincount, maxcount).slideDownSlow(600);

                mincount = mincount + 10;
                maxcount = maxcount + 10;
            }
        });

        $.fn.fadeInSlow = function(duration) {
            $(this).css("display", "none").fadeIn(duration);
        };

        $.fn.slideDownSlow = function(duration) {
            $(this).css({
                marginTop: "20px",
                opacity: 0
            }).slideDown(duration).animate({
                marginTop: 0,
                opacity: 1
            });
        };
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