@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->

        <!-- page content header -->
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text">
                        <h3> {!! __('account_menu.declaration') !!} </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-block">
            <div class="container ">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')

{{--                        <div class="page-content-right">--}}
{{--                            <div class="order-block profile-information-block">--}}
{{--                                <div class="order-form-header">--}}
{{--                                    <h3> {!! __('account_menu.declaration') !!} </h3>--}}
{{--                                </div>--}}
{{--                                <form id="preliminary_declaration_form" action="{{route("post_package_add")}}"--}}
{{--                                      method="post" redirect_url="{{route("get_orders")}}"--}}
{{--                                      enctype="multipart/form-data">--}}
{{--                                    @csrf--}}
{{--                                    <div class="order-form">--}}
{{--                                        <div class="store-inputs">--}}
{{--                                            <div class="form-group field-userorder-country">--}}
{{--                                                <div id="userorder-country"--}}
{{--                                                     class="checkCountry"--}}
{{--                                                     onchange="getOptions({{$categories}})--}}
{{--                                                var country = $(&quot;#userorder-country input:checked&quot;).val()--}}
{{--                                                if(country == &quot;england&quot;){--}}
{{--                                                    alert($(this).attr(&quot;data-error&quot;))--}}
{{--                                                    $(&quot;#userorder-country input:first&quot;).prop(&quot;checked&quot;, true)--}}
{{--                                                    return false;--}}
{{--                                                }--}}

{{--                                                if(country == &quot;england&quot;){--}}
{{--                                                    alert($(this).attr(&quot;data-error&quot;))--}}
{{--                                                    $(&quot;#userorder-country input:first&quot;).prop(&quot;checked&quot;, true)--}}
{{--                                                    return false;--}}
{{--                                                }--}}

{{--                                                // $.get(&quot;/az/account/get-country-shop&quot;,{&quot;country&quot;: country },function(data)--}}
{{--                                                // {--}}
{{--                                                //     $(&quot;#userorder-shop_title&quot;).html(data);--}}
{{--                                                // });--}}
{{--                                            ">--}}
{{--                                                    @php($country_count = 0)--}}
{{--                                                    @foreach($countries as $country)--}}
{{--                                                        @php($country_count++)--}}
{{--                                                        @php($country_checked = '')--}}
{{--                                                        @if($country_count == 1)--}}
{{--                                                            @php($country_checked = 'checked')--}}
{{--                                                        @endif--}}
{{--                                                        <div class="country-box">--}}
{{--                                                            <input {{$country_checked}} type="radio"--}}
{{--                                                                   name="country_id"--}}
{{--                                                                   value="{{$country->id}}"--}}
{{--                                                                   id="country_{{$country->id}}">--}}
{{--                                                            <label for="country_{{$country->id}}"--}}
{{--                                                                   class="country-option flex align-items-center justify-content-center">--}}
{{--                                                            <span class="country-flag"--}}
{{--                                                                  style="background: url({{$country->flag}});"></span>{{$country->name}}--}}
{{--                                                                <i class="far fa-check-circle"></i>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                                <div class="form-element row">--}}
{{--                                                    <div class="col-md-6">--}}
{{--                                                        <div--}}
{{--                                                            class="form-group field-userorder-tracking_id required has-error">--}}
{{--                                                            <input type="text" id="track"--}}
{{--                                                                   class="form-control" name="track"--}}
{{--                                                                   placeholder="{!! __('inputs.tracking_id') !!}" required>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-6 store-selection">--}}
{{--                                                        <div--}}
{{--                                                            class="form-group field-userorder-shop_title required has-error">--}}
{{--                                                            <div class="calculate-input-block for-select">--}}
{{--                                                                <select id="seller_id" class="form-control" required--}}
{{--                                                                        name="seller_id"--}}
{{--                                                                        oninput="show_other_seller_input(this);">--}}
{{--                                                                    <option value="">{!! __('inputs.seller_name') !!}</option>--}}
{{--                                                                    @foreach($sellers as $seller)--}}
{{--                                                                        <option--}}
{{--                                                                            value="{{$seller->id}}">{{$seller->title}}</option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                    <option value="0">{!! __('static.other') !!}...</option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="form-element" id="other_seller_area" style="display: none;">--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div--}}
{{--                                                                class="form-group field-userorder-category_id required">--}}
{{--                                                                <div--}}
{{--                                                                    class="calculate-input-block for-select">--}}
{{--                                                                    <input type="text" id="other_seller"--}}
{{--                                                                           class="form-control"--}}
{{--                                                                           name="other_seller"--}}
{{--                                                                           placeholder="{!! __('inputs.seller_name') !!}"--}}
{{--                                                                           maxlength="255">--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="order-product-list">--}}
{{--                                                    <div class="list-item">--}}
{{--                                                        <div class="form-element ">--}}
{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-md-12">--}}
{{--                                                                    <div--}}
{{--                                                                        class="form-group field-userorder-category_id required">--}}
{{--                                                                        <div--}}
{{--                                                                            class="calculate-input-block for-select">--}}
{{--                                                                            <select id="category_id"--}}
{{--                                                                                    class="form-control"--}}
{{--                                                                                    name="category_id"--}}
{{--                                                                                    required>--}}
{{--                                                                                <option value="">{!! __('inputs.select_category') !!}</option>--}}
{{--                                                                                    @foreach($categories as $category)--}}
{{--                                                                                        <option class="category-option" value="{{$category['id']}}">{{$category['name']}}</option>--}}
{{--                                                                                    @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="form-element">--}}
{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-md-12">--}}
{{--                                                                    <div--}}
{{--                                                                        class="form-group field-userorder-product_name required">--}}
{{--                                                                        <label class="control-label"--}}
{{--                                                                               for="title">{!! __('labels.product_name') !!}</label>--}}
{{--                                                                        <input type="text" id="title"--}}
{{--                                                                               class="form-control"--}}
{{--                                                                               name="title"--}}
{{--                                                                               placeholder="{!! __('labels.product_name') !!}"--}}
{{--                                                                               required>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-6">--}}
{{--                                                                    <div--}}
{{--                                                                        class="form-group field-userorder-product_count required">--}}
{{--                                                                        <label class="control-label"--}}
{{--                                                                               for="quantity">Məhsulun--}}
{{--                                                                            sayı</label>--}}
{{--                                                                        <input type="number" id="quantity"--}}
{{--                                                                               class="form-control"--}}
{{--                                                                               name="quantity"--}}
{{--                                                                               placeholder="Məhsulun sayı"--}}
{{--                                                                               required--}}
{{--                                                                               min="0">--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-6 order-amount order-amount-dollar">--}}
{{--                                                                    <div class="form-group field-userorder-amount">--}}
{{--                                                                        <label class="control-label" for="price">{!! __('labels.invoice') !!}</label>--}}
{{--                                                                        <input type="number" id="price"--}}
{{--                                                                               class="form-control"--}}
{{--                                                                               name="price"--}}
{{--                                                                               required--}}
{{--                                                                               placeholder='{!! __('labels.invoice') !!}'--}}
{{--                                                                               step="0.01"--}}
{{--                                                                               min="0">--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-6">--}}
{{--                                                                    <div--}}
{{--                                                                        class="form-group field-userorder-category_id required">--}}
{{--                                                                        <label class="control-label" for="currency_id">{!! __('labels.currency') !!}</label>--}}
{{--                                                                        <div class="calculate-input-block for-select">--}}
{{--                                                                            <select id="currency_id"--}}
{{--                                                                                    class="form-control"--}}
{{--                                                                                    name="currency_id"--}}
{{--                                                                                    required>--}}
{{--                                                                                <option value="">{!! __('inputs.select_currency') !!}</option>--}}
{{--                                                                                @foreach($currencies as $currency)--}}
{{--                                                                                    <option--}}
{{--                                                                                        value="{{$currency->id}}">{{$currency->name}}</option>--}}
{{--                                                                                @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-12">--}}
{{--                                                                    <div--}}
{{--                                                                        class="form-group field-userorder-amount">--}}
{{--                                                                        <label class="control-label"--}}
{{--                                                                               for="invoice">{!! __('labels.file') !!}</label>--}}
{{--                                                                        <input type="file" id="invoice"--}}
{{--                                                                               class="form-control"--}}
{{--                                                                               name="invoice" required>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="form-group field-userorder-comment">--}}
{{--                                        <textarea id="remark" class="store-textarea" name="remark"--}}
{{--                                                  placeholder="{!! __('inputs.remark') !!}" maxlength="5000"></textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="order-button">--}}
{{--                                                <button type="submit" class="orange-button"> {!! __('buttons.save') !!}</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')

@endsection

@section('js')

@endsection
