@extends('web.layouts.web')
@section('content')
    <input type="hidden" name="package_ids" id="package_ids" value="">
    <div class="content" id="content">
        <section class="section section-profile-addresses">
            <div class="container-lg">
                <div class="row">
                    @include('web.account.account_left_bar')
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                        <div class="thumbnail thumbnail-profile-title-block packages-boxes d-flex justify-content-between align-items-center row">
                            <div class="col-md-3">
                                <h4 class="thumbnail-profile-title-block__title font-n-b">{!! __('static.package3') !!}</h4>
                            </div>
                            <div class="dropdown-container dropdown-container3 d-none d-lg-block col-md-5 col-6">
                                <label for="dropdown-toggle3" class="dropdown-label dropdown-label-1 float-right" id="dropdown-label-package">

                                    @if($currentStatus==3)
                                        {!! __('static.external_warehouse') !!}
                                    @elseif($currentStatus==4)
                                        {!! __('static.send_warehouse') !!}
                                    @elseif($currentStatus==5)
                                        {!! __('static.in_baku') !!}
                                    @elseif($currentStatus==6)
                                        {!! __('static.arceve') !!}

                                    @endif
                                    <span class="dropdown-icon"></span>
                                </label>
                                <input type="checkbox" id="dropdown-toggle3" class="dropdown-checkbox" />
                                <ul class="dropdown-menu package-dropdown">
                                    @php
                                        $statuses = [
                                            // ['key' => 'total', 'text' => 'Bütün bağlamalarım', 'status' => 0],
                                             ['key' => 'is_warehouse', 'text' => __('static.external_warehouse'), 'status' => 3],
                                             ['key' => 'sent', 'text' => __('static.send_warehouse') , 'status' => 4],
                                             ['key' => 'in_office', 'text' => __('static.in_baku'), 'status' => 5],
                                             ['key' => 'delivered', 'text' => __('static.arceve'), 'status' => 6],
                                         ];
                                    @endphp

                                    @foreach ($statuses as $status)
                                        <li class="bar-padding">
                                            <a class="bar-margin d-flex justify-content-between align-items-center"
                                               href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=' . $status['status'] }}"
                                               data-status="{{ $status['status'] }}">
                                                <span>{{ $status['text'] }}</span>
                                                <span class="badge badge-secondary count-badge">{{ $counts[$status['key']] ?? 0 }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>


                            </div>

                            <div class="d-flex justify-content-center align-items-center col-md-3 col-6 d-none d-lg-block">
                                <button
                                        type="button" class="btn btn-yellow thumbnail-profile-title-block__btn d-flex justify-content-center align-items-center font-n-b float-right" id="payBtn" disabled
                                        data-balance-message="{!! __('static.packages_balance_message') !!}"
                                        data-confirm="{!! __('static.confirm_pay') !!}"
                                        onclick="bulk_paid_package_new(this, '{{route("bulk_pay", ['locale' => App::getLocale()])}}')">{!! __('buttons.pay_all') !!}
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center d-block d-lg-none mb-10">
                            <div class="dropdown-container dropdown-container2">
                                <label for="dropdown-toggle2" class="dropdown-label dropdown-label-1" id="dropdown-label-package1">
                                    @if($currentStatus==3)
                                        {!! __('static.external_warehouse') !!}
                                    @elseif($currentStatus==4)
                                        {!! __('static.send__warehouse') !!}
                                    @elseif($currentStatus==5)
                                        {!! __('static.in_baku') !!}
                                    @elseif($currentStatus==6)
                                        {!! __('static.arceve') !!}

                                    @endif
                                    <span class="dropdown-icon"></span>
                                </label>
                                <input type="checkbox" id="dropdown-toggle2" class="dropdown-checkbox" />
                                <ul class="dropdown-menu package-dropdown">
                                    @php
                                        $statuses = [
                                           // ['key' => 'total', 'text' => 'Bütün bağlamalarım', 'status' => 0],
                                            ['key' => 'is_warehouse', 'text' => __('static.external_warehouse'), 'status' => 3],
                                            ['key' => 'sent', 'text' => __('static.send__warehouse') , 'status' => 4],
                                            ['key' => 'in_office', 'text' => __('static.in_baku'), 'status' => 5],
                                            ['key' => 'delivered', 'text' => __('static.arceve'), 'status' => 6],
                                        ];
                                    @endphp

                                    @foreach ($statuses as $status)
                                        <li class="bar-padding">
                                            <a class="bar-margin d-flex justify-content-between align-items-center"
                                               href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=' . $status['status'] }}"
                                               data-status="{{ $status['status'] }}">
                                                <span>{{ $status['text'] }}</span>
                                                <span class="badge badge-secondary count-badge">{{ $counts[$status['key']] ?? 0 }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <button
                                        type="button" class="btn btn-yellow thumbnail-profile-title-block__btn d-flex justify-content-center align-items-center font-n-b" id="payBtn2" disabled
                                        data-balance-message="{!! __('static.packages_balance_message') !!}"
                                        data-confirm="{!! __('static.confirm_pay') !!}"
                                        onclick="bulk_paid_package_new(this, '{{route("bulk_pay", ['locale' => App::getLocale()])}}')">{!! __('buttons.pay_all') !!}
                                </button>
                            </div>
                        </div>
                        <div class="thumbnail thumbnail-data">
                            <div class="table-responsive d-none d-lg-block">
                                @if(count($packages) > 0)
                                    <table class="table table-data">
                                        <thead>
                                        <tr class="table-data__thead-tr">
                                            @if($currentStatus!=6)
                                                <th class="table-data__thead-th">
                                                    <label class="form-checkbox form-checkbox-all d-flex justify-content-start align-items-center">
                                                        <input class="form-checkbox__input" type="checkbox" id="selectRowsCheckbox">
                                                        <span class="form-checkbox__span"></span>
                                                        <span class="form-checkbox__text"></span>

                                                    </label>
                                                </th>
                                            @endif
                                            <th class="table-data__thead-th">{!! __('table.flight') !!}</th>
                                            <th class="table-data__thead-th">{!! __('table.tracking') !!}</th>
                                            <th class="table-data__thead-th">{!! __('table.weight') !!}</th>
                                            <th class="table-data__thead-th th-new">{!! __('table.delivery_amount') !!}</th>
                                            {{-- <th class="table-data__thead-th">{!! __('table.debt') !!}</th>--}}
                                            <th class="table-data__thead-th">{!! __('static.branch') !!}</th>
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
                                                @if($currentStatus!=6)
                                                    <td class="table-data__tbody-td" id="{{$package->id}}" aria-status="{{$package->paid_status}}">
                                                        <label class="form-checkbox d-flex justify-content-start align-items-center" for="checkbox-{{$package->id}}"
                                                               style="position: relative; z-index: 1; cursor: pointer; display: flex; align-items: center;">
                                                            <input id="checkbox-{{$package->id}}" class="form-checkbox__input" type="checkbox"
                                                                   style="position: relative; width: 20px; height: 20px; opacity: 1; cursor: pointer; z-index: 2;">
                                                            <span class="form-checkbox__span"
                                                                  style="width: 20px; height: 20px; border: 1px solid #000; display: inline-block; position: relative; margin-left: -20px;"></span>
                                                            <span class="form-checkbox__text"></span>
                                                        </label>
                                                    </td>
                                                @endif

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

                                                {{-- <td class="table-data__tbody-td">--}}
                                                {{-- @if(($package->external_w_debt > 0 || $package->external_w_debt != null) && ($package->internal_w_debt > 0 || $package->internal_w_debt != null))--}}
                                                {{-- <p>$ {{$package->external_w_debt}} </p>--}}
                                                {{-- <p>₼ {{$package->internal_w_debt}}</p>--}}
                                                {{-- @elseif($package->external_w_debt > 0 || $package->external_w_debt != null)--}}
                                                {{-- $ {{$package->external_w_debt}}--}}
                                                {{-- @elseif($package->internal_w_debt > 0 || $package->internal_w_debt != null)--}}
                                                {{-- ₼ {{$package->internal_w_debt}}--}}
                                                {{-- @else--}}
                                                {{-- ---}}
                                                {{-- @endif--}}
                                                {{-- </td>--}}
                                                <td class="table-data__tbody-td">
                                                    {{$package->branch_name}}
                                                </td>
                                                <td class="table-data__tbody-td">
                                                    @if($package->last_status_id == 7)
                                                        <p style="color: red;margin-bottom:0px" aria-placeholder="Qadağan edilən bağlama"></p>
                                                    @else
                                                        @if($package->invoice_status == 1)
                                                            <p style="color: red;margin-bottom:0px">{!! __('status.no_invoice') !!}</p>
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
                                                                    onclick="paid_package_new(this, '{{ App::getLocale() }}','{{route("pay_order", ['locale' => App::getLocale(), $package->id])}}');">
                                                                {!! __('buttons.pay') !!}
                                                            </button>
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
                                                </td>
                                                {{-- <td class="order-info-link" style="text-align: center;">--}}
                                                <td class="order-info-link" style="vertical-align: middle; text-align: center; width: 50px;border-style: hidden;">
                                                    <span
                                                            onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route('get_package_items', ['locale' => app()->getLocale()])}}');"
                                                            class="order-view"
                                                            style="display: inline-flex; align-items: center; justify-content: center; height: 100%; width: 100%; cursor: pointer;">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
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
                            <div class="d-block d-lg-none">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-checkbox form-checkbox-all d-flex justify-content-start align-items-center">
                                            <input class="form-checkbox__input" type="checkbox" id="selectRowsCheckbox2">
                                            <span class="form-checkbox__span mr-5"></span>
                                            <span class="form-checkbox__text"></span>
                                            Toplu seçim
                                        </label>
                                    </div>
                                </div>
                                @if(count($packages) > 0)
                                    @foreach($packages as $index => $package)
                                        @if($package->chargeable_weight == 1)
                                            @php($package_weight = $package->gross_weight)
                                        @else
                                            @php($package_weight = $package->volume_weight)
                                        @endif
                                        <div class="row box-row checkbox-box order_package_{{$package->id}}" id="{{$package->id}}" aria-status="{{$package->paid_status}}">

                                            <div class="col-6">
                                                <label class="form-checkbox d-flex justify-content-start align-items-center" for="checkbox-{{$package->id}}"
                                                       style="position: relative; z-index: 1; cursor: pointer; display: flex; align-items: center;">
                                                    <input id="checkbox-{{$package->id}}" class="form-checkbox__input" type="checkbox"
                                                           style="position: relative; width: 20px; height: 20px; opacity: 1; cursor: pointer; z-index: 2;">
                                                    <span class="form-checkbox__span"
                                                          style="width: 20px; height: 20px; border: 1px solid #000; display: inline-block; position: relative; margin-left: -20px;"></span>
                                                    <span class="form-checkbox__text"></span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                    <span
                                            onclick="show_package_items({{$package->id}}, '{{$package->track}}', '{{route('get_package_items', ['locale' => app()->getLocale()])}}');"
                                            class="order-view"
                                            style="height: 100%; width: 100%; cursor: pointer;">
                                        Ətraflı <i class="fas fa-eye"></i>
                                    </span>
                                            </div>

                                        </div>
                                        <div class="row box-row ">
                                            <div class="col-6">
                                                {!! __('table.flight') !!}
                                            </div>
                                            <div class="col-6">
                                                @if(isset($package->flight))
                                                    {{$package->flight}}
                                                @else
                                                    ---
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                {!! __('table.tracking') !!}
                                            </div>
                                            <div class="col-6">
                                    <span class="text-toggle">
                                        <span class="short-text">{{ Str::limit($package->track, 15) }}</span>
                                        <span class="full-text">{{ $package->track }}</span>
                                    </span>
                                                <span>{{ $package->internal_id }}</span>
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                {!! __('table.weight') !!}
                                            </div>
                                            <div class="col-6">
                                                @if($package_weight > 0)
                                                    {{$package_weight}} {{$package->unit}}

                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                {!! __('table.delivery_amount') !!}
                                            </div>
                                            <div class="col-6">
                                                @if($package->amount > 0)
                                                    {{$package->cur_icon}} {{$package->amount}}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                Filial
                                            </div>
                                            <div class="col-6">
                                                {{$package->branch_name}}
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                {!! __('table.invoice_status') !!}
                                            </div>
                                            <div class="col-6">
                                                @if($package->last_status_id == 7)
                                                    <p style="color: red;margin-bottom:0px" aria-placeholder="Qadağan edilən bağlama"></p>
                                                @else
                                                    @if($package->invoice_status == 1)
                                                        <p style="color: red;margin-bottom:0px">{!! __('status.no_invoice') !!}</p>
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
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                {!! __('table.status') !!}
                                            </div>
                                            <div class="col-6">
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
                                            </div>
                                        </div>
                                        <div class="row box-row">
                                            <div class="col-6">
                                                {!! __('table.pay') !!}
                                            </div>
                                            <div class="col-6">
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
                                                                onclick="paid_package_new(this, '{{ App::getLocale() }}','{{route("pay_order", ['locale' => App::getLocale(), $package->id])}}');">
                                                            {!! __('buttons.pay') !!}
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="box-line"></div>
                                    @endforeach
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="item-modal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Bağlama detalları</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Satıcı</th>
                            <th>Kateqoriya</th>
                            <th>Qiymət</th>
                        </tr>
                        </thead>
                        <tbody id="items_list">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('styles')
    <style>
        input[type="checkbox"] {
            accent-color: #f4cf41;
        }





        .box-row {
            padding: 12px 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .text-toggle {
            cursor: pointer;
            display: inline-block;
        }

        .text-toggle .full-text {
            display: none;
        }

        .text-toggle.expanded .short-text {
            display: none;
        }

        .text-toggle.expanded .full-text {
            display: inline;
            min-width: 150px;
            max-width: 300px;
            word-break: break-word;
            white-space: normal;
        }
        @media (max-width: 480px) {
            .dropdown-label-1 {
                width: 180px;
                font-size: 12px;
                padding: 13px 18px;
            }
        }

        .dropdown-menu {
            width: 55%;
            left: 40%;
        }
        .dropdown-menu-mob {
            left: 4%;
        }
        .badge-secondary{
            color: black;
        }
        .count-badge {
            font-size: 1em;
            padding: 6px 10px;
            border-radius: 14px;
            font-weight: bold;
        }

        /*.bar-width{*/
        /*    margin: -1100px 20px 20px 315px ;*/
        /*    width: 83%;*/
        /*}*/
        .bar-margin {
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .bar-padding {
            margin-top: -5px;
            margin-bottom: -5px;
        }

        #dropdown-label-package {
            width: 60%;
        }

        .th-new {
            padding: 7px 0 !important;
            margin-top: 20px;
            width: 25px;
        }

        @if(count($packages)==0)
        @media (max-width: 575.98px) {
            .footer{
                padding: 10px 0;
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        }
       @endif

        /*.table-data__thead-th{*/
        /*    vertical-align: top;*/
        /*    width: auto;*/
        /*}*/
        /*th:nth-child(6), td:nth-child(6) {*/
        /*    display: none;*/
        /*}*/
    </style>
@endsection


@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".text-toggle").forEach(function(el) {
                el.addEventListener("click", function() {
                    el.classList.toggle("expanded");
                    el.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                });
            });
        });
        document.addEventListener("click", function(event) {
            let dropdown = document.querySelector(".dropdown-container2");
            let checkbox = document.getElementById("dropdown-toggle2");

            if (!dropdown.contains(event.target)) {
                checkbox.checked = false;
            }
        });
        document.addEventListener("click", function(event) {
            let dropdown = document.querySelector(".dropdown-container3");
            let checkbox = document.getElementById("dropdown-toggle3");

            if (!dropdown.contains(event.target)) {
                checkbox.checked = false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if ($(window).width() < 992) {
                var tableRows = document.querySelectorAll('.checkbox-box');
            } else {
                var tableRows = document.querySelectorAll('tbody tr');
            }

            var packageIds = [];
            var packageIdsInput = document.getElementById('package_ids');
            if ($(window).width() < 992) {
                var selectRowsCheckbox = document.getElementById('selectRowsCheckbox2');
                var payBtn = document.getElementById('payBtn2');
            } else {
                var selectRowsCheckbox = document.getElementById('selectRowsCheckbox');
                var payBtn = document.getElementById('payBtn');
            }


            tableRows.forEach(function(row) {
                var checkbox = row.querySelector('input[type="checkbox"]');

                row.addEventListener('click', function(event) {
                    if (!event.target.closest('input[type="checkbox"]')) {
                        checkbox.checked = !checkbox.checked;
                        handleCheckboxSelection(checkbox, row);
                    }
                });

                checkbox.addEventListener('click', function(event) {
                    event.stopPropagation();
                    handleCheckboxSelection(checkbox, row);
                });
            });

            selectRowsCheckbox.addEventListener('change', function() {
                tableRows.forEach(function(row) {
                    var checkbox = row.querySelector('input[type="checkbox"]');
                    checkbox.checked = selectRowsCheckbox.checked;
                    handleCheckboxSelection(checkbox, row);
                });
            });

            function handleCheckboxSelection(checkbox, row) {
                var packageId = row.getAttribute('id');

                if (checkbox.checked) {
                    if (!packageIds.includes(packageId)) {
                        packageIds.push(packageId);
                    }
                } else {
                    var index = packageIds.indexOf(packageId);
                    if (index !== -1) {
                        packageIds.splice(index, 1);
                    }
                }

                packageIdsInput.value = JSON.stringify(packageIds);
                updatePayButtonState();
            }

            function updatePayButtonState() {
                payBtn.disabled = packageIds.length === 0;
            }
        });
        document.querySelectorAll('.form-checkbox__input').forEach(function(checkbox) {
            checkbox.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    </script>

    <script>
        const dropdownLinks = document.querySelectorAll('.package-dropdown a');
        const dropdownLabel = document.getElementById('dropdown-label-package');
        const dropdownLabel1 = document.getElementById('dropdown-label-package1');

        dropdownLinks.forEach(link => {
            link.addEventListener('click', function(event) {

                const selectedText = this.textContent;
                dropdownLabel.textContent = selectedText + ' ';

                dropdownLabel.appendChild(document.querySelector('.dropdown-icon'));


                dropdownLabel1.textContent = selectedText + ' ';

                dropdownLabel1.appendChild(document.querySelector('.dropdown-icon'));

                window.location.href = this.href;
            });
        });
    </script>
@endsection