@extends('web.layouts.web')
@section('content')
    <input type="hidden" name="package_ids" id="package_ids" value="">
    <div class="content" id="content">
        <section class="section section-profile-addresses">
            <div class="container-lg">
                <div class="row">
{{--                    @include('web.account.account_left_bar')--}}
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                        <div class="thumbnail thumbnail-profile-title-block d-flex justify-content-between align-items-center">
                            <h4 class="thumbnail-profile-title-block__title font-n-b">Bağlamalar</h4>
{{--                            <div class="dropdown-container">--}}
{{--                                <label for="dropdown-toggle" class="dropdown-label">--}}
{{--                                    Bütün bağlamalarım--}}
{{--                                    <span class="dropdown-icon"></span>--}}
{{--                                </label>--}}
{{--                                <input type="checkbox" id="dropdown-toggle" class="dropdown-checkbox" />--}}
{{--                                <ul class="dropdown-menu">--}}
{{--                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=3' }}">Xarici anbardadır</a></li>--}}
{{--                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=4' }}">Anbardan göndərilib</a></li>--}}
{{--                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=5' }}">Bakı ofisindədir</a></li>--}}
{{--                                    <li><a href="{{ route('get_orders', ['locale' => app()->getLocale()]) . '?country=' . $search['country'] . '&status=6' }}">Arxiv</a></li>--}}

{{--                                </ul>--}}
{{--                            </div>--}}




                            <div class="d-flex justify-content-center align-items-center">


{{--                                <button--}}
{{--                                        type="button" class="btn btn-yellow thumbnail-profile-title-block__btn d-flex justify-content-center align-items-center font-n-b" id="payBtn" disabled--}}
{{--                                        data-balance-message="{!! __('static.packages_balance_message') !!}"--}}
{{--                                        data-confirm="{!! __('static.confirm_pay') !!}"--}}
{{--                                        onclick="bulk_paid_package_new(this, '{{route("bulk_pay", ['locale' => App::getLocale()])}}')">{!! __('buttons.pay_all') !!}--}}
{{--                                </button>--}}
                            </div>
                        </div>
                        <div class="thumbnail thumbnail-data">
                            <div class="table-responsive">
                                @if(count($packages) > 0)
                                    <table class="table table-data">
                                        <thead>
{{--                                        <tr class="table-data__thead-tr">--}}
{{--                                            <th class="table-data__thead-th">--}}
{{--                                                <label class="form-checkbox form-checkbox-all d-flex justify-content-start align-items-center">--}}
{{--                                                    <input class="form-checkbox__input" type="checkbox" id="selectRowsCheckbox">--}}
{{--                                                    <span class="form-checkbox__span"></span>--}}
{{--                                                    <span class="form-checkbox__text"></span>--}}
{{--                                                </label>--}}
{{--                                            </th>--}}
{{--                                            <th class="table-data__thead-th">{!! __('table.flight') !!}</th>--}}
                                            <th class="table-data__thead-th">{!! __('table.tracking') !!}</th>
{{--                                            <th class="table-data__thead-th">{!! __('table.weight') !!}</th>--}}
{{--                                            <th class="table-data__thead-th">{!! __('table.delivery_amount') !!}</th>--}}
{{--                                            <th class="table-data__thead-th">{!! __('table.debt') !!}</th>--}}
{{--                                            <th class="table-data__thead-th">Filial</th>--}}
{{--                                            <th class="table-data__thead-th">{!! __('table.invoice_status') !!}</th>--}}
                                            <th class="table-data__thead-th">{!! __('table.status') !!}</th>
{{--                                            <th class="table-data__thead-th">{!! __('table.pay') !!}</th>--}}
{{--                                        </tr>--}}
                                        </thead>
                                        <tbody>
                                        @foreach($packages as $index => $package)
                                            @if($package->chargeable_weight == 1)
                                                @php($package_weight = $package->gross_weight)
                                            @else
                                                @php($package_weight = $package->volume_weight)
                                            @endif
                                            <tr class="table-data__tbody-tr order_package_{{$package->id}}" id="{{$package->id}}" aria-status="{{$package->paid_status}}">
{{--                                                <td class="table-data__tbody-td" id="{{$package->id}}" aria-status="{{$package->paid_status}}">--}}
{{--                                                    <label class="form-checkbox d-flex justify-content-start align-items-center">--}}
{{--                                                        <input class="form-checkbox__input" type="checkbox">--}}
{{--                                                        <span class="form-checkbox__span"></span>--}}
{{--                                                        <span class="form-checkbox__text"></span>--}}
{{--                                                    </label>--}}
{{--                                                </td>--}}
{{--                                                <td class="table-data__tbody-td">--}}
{{--                                                    @if(isset($package->flight))--}}
{{--                                                        {{$package->flight}}--}}
{{--                                                    @else--}}
{{--                                                        -----}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
                                                <td class="table-data__tbody-td">
                                                    <div>{{ $package->track }}</div>
{{--                                                    <div>{{ $package->internal_id }}</div>--}}
                                                </td>

{{--                                                <td class="table-data__tbody-td">--}}
{{--                                                    @if($package_weight > 0)--}}
{{--                                                        {{$package_weight}} {{$package->unit}}--}}

{{--                                                    @else--}}
{{--                                                        ---}}
{{--                                                    @endif--}}
{{--                                                </td>--}}

{{--                                                <td class="table-data__tbody-td">--}}
{{--                                                    @if($package->amount > 0)--}}
{{--                                                        {{$package->cur_icon}} {{$package->amount}}--}}
{{--                                                    @else--}}
{{--                                                        ---}}
{{--                                                    @endif--}}
{{--                                                </td>--}}

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
{{--                                                <td class="table-data__tbody-td">--}}
{{--                                                    {{$package->branch_name}}--}}
{{--                                                </td>--}}
{{--                                                <td class="table-data__tbody-td">--}}
{{--                                                    @if($package->last_status_id == 7)--}}
{{--                                                        <p style="color: red;" aria-placeholder="Qadağan edilən bağlama"></p>--}}
{{--                                                    @else--}}
{{--                                                        @if($package->invoice_status == 1)--}}
{{--                                                            <p style="color: red;">{!! __('status.no_invoice') !!}</p>--}}
{{--                                                        @elseif($package->invoice_status == 2)--}}
{{--                                                            {!! __('status.incorrect_invoice') !!}--}}
{{--                                                        @elseif($package->invoice_status == 3)--}}
{{--                                                            {!! __('status.correct_invoice') !!}--}}
{{--                                                        @elseif($package->invoice_status == 4)--}}
{{--                                                            {!! __('status.invoice_uploaded') !!}--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
{{--                                                    @if($package->last_status_id == 7)--}}
{{--                                                        <a href="#" style="display: none" target="_blank" class="fas fa-eye" placeholder="Prohibet not update">--}}
{{--                                                        </a>--}}
{{--                                                    @else--}}
{{--                                                        @if($package->invoice_status == 4)--}}
{{--                                                            <a href="{{ $package->invoice_doc }}" target="_blank" class="fas fa-eye">--}}
{{--                                                                {!! __('table.show_invoice_file') !!}--}}
{{--                                                            </a>--}}

{{--                                                        @elseif($package->invoice_status == 1)--}}
{{--                                                            <a href="{{route('get_package_update', ['locale' => App::getLocale(), $package->id])}}" class="fas fa-upload" style="color: red;">--}}
{{--                                                                {!! __('table.upload_invoice_file') !!}--}}
{{--                                                            </a>--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}

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
{{--                                                <td class="table-data__tbody-td">--}}
{{--                                                    @if($package->paid_status == 1)--}}
{{--                                                        <button type="button" disabled class="btn btn-paid"--}}
{{--                                                                style="cursor: not-allowed !important;">{!! __('static.paid') !!}--}}
{{--                                                        </button>--}}
{{--                                                    @else--}}
{{--                                                        @if($package->amount > 0)--}}
{{--                                                            <button--}}
{{--                                                                    type="button" class="btn btn-yellow"--}}
{{--                                                                    data-has-courier="{{$package->has_courier}}"--}}
{{--                                                                    data-has-courier-message="{!! __('static.packages_has_courier_message') !!}"--}}
{{--                                                                    data-balance="{{Auth::user()->balance()}}"--}}
{{--                                                                    data-balance-message="{!! __('static.packages_balance_message') !!}"--}}
{{--                                                                    data-amount="{{sprintf('%0.2f', $package->amount_usd - $package->paid)}}"--}}
{{--                                                                    data-confirm="{!! __('static.confirm_pay') !!}"--}}
{{--                                                                    onclick="paid_package_new(this, '{{route("pay_order", ['locale' => App::getLocale(), $package->id])}}');">--}}
{{--                                                                {!! __('buttons.pay') !!}--}}
{{--                                                            </button>--}}
{{--                                                        @else--}}
{{--                                                            ---}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
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


@section('scripts')
{{--    <script>--}}


{{--        // Dropdown menüyü açan checkbox--}}
{{--        const dropdownCheckbox = document.querySelector('.dropdown-checkbox');--}}

{{--        // Dropdown menüsünü açan buton--}}
{{--        const dropdownLabel = document.querySelector('.dropdown-label');--}}

{{--        // Menü dışında tıklanma olayını kontrol et--}}
{{--        document.addEventListener('click', function(event) {--}}
{{--            // Eğer tıklama, dropdown menüsüne veya butona yapılmamışsa--}}
{{--            if (!dropdownLabel.contains(event.target) && !dropdownCheckbox.contains(event.target)) {--}}
{{--                // Checkbox'ı kapat--}}
{{--                dropdownCheckbox.checked = false;--}}
{{--            }--}}
{{--        });--}}



{{--        var tableRows = document.querySelectorAll('tbody tr');--}}
{{--        var packageIds = [];--}}
{{--        var packageIdsInput = document.getElementById('package_ids');--}}

{{--        var selectRowsButton = document.getElementById('selectRowsButton');--}}
{{--        var isSelected = false;--}}

{{--        var selectSingleRowCheckbox = document.querySelectorAll('tbody tr td label input');--}}
{{--        var selectRowsCheckbox = document.getElementById('selectRowsCheckbox');--}}
{{--        var payBtn = document.getElementById('payBtn');--}}

{{--        $(document).ready(function () {--}}
{{--            let current_status = '{{$search['status']}}';--}}
{{--            $("#status_" + current_status).addClass('active');--}}

{{--            $(".mobile_status_select_options").removeAttr('selected');--}}
{{--            $("#mobile_status_select_" + current_status).attr('selected', true);--}}

{{--            $("#tbodyWeb tr").slice(12).hide();--}}
{{--            var mincount = 10;--}}
{{--            var maxcount = 20;--}}

{{--            $(".n-order-table").scroll(function () {--}}
{{--                var scrollHeight = $(".n-order-table")[0].scrollHeight;--}}
{{--                var scrollTop = $(".n-order-table").scrollTop();--}}
{{--                var containerHeight = $(".n-order-table").outerHeight();--}}

{{--                if (scrollTop + containerHeight >= scrollHeight - 50) {--}}
{{--                    $("tbody tr").slice(mincount, maxcount).slideDownSlow(600);--}}

{{--                    mincount = mincount + 10;--}}
{{--                    maxcount = maxcount + 10;--}}
{{--                }--}}
{{--            });--}}

{{--            $.fn.fadeInSlow = function (duration) {--}}
{{--                $(this).css("display", "none").fadeIn(duration);--}}
{{--            };--}}

{{--            $.fn.slideDownSlow = function (duration) {--}}
{{--                $(this).css({ marginTop: "20px", opacity: 0 }).slideDown(duration).animate({ marginTop: 0, opacity: 1 });--}}
{{--            };--}}

{{--        });--}}

{{--        @if($last30 == 'active')--}}
{{--        swal({--}}
{{--            title: '{!! __('static.attention') !!}!',--}}
{{--            html: '{!! __('static.last_30_days_text') !!}',--}}
{{--            type: "info",--}}
{{--            customClass: 'last-month-swal',--}}
{{--            showCancelButton: false,--}}
{{--            showConfirmButton:true--}}
{{--        });--}}
{{--        @endif--}}

{{--        var rowsCheck = false;--}}
{{--        tableRows.forEach(function(row) {--}}
{{--            selectSingleRowCheckbox.forEach(function(checkbox) {--}}
{{--                var checkTable = checkbox.closest('tr')--}}
{{--                var status = checkTable.getAttribute('aria-status');--}}

{{--                if (status == 0) {--}}
{{--                    checkbox.checked = false;--}}

{{--                } else {--}}
{{--                    checkbox.disabled = true;--}}
{{--                }--}}
{{--            });--}}
{{--            row.addEventListener('click', function() {--}}
{{--                if (isSelected === false && status == 0) {--}}
{{--                    payBtn.disabled = false;--}}
{{--                }else {--}}
{{--                    if (packageIds.length > 0) {--}}
{{--                        payBtn.disabled = false;--}}
{{--                    }else {--}}
{{--                        payBtn.disabled = true;--}}
{{--                    }--}}

{{--                }--}}

{{--                var checkbox = this.querySelector('td label input');--}}
{{--                var status = this.getAttribute('aria-status');--}}
{{--                //console.log(rowsCheck);--}}
{{--                if (status === '0') {--}}
{{--                    var packageId = this.getAttribute('id');--}}
{{--                    if (packageId) {--}}
{{--                        var index = packageIds.indexOf(packageId);--}}

{{--                        if (index !== -1) {--}}
{{--                            //this.classList.remove('selected');--}}
{{--                            packageIds.splice(index, 1);--}}
{{--                            checkbox.checked = false;--}}
{{--                            // console.log(packageIds.length)--}}
{{--                            if (packageIds.length === 0) {--}}
{{--                                payBtn.disabled = true;--}}
{{--                                selectRowsCheckbox.checked = false--}}
{{--                            }else {--}}
{{--                                payBtn.disabled = false;--}}
{{--                            }--}}
{{--                        } else {--}}
{{--                            if(status == 0){--}}
{{--                                packageIds.push(packageId);--}}
{{--                                checkbox.checked = true;--}}
{{--                                //payBtn.disabled = false;--}}
{{--                                if (packageIds.length > 0) {--}}
{{--                                    payBtn.disabled = false;--}}
{{--                                }--}}
{{--                            }--}}

{{--                        }--}}


{{--                        packageIdsInput.value = JSON.stringify(packageIds);--}}
{{--                        // console.log('Gönderilen package_ids:', packageIds);--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        selectRowsCheckbox.addEventListener('click', function() {--}}
{{--            var checkboxes = document.querySelectorAll('tbody tr[aria-status="0"] td label input');--}}

{{--            checkboxes.forEach(function(checkbox) {--}}
{{--                var tableRow = checkbox.closest('tr');--}}
{{--                var packageId = tableRow.getAttribute('id');--}}

{{--                if (selectRowsCheckbox.checked) {--}}
{{--                    checkbox.checked = true;--}}

{{--                    if (!packageIds.includes(packageId)) {--}}
{{--                        packageIds.push(packageId);--}}
{{--                    }--}}
{{--                    payBtn.disabled = false;--}}
{{--                    isSelected = true;--}}
{{--                } else {--}}
{{--                    checkbox.checked = false;--}}

{{--                    var index = packageIds.indexOf(packageId);--}}
{{--                    if (index !== -1) {--}}
{{--                        packageIds.splice(index, 1);--}}
{{--                    }--}}
{{--                    payBtn.disabled = true;--}}
{{--                    isSelected = true;--}}

{{--                }--}}
{{--            });--}}

{{--            packageIdsInput.value = JSON.stringify(packageIds);--}}
{{--            //console.log('Gönderilen package_ids:', packageIds);--}}
{{--        });--}}


{{--    </script>--}}
@endsection