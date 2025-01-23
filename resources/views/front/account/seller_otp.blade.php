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
                                    <h1>{!! __('OTP') !!}</h1>

                                </div>



                                <div class="orange-spinner order-list-table">
                                    <div class="order-btn">
                                        <a href="{{route("get_seller_add")}}"
                                           class="btn btn-orange btn-success"
                                           style="background-color: rgba(16, 69, 140, 1); border-color: rgba(16, 69, 140, 1); float: right; margin: 8px 5px 5px 0;">{!! __('buttons.create_otp') !!}</a>
                                    </div>
                                    @if(count($sellerOtps) > 0)
                                        <div class="n-order-table sp-order-table desktop-show">
                                            <table id="dataTable">
                                                <thead>
                                                <tr>
                                                    <th>Track</th>
                                                    <th>OTP</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sellerOtps as $order)

                                                    <tr class="order_{{$order->id}}">
                                                        <td title="{{$order->otp_text}}">{{$order->otp_text}}</td>
                                                        <td title="{{$order->otp_code}}">{{$order->otp_code}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div>
                                                {!! $sellerOtps->links(); !!}
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


@endsection

@section('css')
    <style>
        .page-content-right .n-order-table.n-order-table table td {
            padding: 15px !important;
            border-right: 1px solid #dddddd;
            border-bottom: 1px solid #dddddd;
        }

    </style>
@endsection

@section('js')

@endsection
