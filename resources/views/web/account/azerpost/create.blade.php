@extends('web.layouts.web')
@section('content')

    <div class="content" id="content">
        <section class="section section-profile-balances">

            <div class="container-lg">
                <div class="row">
                    @include("web.account.account_left_bar")
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                        <div class="thumbnail thumbnail-profile-title-block d-flex justify-content-between align-items-center">
                            <h4 class="thumbnail-profile-title-block__title font-n-b">{!! __('courier.azerpost_title') !!}</h4>
                            
                        </div>
                        @if (session()->has('case') && session('case') === 'error')
                            <div class="alert alert-danger d-flex align-items-center p-3 shadow-lg rounded-3" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle me-2">
                                </svg>
                                <div>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        @if(session('content'))
                                            <li>{{ session('content') }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif


                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="form form-profile-azerpoct" name="formProfileAzerpoct" id="formProfileAzerpoct" method="post" action="{{route('courier_create_order_region', ['locale' => App::getLocale()])}}" novalidate="novalidate">
                            @csrf
                            <input type="hidden" required name="packages_list" id="checked_packages_region" value="{{ old('packages_list') }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="userSendLocation">{!! __('courier.region') !!}</label>
                                        <div class="form__select-wrapper">
                                            <select class="form__select region_id" id="area_id" name="region_id" required>
                                                <option value="">{!! __('courier.region') !!}</option>
                                                @foreach($regions as $area)
                                                    <option value="{{$area->id}}" {{ old('region_id') == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('region_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="userSendPostIndex">{!! __('courier.zip') !!}</label>
                                        <div class="form__select-wrapper">
                                            <select class="form__select" id="post_index" name="post_zip" required {{ old('post_zip') ? '' : 'disabled' }}>
                                                <option value="0" selected disabled>{!! __('courier.zip') !!}</option>
                                                @if(old('post_zip'))
                                                    <option value="{{ old('post_zip') }}" selected>{{ old('post_zip') }}</option>
                                                @endif
                                            </select>
                                            @error('post_zip')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form__group">
                                        <label class="form__label" for="userSendAddress">{!! __('courier.address') !!}</label>
                                        <input class="form__input" name="address" type="text" id="address" placeholder="{!! __('courier.address') !!}" value="{{ old('address') }}" required>
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="userSendPhone">{!! __('courier.phone') !!}</label>
                                        <input class="form__input" name="phone" id="phone" placeholder="{!! __('courier.phone') !!}" value="{{ old('phone', Auth::user()->phone()) }}" maxlength="30" required>
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="date">{!! __('courier.date') !!}</label>
                                        <input class="form__input" name="date" type="date" id="date" value="{{ old('date') }}" required min="{{ $min_date }}" max="{{ $max_date }}">
                                        @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="form__group">
                                                <button class="btn btn-trns-black btn-block form-profile-curier__btn btnProfileAzerpoctOrders font-n-b" type="button" data-bs-toggle="modal" data-bs-target="#modalProfileAzerpoctOrders">
                                                    {!! __('courier.choose_packages_button') !!}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-orders-result-preview font-n-r d-none">
                                            <thead>
                                            <tr class="table-orders-result-preview__tr">
                                                <th class="table-orders-result-preview__th font-n-b">{!! __('courier.track') !!}</th>
                                                <th class="table-orders-result-preview__th font-n-b">{!! __('table.amount') !!}</th>
                                                <th class="table-orders-result-preview__th font-n-b">{!! __('table.external_w_debt') !!}</th>
                                                <th class="table-orders-result-preview__th font-n-b">{!! __('table.internal_w_debt') !!}</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-orders-result font-n-r">
                                            <tr class="table-orders-result__tr">
                                                <td class="table-orders-result__td font-n-b">{!! __('courier.delivery_amount') !!}</td>
                                                <td class="table-orders-result__td" id="delivery_price_region"></td>
                                            </tr>
                                            <tr class="table-orders-result__tr">
                                                <td class="table-orders-result__td font-n-b">{!! __('courier.courier_amount') !!}</td>
                                                <td class="table-orders-result__td" id="courier_price_region"></td>
                                            </tr>
                                            <tr class="table-orders-result__tr">
                                                <td class="table-orders-result__td font-n-b">{!! __('courier.summary_amount') !!}</td>
                                                <td class="table-orders-result__td" id="summary_price_region"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-center justify-content-sm-end">
                                        <button class="btn btn-blue form-profile-azerpoct__btn font-n-b" type="button" data-bs-toggle="modal" data-bs-target="#modalProfileAzerpoct">Sifariş et</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Modal -->
    <div class="modal modal-profile-azerpoct fade" id="modalProfileAzerpoct" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-profile-azerpoct__dialog center-block">
            <div class="modal-content modal-profile-azerpoct__content">
                <div class="modal-header modal-profile-azerpoct__header justify-content-end">
                    <img class="modal-profile-azerpoct__img-close" src="/web/images/content/modal-close.png" alt="Modal Close" data-bs-dismiss="modal">
                </div>
                <div class="modal-body modal-profile-azerpoct__body">
                    <form class="form form-modal-profile form-modal-profile-azerpoct center-block">
                        <h6 class="form-modal-profile__title form-modal-profile-azerpoct__title text-center font-n-b">Kuryer sifariş edilsin?</h6>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-trns-black btn-block form-modal-profile__btn form-modal-profile-azerpoct__btn font-n-b" type="button" data-bs-dismiss="modal">Xeyr</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-blue btn-block form-modal-profile__btn form-modal-profile-azerpoct__btn font-n-b" form="formProfileAzerpoct" type="submit">Bəli</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-profile-curier-orders fade" style="margin-top: 100px;" id="modalProfileAzerpoctOrders" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-profile-curier-orders__dialog center-block">
            <div class="modal-content modal-profile-curier-orders__content">
                <div class="modal-body modal-profile-curier-orders__body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-orders-2 font-n-r">
                            <tr class="table-orders-2__tr">
                                <td class="table-orders-2__td">
                                    <label class="form-checkbox d-flex justify-content-start align-items-center" for="checkAllRegion">
                                        <input class="form-checkbox__input courier-check-box" type="checkbox" id="checkAllRegion" checked>
                                        <span class="form-checkbox__span"></span>
                                    </label>
                                </td>
                                <td class="table-orders-2__td">{!! __('courier.track') !!}</td>
                                <td class="table-orders-2__td">{!! __('courier.gross_weight') !!}</td>
                                <td class="table-orders-2__td">{!! __('courier.amount') !!}</td>
                                <td class="table-orders-2__td">{!! __('courier.external_warehouse_debt') !!}</td>
                                <td class="table-orders-2__td">{!! __('courier.internal_warehouse_debt') !!}</td>
                                <td class="table-orders-2__td">{!! __('courier.payment_type') !!}</td>
                                <td class="table-orders-2__td">{!! __('courier.client') !!}</td>
                            </tr>
                            @php($referrals_packages_count = 0)
                            @foreach($packages as $package)
                                @if($package->client_id == Auth::id())
                                    @php($referrals_packages_class = '')
                                @else
                                    @php($referrals_packages_count++)
                                    @php($referrals_packages_class = 'class="referrals_packages_class"')
                                @endif
                                <tr class="table-orders-2__tr orderBlock">
                                    <td class="table-orders-2__td">
                                        <label class="form-checkbox d-flex justify-content-start align-items-center" for="package_{{$package->id}}">
                                            <input class="form-checkbox__input checks_region courier-check-box" checked name="packages" type="checkbox" id="package_{{$package->id}}"
                                                   amount="{{$package->amount}}"
                                                   external_w_debt="{{$package->external_w_debt}}"
                                                   internal_w_debt="{{$package->internal_w_debt}}"
                                                   track="{{$package->track}}" value="{{$package->id}}"
                                                   weight="{{$package->gross_weight}}"
                                            >
                                            <span class="form-checkbox__span"></span>
                                        </label>
                                    </td>
                                    <td class="table-orders-2__td orderId">{{$package->track}}</td>
                                    <td class="table-orders-2__td orderWeight">{{$package->gross_weight}} kg</td>
                                    <td class="table-orders-2__td orderPrice">{{$package->amount}} AZN</td>
                                    <td class="table-orders-2__td orderPrice2">{{$package->external_w_debt}} AZN</td>
                                    <td class="table-orders-2__td orderPrice3">{{$package->internal_w_debt}} AZN</td>
                                    <td class="table-orders-2__td orderType">{{$package->payment_type}}</td>
                                    <td class="table-orders-2__td orderName">{{$package->client_name}} {{$package->client_surname}}</td>
                                </tr>
                            @endforeach
                        </table>

                        <div class="d-flex buttons-section justify-content-end">
                            <button class="btn btn-secondary btnOrderSelect font-n-b" style="margin-right: 5px" type="button" data-bs-dismiss="modal">Bağla</button>
                            <button class="btn btn-yellow btnOrderSelect font-n-b" type="button" data-bs-dismiss="modal" onclick="check_packages_region();">{!! __('courier.choose_button') !!}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        default_urgent_amount = '{{$amount_for_urgent}}';

        $(".region_id").on("change", function () {
            var regionId = $(this).val();
            //console.log(regionId);

            $("#post_index").prop("disabled", false);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

            $.ajax({
                type: "GET",

                url: '{{route('azerpost_index_by_region', ['locale' => App::getLocale()])}}',
                data: { region_id: regionId, '_token': CSRF_TOKEN },
                dataType: "json",
                success: function (response) {

                    $("#post_index").empty().append('<option value="">' + "{!! __('courier.zip') !!}" + '</option>');
                    $.each(response.data, function (index, item) {
                        $("#post_index").append('<option value="' + item.id + '">' + item.index_code + ' - ' + item.address + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
@section('styles')
    <style>
        .buttons-section{
            text-align: right;
        }
        .table-responsive::-webkit-scrollbar {
            width: 8px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.2);
            border-radius: 4px;
        }
        .modal-profile-curier-orders__body {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
@endsection