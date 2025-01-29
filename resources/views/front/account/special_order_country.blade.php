@extends('web.layouts.web')
@section('content')
    <section class="content-page-section">
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text account-index-top">

                        @include("front.account.country_select_bar")

                        <div class="campaign hidden"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-block">
            <div class="container-fluid page_containers">
                <div class="row">
                    @include('web.account.account_left_bar')

                    <div class="thumbnail thumbnail-data">
                        <div class="table-responsive">
                            @if(count($packages) > 0)
                                <table class="table table-data">
                                    <thead>
                                    <tr class="table-data__thead-tr">
                                        <th class="table-data__thead-th">
                                            <label class="form-checkbox form-checkbox-all d-flex justify-content-start align-items-center">
                                                <input class="form-checkbox__input" type="checkbox" id="selectRowsCheckbox">
                                                <span class="form-checkbox__span"></span>
                                                <span class="form-checkbox__text"></span>
                                            </label>
                                        </th>
                                        <th class="table-data__thead-th">{!! __('table.flight') !!}</th>
                                        <th class="table-data__thead-th">{!! __('table.tracking') !!}</th>
                                        <th class="table-data__thead-th">{!! __('table.weight') !!}</th>
                                        <th class="table-data__thead-th">{!! __('table.delivery_amount') !!}</th>
                                        {{--                                            <th class="table-data__thead-th">{!! __('table.debt') !!}</th>--}}
                                        <th class="table-data__thead-th">Filial</th>
                                        <th class="table-data__thead-th">{!! __('table.invoice_status') !!}</th>
                                        <th class="table-data__thead-th">{!! __('table.status') !!}</th>
                                        <th class="table-data__thead-th">{!! __('table.pay') !!}</th>
                                        <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($packages as $index => $package)
                                        @if($package->chargeable_weight == 1)
                                            @php($package_weight = $package->gross_weight)
                                        @else
                                            @php($package_weight = $package->volume_weight)
                                        @endif
                                        <tr class="table-data__tbody-tr order_package_{{$package->id}}" id="{{$package->id}}" aria-status="{{$package->paid_status}}">
                                            <td class="table-data__tbody-td" id="{{$package->id}}" aria-status="{{$package->paid_status}}">
                                                <label class="form-checkbox d-flex justify-content-start align-items-center" for="checkbox-{{$package->id}}"
                                                       style="position: relative; z-index: 1; cursor: pointer; display: flex; align-items: center;">
                                                    <input id="checkbox-{{$package->id}}" class="form-checkbox__input" type="checkbox"
                                                           style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                                    <span class="form-checkbox__span"
                                                          style="width: 20px; height: 20px; border: 1px solid #000; display: inline-block; position: relative;"></span>
                                                    <span class="form-checkbox__text"></span>
                                                </label>
                                            </td>

                                            <td class="table-data__tbody-td">
                                                @if(isset($package->flight))
                                                    {{$package->flight}}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td class="table-data__tbody-td">
                                                <div>{{ $package->track }}</div>
                                                <div>{{ $package->internal_id }}</div>
                                            </td>

                                            <td class="table-data__tbody-td">
                                                @if($package_weight > 0)
                                                    {{$package_weight}} {{$package->unit}}

                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="table-data__tbody-td">
                                                @if($package->amount > 0)
                                                    {{$package->cur_icon}} {{$package->amount}}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            {{--                                                <td class="table-data__tbody-td">--}}
                                            {{--                                                    @if(($package->external_w_debt > 0 || $package->external_w_debt != null) && ($package->internal_w_debt > 0 || $package->internal_w_debt != null))--}}
                                            {{--                                                        <p>$ {{$package->external_w_debt}} </p>--}}
                                            {{--                                                        <p>₼ {{$package->internal_w_debt}}</p>--}}
                                            {{--                                                    @elseif($package->external_w_debt > 0 || $package->external_w_debt != null)--}}
                                            {{--                                                        $ {{$package->external_w_debt}}--}}
                                            {{--                                                    @elseif($package->internal_w_debt > 0 || $package->internal_w_debt != null)--}}
                                            {{--                                                        ₼ {{$package->internal_w_debt}}--}}
                                            {{--                                                    @else--}}
                                            {{--                                                        ---}}
                                            {{--                                                    @endif--}}
                                            {{--                                                </td>--}}
                                            <td class="table-data__tbody-td">
                                                {{$package->branch_name}}
                                            </td>
                                            <td class="table-data__tbody-td">
                                                @if($package->last_status_id == 7)
                                                    <p style="color: red;" aria-placeholder="Qadağan edilən bağlama"></p>
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
                                                @if($package->last_status_id == 7)
                                                    <a href="#" style="display: none" target="_blank" class="fas fa-eye" placeholder="Prohibet not update">
                                                    </a>
                                                @else
                                                    @if($package->invoice_status == 4)
                                                        <a href="{{ $package->invoice_doc }}" target="_blank" class="fas fa-eye">
                                                            {!! __('table.show_invoice_file') !!}
                                                        </a>

                                                    @elseif($package->invoice_status == 1)
                                                        <a href="{{route('get_package_update', ['locale' => App::getLocale(), $package->id])}}" class="fas fa-upload" style="color: red;">
                                                            {!! __('table.upload_invoice_file') !!}
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>

                                            <td class="table-data__tbody-td">
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
                                                                <p class="order-status-changed"><span>{{$package->last_status_date ==null ? '-' : date('d.m.Y H:i', strtotime($package->last_status_date))}}</span></p>
                                                            </span>
                                            </td>
                                            <td class="table-data__tbody-td">
                                                @if($package->paid_status == 1)
                                                    <button type="button" disabled class="btn btn-paid"
                                                            style="cursor: not-allowed !important;">{!! __('static.paid') !!}
                                                    </button>
                                                @else
                                                    @if($package->amount > 0)
                                                        <button
                                                                type="button" class="btn btn-yellow"
                                                                data-has-courier="{{$package->has_courier}}"
                                                                data-has-courier-message="{!! __('static.packages_has_courier_message') !!}"
                                                                data-balance="{{Auth::user()->balance()}}"
                                                                data-balance-message="{!! __('static.packages_balance_message') !!}"
                                                                data-amount="{{sprintf('%0.2f', $package->amount_usd - $package->paid)}}"
                                                                data-confirm="{!! __('static.confirm_pay') !!}"
                                                                onclick="paid_package_new(this, '{{route("pay_order", ['locale' => App::getLocale(), $package->id])}}');">
                                                            {!! __('buttons.pay') !!}
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </td>
                                            {{--                                                <td class="order-info-link" style="text-align: center;">--}}
                                            <td class="order-info-link" style="vertical-align: middle; text-align: center; width: 50px;">
                                                    <span
                                                            onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route('get_package_items', ['locale' => app()->getLocale()])}}');"
                                                            class="order-view"
                                                            style="display: inline-flex; align-items: center; justify-content: center; height: 100%; width: 100%; cursor: pointer;">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                            </td>


                                            </td>

                                        </tr>


                                    @endforeach



                                    </tbody>
                                </table>
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
    </section>
