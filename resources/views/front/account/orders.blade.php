@extends('front.app')
@section('content')
    <input type="hidden" name="package_ids" id="package_ids" value="">

    <section class="content-page-section">
        <div class="page-content-block">
            <div class="container-fluid page_containers">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')


                        <div class="page-content-right">
                            <div class="n-order-list custom_orders_desktop desktop-show">
                                <div class="n-order-top flex space-between order-top-block">
                                    
                                    <button style="background-color: rgba(16, 69, 140, 1); color: white"
                                                type="button" class="btn btn-paid" id="payBtn" disabled
                                                data-balance-message="{!! __('static.packages_balance_message') !!}"
                                                data-confirm="{!! __('static.confirm_pay') !!}"
                                                onclick="bulk_paid_package(this, '{{route("bulk_pay")}}')">{!! __('buttons.pay_all') !!}
                                    </button>

                                </div>
                            
                                  
                                <div class="n-order-bottom ">
                                    <div class="n-order-bottom-pad status_bar">
                                        <div class="n-order-status ">
                                            <ul class="custom_orders_status">
                                                <li>
                                                    <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=3'}}"
                                                       id="status_3">
                                                        {!! __('static.in_warehouse_status') !!} <span>{{$counts['is_warehouse']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=4'}}"
                                                       id="status_4">
                                                        {!! __('static.sent_status') !!} <span>{{$counts['sent']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=5'}}"
                                                       id="status_5">
                                                        {!! __('static.in_baku_status') !!} <span>{{$counts['in_office']}}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=6'}}"
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
                                                <thead id="thead_table">
                                                <tr>
                                                    <th>
                                                        <label for="selectRowsCheckbox">
                                                            <input style="display: block !important; appearance: auto;" type="checkbox" id="selectRowsCheckbox">
                                                        </label>
                                                    </th>
                                                    <th class="text-upper">{!! __('table.flight') !!}</th>
                                                    <th class="text-upper">{!! __('table.tracking') !!}</th>
                                                    {{-- <th class="text-upper">{!! __('table.customs_tracking_text') !!}</th> --}}
                                                    <th>{!! __('table.weight') !!}</th>
                                                    <th>{!! __('table.delivery_amount') !!}</th>
                                                    
                                                    <th>{!! __('table.debt') !!}</th>
                                                    <th>Filial</th>
                                                    <th>{!! __('table.invoice_status') !!}</th>
                                                    <th>{!! __('table.status') !!}</th>
                                                    <th>{!! __('table.pay') !!}</th>
                                                    <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbodyWeb">
                                                @foreach($packages as $index => $package)
                                                    @if($package->chargeable_weight == 1)
                                                        @php($package_weight = $package->gross_weight)
                                                    @else
                                                        @php($package_weight = $package->volume_weight)
                                                    @endif
                                                    <tr class="order_package_{{$package->id}}" id="{{$package->id}}" aria-status="{{$package->paid_status}}">
                                                        <td style="padding-left: 12px!important;" id="{{$package->id}}" aria-status="{{$package->paid_status}}">
                                                            <label >
                                                                <input style="display: block !important; appearance: auto; padding-left: 12px!important;" type="checkbox">
                                                            </label>
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
                                                            <p>{{ $package->internal_id }}</p>
                                                            {{-- <p>
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
                                                            </p> --}}
                                                        </td>
                                                        {{-- <td class="strong-p">
                                                            @if(isset($package->internal_id))
                                                                {{ $package->internal_id }}
                                                            @else
                                                                ---
                                                            @endif
                                                        </td> --}}
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
                                                        <td class="strong-p">
                                                            @if(($package->external_w_debt > 0 || $package->external_w_debt != null) && ($package->internal_w_debt > 0 || $package->internal_w_debt != null))
                                                                <p>$ {{$package->external_w_debt}} </p>
                                                                <p>₼ {{$package->internal_w_debt}}</p>
                                                            @elseif($package->external_w_debt > 0 || $package->external_w_debt != null)
                                                                $ {{$package->external_w_debt}}
                                                            @elseif($package->internal_w_debt > 0 || $package->internal_w_debt != null)
                                                                ₼ {{$package->internal_w_debt}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="strong-p">
                                                                {{$package->branch_name}}
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
                                                            @if($package->last_status_id == 38)
                                                                <span class="btn btn-sm btn-info"
                                                                      data-toggle="collapse"
                                                                      href="#duty_not_paid">i</span>
                                                                <div class="collapse" id="duty_not_paid">
                                                                     <span class="card card-body">
                                                                        {!! __('status.duty_not_paid') !!}
                                                                     </span>
                                                                </div>
                                                            @elseif($package->last_status_id == 39)
                                                                <span class="btn btn-sm btn-info"
                                                                      data-toggle="collapse"
                                                                      href="#duty_paid">i</span>
                                                                <div class="collapse" id="duty_paid">
                                                                     <span class="card card-body">
                                                                        {!! __('status.duty_paid') !!}
                                                                     </span>
                                                                </div>
                                                            @endif
                                                            <span class="order-status">
                                                                {{$package->status}}
                                                                <p class="order-status-changed"><span>{{date('d.m.Y H:i', strtotime($package->last_status_date))}}</span></p>
                                                            </span>
                                                        </td>
                                                        <td class="order-payment">
                                                            @if($package->paid_status == 1)
                                                                <button type="button" disabled class="btn btn-paid"
                                                                        style="cursor: not-allowed !important;">{!! __('static.paid') !!}
                                                                </button>
                                                            @else
                                                                @if($package->amount > 0)
                                                                    <button style="background-color: #f4a51c;"
                                                                            type="button" class="btn btn-paid"
                                                                            data-has-courier="{{$package->has_courier}}"
                                                                            data-has-courier-message="{!! __('static.packages_has_courier_message') !!}"
                                                                            data-balance="{{Auth::user()->balance()}}"
                                                                            data-balance-message="{!! __('static.packages_balance_message') !!}"
                                                                            data-amount="{{sprintf('%0.2f', $package->amount_usd - $package->paid)}}"
                                                                            data-confirm="{!! __('static.confirm_pay') !!}"
                                                                            onclick="paid_package(this, '{{route("pay_order", $package->id)}}');">
                                                                        {!! __('buttons.pay') !!}
                                                                    </button>
                                                                @else
                                                                    -
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="order-op" style="padding: 0px 9px !important;">
                                                            <span
                                                                    onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route("get_package_items")}}');"
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

                            <div class="mobile-show custom_orders_mobile">
                               
                                <div class="n-order-status">
                                    <ul class="custom_orders_status" style="padding: 1rem;">
                                        <li>
                                            <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=3'}}"
                                                id="status_3">
                                                {!! __('static.in_warehouse_status') !!} <span>{{$counts['is_warehouse']}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=4'}}"
                                                id="status_4">
                                                {!! __('static.sent_status') !!} <span>{{$counts['sent']}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=5'}}"
                                                id="status_5">
                                                {!! __('static.in_baku_status') !!} <span>{{$counts['in_office']}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route("get_orders") . '?country=' . $search['country'] . '&status=6'}}"
                                                id="status_6">
                                                {!! __('static.archive_status') !!} <span>{{$counts['delivered']}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                @if(count($packages) > 0)
                                    <div class="order-item" style="padding: 1rem;">
                                            @foreach($packages as $index => $package)
                                                <table class="table table-bordered mobil_table_border">
                                                    <tbody>
                                                        @if($package->chargeable_weight == 1)
                                                            @php($package_weight = $package->gross_weight)
                                                        @else
                                                            @php($package_weight = $package->volume_weight)
                                                        @endif
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
                                                            <td>{{ !! __('table.customs_tracking_text') }}</td>
                                                            <td>
                                                                @if(isset($package->internal_id))
                                                                    {{ $package->internal_id }}
                                                                @else
                                                                    ---
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
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
                                                        </tr> --}}
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
                                                        <tr>
                                                            <td>{!! __('table.debt') !!}</td>
                                                            <td class="strong-p">
                                                                @if(($package->external_w_debt > 0 || $package->external_w_debt != null) && ($package->internal_w_debt > 0 || $package->internal_w_debt != null))
                                                                    <p>$ {{$package->external_w_debt}} </p>
                                                                    <p>₼ {{$package->internal_w_debt}}</p>
                                                                @elseif($package->external_w_debt > 0 || $package->external_w_debt != null)
                                                                    $ {{$package->external_w_debt}}
                                                                @elseif($package->internal_w_debt > 0 || $package->internal_w_debt != null)
                                                                    ₼ {{$package->internal_w_debt}}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Filial</td>
                                                            <td>
                                                               
                                                                    {{$package->branch_name}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.invoice_status') !!}</td>
                                                            <td>
                                                            <span class="invoiceStatus">
                                                                        @if($package->last_status_id == 7)
                                                                            <p style="color: red;">{!! 'Qadağan edilən bağlamalara invoys yüklənə bilməz' !!}</p>
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
                                                                            <a href="#" style="display: none" target="_blank" class="fas fa-eye">
                                                                                
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
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.description') !!}</td>
                                                            <td>
                                                                @isset($package->description)
                                                                    {{ $package->description }}
                                                                @else
                                                                    -
                                                                @endisset
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
                                                            @if($package->amount > 0)
                                                                <td> {{$package->cur_icon}} {{$package->amount}}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.pay') !!}</td>
                                                            <td class="order-payment">
                                                                @if($package->paid_status == 1)
                                                                    <button type="button" disabled class="btn btn-paid"
                                                                            style="cursor: not-allowed !important;">{!! __('static.paid') !!}
                                                                    </button>
                                                                @else
                                                                    @if($package->amount > 0)
                                                                        <button style="background-color: #f4a51c;"
                                                                                type="button" class="btn btn-paid"
                                                                                data-has-courier="{{$package->has_courier}}"
                                                                                data-has-courier-message="{!! __('static.packages_has_courier_message') !!}"
                                                                                data-balance="{{Auth::user()->balance()}}"
                                                                                data-balance-message="{!! __('static.packages_balance_message') !!}"
                                                                                data-amount="{{sprintf('%0.2f', $package->amount_usd - $package->paid)}}"
                                                                                data-confirm="{!! __('static.confirm_pay') !!}"
                                                                                onclick="paid_package(this, '{{route("pay_order", $package->id)}}');">
                                                                            {!! __('buttons.pay') !!}
                                                                        </button>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                @endif
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('table.look') !!}</td>
                                                            <td class="order-info-link">
                                                                <span
                                                                        onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route("get_package_items")}}');"
                                                                        class="order-view"><i class="fas fa-eye"></i></span>
                                                            </td>
                                                        </tr>
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
                                <th>{!! __('menu.sellers') !!}</th>
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

    <!-- Send All Package Modal -->
    <div class="modal fade" id="sendAppModal" style="padding-right: 0 !important;" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('send_legality')}}" method="post">
                @csrf
                    <div class="modal-body">
                        Bütün paketlərin göndərilməyini istəyirsinizmi?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Bəli</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Xeyr</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>
        .last-month-swal{
            width: 70% !important;
        }
        .n-order-bottom{
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;
            overflow-y: hidden;
            position: relative;
            width: 100%;
        }

        .n-order-bottom::-webkit-scrollbar {
            display: none;  /* Safari and Chrome */
        }

        /* .modal-open {
            overflow: auto;
            padding-right: 0 !important;
        } */

        .selected {
            background-color: #203f2d;
        }

        .button-selected {
            background-color: #2cb76b !important;
        }

        .button-deselected {
            background-color: #f4a51c !important;
        }

        .n-order-table table th {
            font-size: 14px !important;
            padding: 10px !important;
        }

        .n-order-table.n-order-table table td {
            padding: 1px!important;
            font-size: 10px!important;
        }



        .n-order-table::-webkit-scrollbar {
           width: 5px;
           background-color: #fdfaf6;
        }

        .n-order-table::-webkit-scrollbar-thumb {
            width: 1px;
            border-radius: 2px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #fdfaf6;
        }

        /*.page-content-right .n-order-table.n-order-table table td {
            padding: 1px!important;
            font-size: 10px!important;
        }*/

       /* .order-payment button {
            background: #f4a51c;
            color: #fff;
            padding: 4px 6px !important;
            text-transform: capitalize;
            font-size: 12px !important;
        }*/

        /* .page-content-part {
            justify-content: space-evenly !important;
        } */

        .page-content-right .n-order-table.n-order-table table td {
            padding: 1px!important;
            font-size: 14px!important;
        }

        #thead_table{
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .status_bar{
            padding: 0px 33px 68px 33px !important;
        }

        .mobil_table_border{
            margin-bottom: 19px;
            box-shadow: -5px 5px 28px 5px rgba(0, 0, 0, 0.14);
        }

        @media (min-width: 768px) and (max-width: 1250px) {
            .n-order-table {
                overflow: scroll;
                height: 465px
            }
        }

        @media (min-width: 1220px) {
            .n-order-table {
                overflow-x: hidden;
                overflow-y: scroll;
                height: 465px
            }
        }
    </style>
