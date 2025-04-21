@extends('web.layouts.web')
@section('content')

    <div class="content" id="content">
        <section class="section section-profile-curiers">
            <div class="container-lg">
                <div class="row">
                    @include("web.account.account_left_bar")
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                        <div class="thumbnail thumbnail-profile-title-block d-flex justify-content-between align-items-center">
                            <h4 class="thumbnail-profile-title-block__title font-n-b">{!! __('courier.title') !!}</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
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


                        <form class="form form-profile-curier" name="formProfileCurier" id="formProfileCurier" method="post" action="{{route('courier_create_order', ['locale' => App::getLocale()])}}" novalidate="novalidate">
                            @csrf
                            <input type="hidden" required name="packages_list" id="checked_packages">
                            <h3 class="form-profile-curier__title text-center font-n-b">{!! __('courier.title') !!}</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="area_id">{!! __('courier.area') !!}</label>
                                        <div class="form__select-wrapper">
                                            <select class="form__select" name="area_id" id="area_id" oninput="courier_change_area(this, '{{route("courier_get_courier_payment_types", ['locale' => App::getLocale()])}}');" required="required">
                                                <option value="" selected>{!! __('courier.area') !!}</option>
                                                @foreach($areas as $area)
                                                    <option value="{{$area->id}}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('area_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="metro_station_id">{!! __('courier.metro_station') !!}</label>
                                        <div class="form__select-wrapper">
                                            <select class="form__select" name="metro_station_id" id="metro_station_id" required="required">
                                                <option value="0" selected>{!! __('courier.metro_station') !!}</option>
                                                @foreach($metro_stations as $metro_station)
                                                    <option value="{{$metro_station->id}}" {{ old('metro_station_id') == $metro_station->id ? 'selected' : '' }}>{{$metro_station->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('metro_station_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form__group">
                                        <label class="form__label" for="address">{!! __('courier.address') !!}</label>
                                        <input class="form__input" name="address" type="text" id="address" value="{{ old('address') }}" placeholder="{!! __('courier.address') !!}" required="required">
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="phone">{!! __('courier.phone') !!}</label>
                                        <input class="form__input" name="phone" type="text" id="phone" placeholder="{!! __('courier.phone') !!}" value="{{ old('phone', Auth::user()->phone()) }}" maxlength="30" required="required">
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="date">{!! __('courier.date') !!}</label>
                                        <input class="form__input" name="date" type="date" id="date" value="{{ old('date') }}" required="required" min="{{ $min_date }}" max="{{ $max_date }}">
                                        @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label">{!! __('courier.courier_payment_type_title') !!}</label> <br>
                                        @error('courier_payment_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <input type="hidden" name="courier_payment_type_id" id="courier_payment_type_id" value="{{ old('courier_payment_type_id') }}">
                                        <div class="row">
                                            <div class="col-sm-4 col-6">
                                                <label class="form-profile-curier__label form-profile-curier__label--no-active form__label internalLocation w-100 text-center {{ old('courier_payment_type_id') == '1' ? 'active' : '' }}"
                                                       id="courier_pay_button_1"
                                                       onclick="choosePayment('courier_payment_type_id', 'courier_pay_button_1', ['courier_pay_button_2']);">
                                                    <img class="form-profile-curier__img" src="/web/images/content/online-payment.png" alt="{!! __('courier.online') !!}">
                                                    <span>{!! __('courier.online') !!}</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <label class="form-profile-curier__label form-profile-curier__label--no-active form__label internalLocation w-100 text-center {{ old('courier_payment_type_id') == '2' ? 'active' : '' }}"
                                                       id="courier_pay_button_2"
                                                       onclick="choosePayment('courier_payment_type_id', 'courier_pay_button_2', ['courier_pay_button_1']);">
                                                    <img class="form-profile-curier__img" src="/web/images/content/cash-payment.png" alt="{!! __('courier.cash') !!}">
                                                    <span>{!! __('courier.cash') !!}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form__group">
                                        <label class="form__label" for="userSendExternalPaymentType">{!! __('courier.delivery_payment_type_title') !!}</label> <br>
                                        @error('delivery_payment_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <input type="hidden" name="delivery_payment_type_id" id="delivery_payment_type_id" value="{{ old('delivery_payment_type_id') }}">
                                        <div class="row">
                                            <div class="col-sm-4 col-6">
                                                <label class="form-profile-curier__label form-profile-curier__label--no-active form__label externalLocation w-100 text-center {{ old('delivery_payment_type_id') == '1' ? 'active' : '' }}"
                                                       id="delivery_pay_button_1"
                                                       onclick="choosePayment('delivery_payment_type_id', 'delivery_pay_button_1', ['delivery_pay_button_2']);">
                                                    <img class="form-profile-curier__img" src="/web/images/content/online-payment.png" alt="OnlinePayment">
                                                    <span>{!! __('courier.online') !!}</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <label class="form-profile-curier__label form-profile-curier__label--no-active form__label externalLocation w-100 text-center {{ old('delivery_payment_type_id') == '2' ? 'active' : '' }}"
                                                       id="delivery_pay_button_2"
                                                       onclick="choosePayment('delivery_payment_type_id', 'delivery_pay_button_2', ['delivery_pay_button_1']);">
                                                    <img class="form-profile-curier__img" src="/web/images/content/cash-payment.png" alt="CashPayment">
                                                    <span>{!! __('courier.cash') !!}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="form__group">
                                                <button class="btn btn-trns-black btn-block form-profile-curier__btn btnProfileCurierOrders font-n-b" type="button" data-bs-toggle="modal" data-bs-target="#modalProfileCurierOrders">
                                                    {!! __('courier.choose_packages_button') !!}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form__group">
                                                <input type="hidden" id="urgent_order_input" name="urgent_order" required value="{{ old('urgent_order', 0) }}">
                                                <label class="form-checkbox d-flex justify-content-start align-items-center" for="userSendUrgent">
                                                    <input class="form-checkbox__input" type="checkbox" id="userSendUrgent" onclick="set_urgent_order(this, {{$amount_for_urgent}});" {{ old('urgent_order') == 1 ? 'checked' : '' }}>
                                                    <span class="form-checkbox__span"></span>
                                                    <span class="form-checkbox__text">{!! __('courier.urgent_order_button') !!}</span>
                                                </label>
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
                                                <td class="table-orders-result__td" id="delivery_price"></td>
                                            </tr>
                                            <tr class="table-orders-result__tr">
                                                <td class="table-orders-result__td font-n-b">{!! __('courier.courier_amount') !!}</td>
                                                <td class="table-orders-result__td" id="courier_price"></td>
                                            </tr>
                                            <tr class="table-orders-result__tr">
                                                <td class="table-orders-result__td font-n-b">{!! __('courier.summary_amount') !!}</td>
                                                <td class="table-orders-result__td" id="summary_price"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-center justify-content-sm-end">
                                        <button class="btn btn-blue form-profile-curier__btn font-n-b" type="button" data-bs-toggle="modal" data-bs-target="#modalProfileCurier">Kuryer sifariş et</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal modal-profile-curier fade" id="modalProfileCurier" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-profile-curier__dialog center-block">
            <div class="modal-content modal-profile-curier__content">
                <div class="modal-header modal-profile-curier__header justify-content-end">
                    <img class="modal-profile-curier__img-close" src="/web/images/content/modal-close.png" alt="Modal Close" data-bs-dismiss="modal">
                </div>
                <div class="modal-body modal-profile-curier__body">
                    <form class="form form-modal-profile form-modal-profile-curier center-block">
                        <h6 class="form-modal-profile__title form-modal-profile-curier__title text-center font-n-b">Kuryer sifariş edilsin?</h6>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-trns-black btn-block form-modal-profile__btn form-modal-profile-curier__btn font-n-b" type="button" data-bs-dismiss="modal">Xeyr</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-blue btn-block form-modal-profile__btn form-modal-profile-curier__btn font-n-b" form="formProfileCurier" type="submit">Bəli</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-profile-curier-orders fade" id="modalProfileCurierOrders" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-profile-curier-orders__dialog center-block">
            <div class="modal-content modal-profile-curier-orders__content">
                <div class="modal-body modal-profile-curier-orders__body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-orders-2 font-n-r">
                            <tr class="table-orders-2__tr">
                                <td class="table-orders-2__td">
                                    <label class="form-checkbox d-flex justify-content-start align-items-center" for="userSendOrders" id="checkAll">
                                        <input class="form-checkbox__input courier-check-box" type="checkbox" checked>
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
                                            <input class="form-checkbox__input checks courier-check-box" checked name="packages" type="checkbox" id="package_{{$package->id}}"
                                                   for="package_{{$package->id}}"
                                                   amount="{{$package->amount}}"
                                                   external_w_debt="{{$package->external_w_debt}}"
                                                   internal_w_debt="{{$package->internal_w_debt}}"
                                                   track="{{$package->track}}" value="{{$package->id}}"
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
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-secondary modal-button" type="button" data-bs-dismiss="modal">Bağla</button>
                            <button class="btn btn-yellow btnOrderSelect font-n-b" type="button" data-bs-dismiss="modal" onclick="check_packages();">{!! __('courier.choose_button') !!}</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('styles')
<style>
    .modal-button{
        display: flex;
        margin-right: 5px;
    }
</style>
@endsection
@section('scripts')
    <script>
        function choosePayment(hiddenInputId, activeButtonId, otherButtonIds) {

            const hiddenInput = document.getElementById(hiddenInputId);
            hiddenInput.value = activeButtonId;

            const activeButton = document.getElementById(activeButtonId);
            activeButton.classList.add('form-profile-curier__label--active');
            activeButton.classList.remove('form-profile-curier__label--no-active');


            otherButtonIds.forEach(buttonId => {
                const button = document.getElementById(buttonId);
                button.classList.remove('form-profile-curier__label--active');
                button.classList.add('form-profile-curier__label--no-active');
            });
        }

    </script>
@endsection