@endsection


@section('styles')
<style>
    .left-bar-new-style{
        margin-top: -113px;
    }
   /* Genel layout ve container ayarları */
   .page-content-block {
       padding: 20px 90px; /* Sol, sağ 90px, üst 20px boşluk */
   }

   .page-content-part {
       display: flex;
   }

   .page-content-right {
       flex-grow: 1;
       background-color: #fff7e6;
       padding: 20px;
       border-radius: 8px;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       height: 20%;
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
       margin-bottom: 20px; /* Her ülke bloğu arasına boşluk bırak */
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
       max-width: 100%;
       height: auto;
       border-radius: 50%;
       margin-right: 15px; /* Bayrak ile ülke adı arasında boşluk bırak */
   }

   .country-name {
       font-weight: bold;
       color: #333;
       white-space: nowrap; /* Metnin taşmasını engelle */
       text-overflow: ellipsis;
       overflow: hidden;
       max-width: 150px; /* Genişliği ayarla */
   }

   /* Uyarı mesajı */
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

   /* Mobil uyumluluk */
   @media (max-width: 768px) {
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



</style>

@endsection

@section('scripts')
    @if(Request::get('approve-referral') == 'OK')
        <script>
            let swal_case = '{{Request::get('case')}}';
            let swal_message = '{{Request::get('message')}}';

            swal(
                'Referral account',
                swal_message,
                swal_case
            );
        </script>
    @endif

    @if(session('special_orders_active') == 'false')
        <script>
            let swal_message = '{{session('message')}}';
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
