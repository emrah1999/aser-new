@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->

        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')

                        <div class="page-content-right">
                            <div class="profile-tab-block">
                                <ul class="nav profile-tab-ul" role="tablist" style="margin-bottom: 10px;">
                                    <li><a href="{{route("get_balance_page")}}">{!! __('buttons.add_balance') !!}</a>
                                    </li>
                                    <li><a href="{{route("get_balance_logs")}}" class="active">{!! __('buttons.balance_log') !!}</a></li>
                                </ul>
                                <div class="sub-panel for-subaccount user-payment-list">
                                    <div class="sub-table desktop-show">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th> {!! __('table.id') !!}</th>
                                                <th> {!! __('table.amount') !!}</th>
                                                <th> {!! __('table.payment_type') !!}</th>
                                                <th> {!! __('table.payment_type2') !!}</th>
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
                                                        @if($log->type == 'cart')
                                                            {!! __('static.cart') !!}
                                                        @elseif($log->type == 'cash')
                                                            {!! __('static.cash') !!}
                                                        @else
                                                            {!! __('static.from_balance') !!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($log->status == 'in')
                                                            {!! __('static.added_balance') !!}
                                                        @elseif($log->status == 'out')
                                                            {!! __('static.removed_balance') !!}
                                                        @endif
                                                    </td>
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
                                                        <td>{!! __('table.payment_type') !!}</td>
                                                        <td>
                                                            @if($log->type == 'cart')
                                                                {!! __('static.cart') !!}
                                                            @elseif($log->type == 'cash')
                                                                {!! __('static.cash') !!}
                                                            @else
                                                                {!! __('static.from_balance') !!}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{!! __('table.payment_type2') !!}</td>
                                                        <td>
                                                            @if($log->status == 'in')
                                                                {!! __('static.added_balance') !!}
                                                            @elseif($log->status == 'out')
                                                                {!! __('static.removed_balance') !!}
                                                            @endif
                                                        </td>
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