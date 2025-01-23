@extends('front.app')
@section('content')
    <section class="content-page-section">

        <div class="page-content-block">
            <div class="container ">
                <div class="row">
                    <div class="page-content-part campaign-content-part">
                        @include("front.account.account_left_bar")
                        <div class="page-content-right">

                            <div class="n-order-list">

                                <div class="n-order-top flex space-between">
                                    <h1 class="n-order-title tr">{!! __('static.update_order_title') !!}:
                                        #{{$group->id}}</h1>
                                </div>


                                <div class="orange-spinner order-list-table">

                                    <form id="special_order_update_form" class="clearfix update-special-order-form"
                                          action="{{route("update_special_order", [$country_id, $group->id])}}"
                                          method="post">
                                        @csrf
                                        @foreach($orders as $order)
                                            <div class="n-order-product-main">
                                                <div class="col-12 table_wrap">
                                                    <table class="table  n-order-product-table desktop-show customCss">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{!! __('table.url') !!}</th>
                                                            <th>{!! __('table.quantity_for_special_order') !!}</th>
                                                            <th>{!! __('table.price_for_special_order_one') !!}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>{{$order->id}}</td>
                                                            <td>
                                                                <a href="{{$order->url}}"
                                                                   target="_blank">{{$order->url}}</a>
                                                            </td>
                                                            <td>{{$order->quantity}}</td>
                                                            <td>{{$order->price}}  {{$group->currency}} </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table  mobile-show">
                                                        <tbody>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>{{$order->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.url') !!}</td>
                                                            <td>
                                                                <a href="{{$order->url}}"
                                                                   target="_blank">{{$order->url}}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.quantity_for_special_order') !!}</td>
                                                            <td>{{$order->quantity}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.price_for_special_order_one') !!}</td>
                                                            <td>{{$order->price}}  {{$group->currency}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>



                                                <div class="row n-form-element clearfix update-special-order-form_shadow">
                                                    <input type="hidden" name="order_id[]" value="{{$order->id}}">
                                                    <div class="col-md-5 col-xs-12 n-margin">
                                                        <div class="input_custom input-effect">
                                                            <input value="{{$order->color}}" class="effect-20 has-content" type="text" placeholder="" name="color[]">
                                                            <label>M{!! __('labels.color') !!}</label>
                                                            <span class="focus-border"><i></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 col-xs-12 n-margin">
                                                        <div class="input_custom input-effect">
                                                            <input value="{{$order->size}}" class="effect-20 has-content" type="text" placeholder="" name="size[]">
                                                            <label>{!! __('labels.size') !!}</label>
                                                            <span class="focus-border"><i></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="n-order-product-detail">
                                                    <!-- <label>Məhsul detalları</label> -->
                                                    <div class="input_custom input-effect">
                                                        <textarea value="{{$order->size}}" class="effect-20 has-content" name="description[]">{{$order->description}}</textarea>
                                                        <label>{!! __('labels.description') !!}</label>
                                                        <span class="focus-border"><i></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="row n-form-element">
                                            <div class="col-md-12 align-left">
                                                <button type="submit" class="btn btn-n-order"><i
                                                            class="fas fa-pencil-alt"></i> {!! __('buttons.update') !!}
                                                </button>
                                            </div>
                                        </div>

                                    </form>
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
        .table_wrap{
            border-radius: 0;
            margin-bottom: 0;
            padding: 20px 40px 20px 40px;
            box-shadow: none !important;
        }

        .customCss{
            padding: 2% 1% !important;
        }
        .update-special-order-form .n-form-element {
            padding: 20px 40px 20px 40px;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .n-order-product-detail {
            margin-top: 10px;
            padding: 30px;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
    </style>

@endsection

@section('js')

@endsection