@endsection

@section('js')
    <script>

        var tableRows = document.querySelectorAll('tbody tr');
        var packageIds = [];
        var packageIdsInput = document.getElementById('package_ids');

        var selectRowsButton = document.getElementById('selectRowsButton');
        var isSelected = false;

        var selectSingleRowCheckbox = document.querySelectorAll('tbody tr td label input');
        var selectRowsCheckbox = document.getElementById('selectRowsCheckbox');
        var payBtn = document.getElementById('payBtn');

        $(document).ready(function () {
            let current_status = '{{$search['status']}}';
            $("#status_" + current_status).addClass('active');

            $(".mobile_status_select_options").removeAttr('selected');
            $("#mobile_status_select_" + current_status).attr('selected', true);

            $("#tbodyWeb tr").slice(12).hide();
            var mincount = 10;
            var maxcount = 20;

            $(".n-order-table").scroll(function () {
                var scrollHeight = $(".n-order-table")[0].scrollHeight;
                var scrollTop = $(".n-order-table").scrollTop();
                var containerHeight = $(".n-order-table").outerHeight();

                if (scrollTop + containerHeight >= scrollHeight - 50) {
                    $("tbody tr").slice(mincount, maxcount).slideDownSlow(600);

                    mincount = mincount + 10;
                    maxcount = maxcount + 10;
                }
            });

            $.fn.fadeInSlow = function (duration) {
                $(this).css("display", "none").fadeIn(duration);
            };

            $.fn.slideDownSlow = function (duration) {
                $(this).css({ marginTop: "20px", opacity: 0 }).slideDown(duration).animate({ marginTop: 0, opacity: 1 });
            };

        });

        @if($last30 == 'active')
            swal({
                title: '{!! __('static.attention') !!}!',
                html: '{!! __('static.last_30_days_text') !!}',
                type: "info",
                customClass: 'last-month-swal',
                showCancelButton: false,
                showConfirmButton:true
            });
        @endif

        var rowsCheck = false;
        tableRows.forEach(function(row) {
            selectSingleRowCheckbox.forEach(function(checkbox) {
                var checkTable = checkbox.closest('tr')
                var status = checkTable.getAttribute('aria-status');

                if (status == 0) {
                    checkbox.checked = false;

                } else {
                    checkbox.disabled = true;
                }
            });
            row.addEventListener('click', function() {
                if (isSelected === false && status == 0) {
                    payBtn.disabled = false;
                }else {
                    if (packageIds.length > 0) {
                        payBtn.disabled = false;
                    }else {
                        payBtn.disabled = true;
                    }

                }

                var checkbox = this.querySelector('td label input');
                var status = this.getAttribute('aria-status');
                //console.log(rowsCheck);
                if (status === '0') {
                    var packageId = this.getAttribute('id');
                    if (packageId) {
                        var index = packageIds.indexOf(packageId);

                        if (index !== -1) {
                            //this.classList.remove('selected');
                            packageIds.splice(index, 1);
                            checkbox.checked = false;
                           // console.log(packageIds.length)
                            if (packageIds.length === 0) {
                                payBtn.disabled = true;
                                selectRowsCheckbox.checked = false
                            }else {
                                payBtn.disabled = false;
                            }
                        } else {
                            if(status == 0){
                                packageIds.push(packageId);
                                checkbox.checked = true;
                                //payBtn.disabled = false;
                                if (packageIds.length > 0) {
                                    payBtn.disabled = false;
                                }
                            }

                        }


                        packageIdsInput.value = JSON.stringify(packageIds);
                        // console.log('Gönderilen package_ids:', packageIds);
                    }
                }
            });
        });

        selectRowsCheckbox.addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('tbody tr[aria-status="0"] td label input');

            checkboxes.forEach(function(checkbox) {
                var tableRow = checkbox.closest('tr');
                var packageId = tableRow.getAttribute('id');

                if (selectRowsCheckbox.checked) {
                    checkbox.checked = true;

                    if (!packageIds.includes(packageId)) {
                        packageIds.push(packageId);
                    }
                    payBtn.disabled = false;
                    isSelected = true;
                } else {
                    checkbox.checked = false;

                    var index = packageIds.indexOf(packageId);
                    if (index !== -1) {
                        packageIds.splice(index, 1);
                    }
                    payBtn.disabled = true;
                    isSelected = true;

                }
            });

            packageIdsInput.value = JSON.stringify(packageIds);
            //console.log('Gönderilen package_ids:', packageIds);
        });


    </script>
@endsection
