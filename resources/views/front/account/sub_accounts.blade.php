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
                                    <li class="active"><a
                                                href="{{route("get_sub_accounts")}}">&nbsp;{!! __('buttons.referrals_list') !!}</a>
                                    </li>
                                    <li>
                                        <a href="{{route("get_orders_by_sub_accounts")}}">{!! __('buttons.orders_by_referrals') !!}</a>
                                    </li>
                                </ul>
                                <div class="referal-input">
                                    <label>{!! __('static.my_referral_link') !!}: (<a target="_blank"
                                                                                    href="{{route("faq_page")}}">{!! __('static.read_more') !!}</a>):</label>
                                    <input type="text" copy-text="{!! __('static.link_copied') !!}" class="form-control"
                                           readonly="" value="{{route("register")}}?parent={{Auth::user()->suite()}}"
                                           name="">
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
                                                                        <input type="text" id="my_balance_for_pay_debt" disabled readonly value="{!! __('labels.my_balance') !!} ${{Auth::user()->balance()}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" style="margin-right: 5px;">
                                                                    <div class="form-group field-userorder-product_count required">
                                                                        <input type="text" id="total_debt_for_pay_debt" disabled readonly value="{!! __('labels.total_debt') !!} ${{$total_debt}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="order-button">
                                                                        <button type="button" class="orange-button" data-message="{!! __('static.referral_pay_all_debt_message') !!}" onclick="pay_all_referral_debt(this, '{{route("pay_all_referral_debt")}}');"> {!! __('buttons.pay_all_debts') !!}</button>
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
                                                        <td>  {{$sub_account->id}}</td>
                                                        <td>  {{$sub_account->name}} {{$sub_account->surname}}  </td>
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

                                        <div class="mobile-show">
                                            <div class="order-item ">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    @foreach($sub_accounts as $sub_account)
                                                        <tr>
                                                            <td>{!! __('table.customer_code') !!}</td>
                                                            <td>{{$sub_account->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.name_surname') !!}</td>
                                                            <td>{{$sub_account->name}} {{$sub_account->surname}}</td>
                                                        </tr>
                                                        @if($general_settings->referral_secret == 1)
                                                            <tr>
                                                                <td>{!! __('table.balance') !!}</td>
                                                                <td>${{$sub_account->balance}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{!! __('table.debt') !!}</td>
                                                                <td>${{$sub_account->debt}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{!! __('table.add_balance') !!}</td>
                                                                <td>
                                                                <span class="btn orange-button sub-account-order-btn"
                                                                      onclick="add_referal_balance({{$sub_account->id}});"><i
                                                                            class="fas fa-credit-card"></i> {!! __('buttons.add_balance_for_referral') !!}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{!! __('table.login_account') !!}</td>
                                                                <td>
                                                                <span data-confirm="{!! __('static.confirm_change_account') !!}"
                                                                      class="btn orange-button sub-account-order-btn"
                                                                      onclick="login_to_sub_account(this, '{{route("login_referal_account")}}', '{{$sub_account->id}}');">{!! __('buttons.login_referral_account') !!}</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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

@section('css')

@endsection

@section('js')

@endsection