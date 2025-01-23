@extends('web.layouts.web')
@section('content')

    <div class="content" id="content">
        <section class="section section-profile-curiers">
            <div class="container-lg">
                <div class="row">
                    @include("web.account.account_left_bar")
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                        <div class="thumbnail thumbnail-profile-title-block d-flex justify-content-between align-items-center">
                            <h4 class="thumbnail-profile-title-block__title font-n-b">Kuryer sifarişim</h4>
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{route('get_create_courier_page', ['locale' => App::getLocale()])}}" class="btn btn-blue thumbnail-profile-title-block__btn d-flex justify-content-center align-items-center font-n-b">
                                    <img class="thumbnail-profile-title-block__btn-img" src="/web/images/content/other-plus-3.png" alt="Add">
                                    <span class="thumbnail-profile-title-block__btn-title d-none d-lg-block">Yeni kuryer sifariş et</span>
                                </a>
                            </div>
                        </div>
                        <div class="thumbnail thumbnail-data">
                            <form class="form form-profile-curiers" name="formProfileCurier" id="formProfileCurier" method="post" action="" novalidate="novalidate">
                                <div class="table-responsive">
                                    <table class="table table-data">
                                        <thead>
                                        <tr class="table-data__thead-tr">
                                            <th class="table-data__thead-th">{!! __('courier.address') !!}</th>
                                            <th class="table-data__thead-th">{!! __('courier.date') !!}</th>
                                            <th class="table-data__thead-th">{!! __('courier.payment_type') !!}</th>
                                            <th class="table-data__thead-th">{!! __('courier.courier_payment') !!}</th>
                                            <th class="table-data__thead-th">{!! __('courier.total_payment') !!}</th>
                                            <th class="table-data__thead-th">{!! __('courier.status') !!}</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            @php($address = $order->address)
                                            @php($azerpost = $order->is_send_azerpost == true ? $order->azerpost_track : "")
                                            @if(strlen($address) > 15)
                                                @php($address = substr($address, 0, 12) . '...')
                                            @endif
                                            @if(strlen($order->area) > 15)
                                                @php($area_name = substr($order->area, 0, 12) . '...')
                                            @else
                                                @php($area_name = $order->area)
                                            @endif
                                            @if(strlen($order->metro_station) > 15)
                                                @php($metro_station_name = substr($order->metro_station, 0, 12) . '...')
                                            @else
                                                @php($metro_station_name = $order->metro_station)
                                            @endif
                                            <tr class="table-data__tbody-tr order_{{$order->id}}">
                                                <td class="table-data__tbody-td">{{$address}}</td>
                                                <td class="table-data__tbody-td">{{date('d.m.Y', strtotime($order->date))}}</td>
                                                <td class="table-data__tbody-td">{{$order->payment_type}}</td>
                                                <td class="table-data__tbody-td">{{$order->amount}} AZN</td>
                                                <td class="table-data__tbody-td">
                                                    <p>{{$order->total_amount}} AZN</p>
                                                    <p>{{$order->amount}} + {{$order->delivery_amount}}</p>
                                                </td>
                                                <td class="table-data__tbody-td">
                                                    {{$order->status}}
                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection