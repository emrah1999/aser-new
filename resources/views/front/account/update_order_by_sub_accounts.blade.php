@extends('front.app')
@section('content')
    <section class="content-page-section">

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
                        @php($disable_input = '')
                        @if($package->internal_id != null && $package->last_status_id != 6 && $package->last_status_id != 9)
                            @php($disable_input = 'disabled')
                        @endif
                        @if($package->seller_id == 0)
                            @php($seller_id_required = '')
                            @php($other_seller_required = 'required')
                        @else
                            @php($seller_id_required = 'required')
                            @php($other_seller_required = '')
                        @endif

                        <div class="page-content-right">
                            <div class="order-block profile-information-block">
                                <div class="order-form-header">
                                    <h3> {!! __('account_menu.declaration') !!} </h3>
                                </div>
                                <form id="preliminary_declaration_form" action="{{route("post_package_update_by_sub_accounts", $package->id)}}" method="post" redirect_url="{{route("get_orders_by_sub_accounts")}}">
                                    @csrf
                                    <div class="order-form">
                                        <div class="store-inputs">
                                            <div class="form-element row">
                                                <div class="col-md-6">
                                                    <div class="form-group field-userorder-tracking_id required has-error">
                                                        <input type="text" id="track" class="form-control" placeholder="Tracking ID" value="{{$package->track}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 store-selection">
                                                    <div class="form-group field-userorder-shop_title required has-error">
                                                        <div class="calculate-input-block for-select">
                                                            <select id="seller_id" class="form-control" name="seller_id" {{$disable_input}} {{$seller_id_required}} oninput="show_other_seller_input(this);">
                                                                <option value="">{!! __('inputs.seller_name') !!}</option>
                                                                @foreach($sellers as $seller)
                                                                    @if($package->seller_id == $seller->id)
                                                                        <option selected value="{{$seller->id}}">{{$seller->title}}</option>
                                                                    @else
                                                                        <option value="{{$seller->id}}">{{$seller->title}}</option>
                                                                    @endif
                                                                @endforeach
                                                                @if($package->seller_id == 0)
                                                                    @php($other_seller_display = 'block')
                                                                    <option selected value="0">Digər...</option>
                                                                @else
                                                                    @php($other_seller_display = 'none')
                                                                    <option value="0">{!! __('static.other') !!}...</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-element" id="other_seller_area" style="display: {{$other_seller_display}};">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group field-userorder-category_id required">
                                                            <div class="calculate-input-block for-select">
                                                                <input {{$other_seller_required}} type="text" id="other_seller" class="form-control" name="other_seller" placeholder="{!! ('inputs.seller_name') !!}" maxlength="255" value="{{$package->other_seller}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-product-list">
                                                <div class="list-item">
                                                    <div class="form-element ">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group field-userorder-category_id required">
                                                                    <div class="calculate-input-block for-select">
                                                                        <select id="category_id" class="form-control" name="category_id" required {{$disable_input}}>
                                                                            <option value="">{!! __('inputs.select_category') !!}</option>
                                                                            @foreach($categories as $category)
                                                                                @if($category->id == $package->category_id)
                                                                                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                                                                                @else
                                                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-element">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group field-userorder-product_name required">
                                                                    <label class="control-label" for="title">{!! __('labels.product_name') !!}</label>
                                                                    <input type="text" id="title" class="form-control" name="title" placeholder="{!! __('labels.product_name') !!}" required value="{{$package->title}}" {{$disable_input}}>
                                                                </div>
                                                            </div>
{{--                                                            <div class="col-md-6">--}}
{{--                                                                <div--}}
{{--                                                                    class="form-group field-userorder-product_count required">--}}
{{--                                                                    <label class="control-label" for="quantity">Məhsulun sayı</label>--}}
{{--                                                                    <input type="number" id="quantity" class="form-control" name="quantity" placeholder="Məhsulun sayı" required min="0" value="{{$package->quantity}}" {{$disable_input}}>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
                                                            <div class="col-md-6">
                                                                <div class="form-group field-userorder-amount">
                                                                    <label class="control-label" for="price">{!! __('labels.invoice') !!} (<span id="currency">{{$package->currency}}</span>) </label>
                                                                    <input type="number" id="price" class="form-control" name="price" placeholder='{!! __('labels.invoice') !!}' step="0.01" min="0" value="{{$package->price}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group field-userorder-category_id required">
                                                                    <label class="control-label" for="currency_id">{!! __('labels.currency') !!}</label>
                                                                    <div class="calculate-input-block for-select">
                                                                        <select id="currency_id"
                                                                                class="form-control"
                                                                                name="currency_id"
                                                                                required>
                                                                            <option value="">{!! __('inputs.select_currency') !!}</option>
                                                                            @foreach($currencies as $currency)
                                                                                @if($currency->id == $package->currency_id)
                                                                                    <option selected value="{{$currency->id}}">{{$currency->name}}</option>
                                                                                @else
                                                                                    <option value="{{$currency->id}}">{{$currency->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group field-userorder-amount">
                                                                    <label class="control-label" for="invoice">{!! __('labels.file') !!}</label>
                                                                    <input type="file" id="invoice" class="form-control" name="invoice">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group field-userorder-comment">
                                                <textarea id="remark" class="store-textarea" name="remark" placeholder="{!! __('inputs.remark') !!}" maxlength="5000" {{$disable_input}}>{{$package->remark}}</textarea>
                                            </div>
                                            <div class="uploaded-list">
                                                <label>{!! __('labels.uploaded_files') !!}</label>
                                                <br>
                                                <div id="current-gallery" class="qq-gallery">
                                                    @php($ext_arr = ['png' ,'jpg' ,'jpeg'])
                                                    @php($doc_parse = explode('.', $package->invoice_doc))
                                                    @php($doc_ext = $doc_parse[count($doc_parse) - 1])
                                                    @if(in_array($doc_ext, $ext_arr))
                                                        <div class="qq-thumbnail-wrapper announce-img">
                                                            <a target="_blank" href="{{$package->invoice_doc}}">
                                                                <img class="qq-thumbnail-selector"style="max-width: 200px;max-height: 200px"  src="{{$package->invoice_doc}}">
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="qq-thumbnail-wrapper announce-img">
                                                            <a target="_blank" href="{{$package->invoice_doc}}">
                                                                <img class="qq-thumbnail-selector" style="max-width: 200px;max-height: 200px" src="/uploads/static/download.png">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-button">
                                            <button type="submit" class="orange-button"> {!! __('buttons.save') !!}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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