@extends('web.layouts.web')
@section('content')
    <input type="hidden" name="package_ids" id="package_ids" value="">
    <div class="content" id="content">
        <section class="section section-profile-addresses">
            <div class="container-lg">
                <div class="row">
                    @include('web.account.account_left_bar')
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7 bar-width">
                        <div class="thumbnail thumbnail-profile-title-block d-flex justify-content-between align-items-center">
                            <h4 class="thumbnail-profile-title-block__title font-n-b">Bağlamalar</h4>
                            <div class="dropdown-container">
                                <label for="dropdown-toggle" class="dropdown-label" id="dropdown-label">
                                    @if($currentStatus==0)
                                    Bütün bağlamalarım
                                    @elseif($currentStatus==3)
                                        Xarici anbardadır
                                    @elseif($currentStatus==4)
                                        Anbardan göndərilib
                                    @elseif($currentStatus==5)
                                        Bakı ofisindədir
                                    @elseif($currentStatus==6)
                                        Arxiv

                                    @endif
                                    <span class="dropdown-icon"></span>
                                </label>
                                <input type="checkbox" id="dropdown-toggle" class="dropdown-checkbox" />
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=3' }}" data-status="3">Xarici anbardadır</a></li>
                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=4' }}" data-status="4">Anbardan göndərilib</a></li>
                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=5' }}" data-status="5">Bakı ofisindədir</a></li>
                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=6' }}" data-status="6">Arxiv</a></li>
                                </ul>
                            </div>



                            <div class="d-flex justify-content-center align-items-center">


                                <button
                                        type="button" class="btn btn-yellow thumbnail-profile-title-block__btn d-flex justify-content-center align-items-center font-n-b" id="payBtn" disabled
                                        data-balance-message="{!! __('static.packages_balance_message') !!}"
                                        data-confirm="{!! __('static.confirm_pay') !!}"
                                        onclick="bulk_paid_package_new(this, '{{route("bulk_pay", ['locale' => App::getLocale()])}}')">{!! __('buttons.pay_all') !!}
                                </button>
                            </div>
                        </div>
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
    </div>

@endsection
@section('styles')
    <style>
        .bar-width{
            margin: -858px 20px 20px 315px ;
            width: 83%;
        }
    </style>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tableRows = document.querySelectorAll('tbody tr');
            var packageIds = [];
            var packageIdsInput = document.getElementById('package_ids');
            var selectRowsCheckbox = document.getElementById('selectRowsCheckbox');
            var payBtn = document.getElementById('payBtn');

            // Satırdaki tıklama olayını düzenleme
            tableRows.forEach(function (row) {
                var checkbox = row.querySelector('input[type="checkbox"]');

                row.addEventListener('click', function (event) {
                    // Eğer tıklanan eleman checkbox değilse checkbox'ı tetikle
                    if (!event.target.closest('input[type="checkbox"]')) {
                        checkbox.checked = !checkbox.checked;
                        handleCheckboxSelection(checkbox, row);
                    }
                });

                // Checkbox'a tıklandığında sadece checkbox durumu güncellensin
                checkbox.addEventListener('click', function (event) {
                    event.stopPropagation(); // Satır tıklamasıyla çakışmayı önlemek için
                    handleCheckboxSelection(checkbox, row);
                });
            });

            // "Tümünü Seç" checkbox'ı tıklanınca
            selectRowsCheckbox.addEventListener('change', function () {
                tableRows.forEach(function (row) {
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
                event.stopPropagation(); // Satır tıklama olayını engelle
            });
        });


    </script>

    <script>
        const dropdownLinks = document.querySelectorAll('.dropdown-menu a');
        const dropdownLabel = document.getElementById('dropdown-label');

        dropdownLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                // event.preventDefault(); // Sayfanın yenilənməsinin qarşısını alır

                const selectedText = this.textContent;
                dropdownLabel.textContent = selectedText + ' ';

                // Bütün bağlamalarım mətninin silinməsi üçün lazım olan əvəzetməni əlavə et
                dropdownLabel.appendChild(document.querySelector('.dropdown-icon'));

                // Linkin URL-i ilə yönləndirmə
                window.location.href = this.href;
            });
        });
    </script>
@endsection