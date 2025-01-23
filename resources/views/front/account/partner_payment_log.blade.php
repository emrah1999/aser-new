@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->
        <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="{{route("home_page")}}"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('account_menu.partner') !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- page content header -->
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text">
                        <h3> {!! __('account_menu.partner') !!} </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-block">
            <div class="container ">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')

                        <div class="page-content-right">
                            <div class="profile-tab-block">
                                <ul class="nav profile-tab-ul" role="tablist" style="margin-bottom: 10px;">
                                    <li><a href="{{route("get_payment_page")}}" class="active">{!! __('buttons.payment') !!}</a></li>
                                    <li><a href="{{route("get_payment_logs")}}">{!! __('buttons.payment_log') !!}</a></li>
                                </ul>
                                <div class="sub-panel for-subaccount user-payment-list">
                                    <div class="sub-table desktop-show">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th> {!! __('table.id') !!}</th>
                                                <th> {!! __('table.amount') !!}</th>
                                                <th> {!! __('table.date') !!}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php($count = 0)
                                            @foreach($logs as $log)
                                                @php($count++)
                                                <tr>
                                                    <td>{{$count}}</td>
                                                    <td>${{$log->amount}} ({{$log->amount_azn}} AZN)</td>
                                                    <td>
                                                        {{$log->created_at}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mobile-show">
                                        @php($count = 0)
                                        @foreach($logs as $log)
                                            @php($count++)
                                            <div class="order-item ">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>{!! __('table.id') !!}</td>
                                                        <td>{{$count}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!! __('table.amount') !!}</td>
                                                        <td>${{$log->amount}} ({{$log->amount_azn}} AZN)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!! __('table.date') !!}</td>
                                                        <td>
                                                            {{$log->created_at}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')

@endsection

@section('js')

@endsection