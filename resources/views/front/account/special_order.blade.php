@extends('front.app')
@section('content')
	@php($not_paid_count = 0)
	<section class="content-page-section">

		<!-- page content header -->
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
			<div class="container-fluid page_containers ">
				<div class="row">
					<div class="page-content-part campaign-content-part">
						@include("front.account.account_left_bar")
						<div class="page-content-right">
							<div class="n-order-list">

								<div class="n-order-top flex space-between">
									<h1 class="n-order-title"><img src="{{$countrFlag->flag}}" alt=""> {!! __('static.order_title') !!}</h1>

								</div>
								<div class="last-30-day-notf" style="line-height: 20px; margin-top: 0px !important; margin-bottom: 0!important;">
									Mobil telefonların sifarişi “Sifariş et” xidməti ilə qəbul olunmur.
								</div>
								<div class="last-30-day-notf" style="line-height: 20px; margin-top: 0px !important; margin-bottom: 0!important;">
									Bir məhsulun dəyəri 700 ABŞ dollarından yuxarı olan sifarişlər qəbul olunmur.
								</div>

								<div class="n-order-form n-order-form-turkey orange-spinner">
									@if(Request::get('pay') == 'success')
										<div class="alert alert-success">
											<strong>{!! __('static.success') !!}</strong> {!! __('static.paid_success') !!}
										</div>
									@elseif(Request::get('pay') == 'error')
										<div class="alert alert-success">
											<strong>{!! __('static.error') !!}</strong> {!! __('static.paid_error') !!}
										</div>
									@endif
									@if($has_campaign == 1)
										<div class="alert alert-success campaign-text">
											{!! $campaign_text !!}
										</div>
									@endif

									<form id="special_order_form" action="{{route("add_special_order")}}"
									      method="post">
										@csrf
										<input class="effect-20" type="hidden" placeholder="" name="country_id" value="{{$country_id}}">
										<div class="sp-product-list" id="product_list">
											<div class="sp-product-block" id="product_block_1">
												<div class="row n-form-element clearfix">
													<div class="seperate_block col-12 row">
														<div class="col-md-12 col-xs-12 n-margin">
															<div class="input_custom input-effect">
																<input class="effect-20" type="text" placeholder=""
																       name="url[]">
																<label id="url_label">{!! __('labels.url') !!}</label>
																<span class="focus-border"><i></i></span>
															</div>
														</div>
													</div>
													<div class="seperate_block col-12 row">
														<div class="col-md-6 col-xs-12 n-margin">
															<div class="input_custom input-effect">
																<input class="effect-20" type="text" placeholder=""
																       name="size[]">
																<label id="size_label">{!! __('labels.size') !!}</label>
																<span class="focus-border"><i></i></span>
															</div>
														</div>
														<div class="col-md-6 col-xs-12 n-margin">
															<div class="input_custom input-effect">
																<input class="effect-20" type="text" placeholder=""
																       name="color[]">
																<label id="color_label">{!! __('labels.color') !!}</label>
																<span class="focus-border"><i></i></span>
															</div>
														</div>
													</div>
													<div class="seperate_block col-12 row">

														<div class="col-md-3 col-xs-12 n-margin">
															<div class="input_custom input-effect">
																<input class="effect-20" type="number" placeholder=""
																	   oninput="change_price_for_special_product(1);"
																	   name="quantity[]" id="quantity_1" min="1">
																<label id="quantity_label">{!! __('labels.quantity') !!}</label>
																<span class="focus-border"><i></i></span>
															</div>
														</div>
														<div class="col-md-5 col-xs-12 n-margin">
															<div class="input_custom input-effect">
																<input class="effect-20" type="number" step="0.01"
																	   placeholder="" name="price[]" id="price_1"
																	   oninput="change_price_for_special_product(1);"
																	   min="0.01">
																<label id="price_label">{!! __('labels.price') !!}</label>
																<span class="focus-border"><i></i></span>
															</div>
														</div>
														<div class="col-md-4 col-xs-12 n-margin">
															<div class="n-tax-info">+{{$percent}}% = <span
																		class="total_price" price="0"
																		id="total_price_1"> 0 {{$currency_name}} </span>
															</div>
														</div>
													</div>
													<div class="seperate_block col-12 row">
														<div class="col-12">
															<div class="input_custom input-effect">
																<input class="effect-20" type="text" placeholder=""
																       name="description[]">
																<label id="description_label">{!! __('labels.description') !!}</label>
																<span class="focus-border"><i></i></span>
															</div>
														</div>
													</div>
												</div>

												<div class="row" id="product_button_1">
													<div id="new_order_button" style="border-radius: 10px"
													     new_order_button_text="{!! __('buttons.new_order') !!}"
													     remove_order_button_text="{!! __('buttons.remove_order') !!}"
													     class="sp-product-control btn btn-add btn-success"
													     onclick="new_special_product(this, 1);"
													     data-title="{!! __('buttons.remove_order') !!} <i class=&quot;fa fa-minus&quot;></i>">
														{!! __('buttons.new_order') !!} <i class="fa fa-plus"></i>
													</div>
												</div>
											</div>
										</div>

										<hr class="special-order-hr">
										<div class="row n-form-element n-center">
											<div class="col-lg-12 col-xs-12 col-md-12 align-left">

												<div class="total-price">
													{!! __('static.total_price') !!}: <span class="total-price-span"
													                                      id="total_price_span"
													                                      price="0"
													                                      currency_name="{{$currency_name}}"
													                                      percent="{{$percent}}">0.00 </span> {{$currency_name}}
												</div>

											</div>
											<div class="col-lg-12 col-xs-12 col-md-12">
												<div class="def-label field-register-checkbox required"
												     style="float: left;">
                                                    <span><input type="checkbox" id="register-checkbox" name="agreement"
                                                                 required>
                                                        <label for="register-checkbox" class="def-checkbox">
                                                            <a target="_blank" style="color: #f4a51c;"
                                                               href="/uploads/static/aser_order_terms_aze.pdf">{!! __('static.rules_text') !!}.*</a>
                                                        </label>
                                                    </span>
												</div>
												<button type="submit"
												        class="btn btn-n-order" id="submitSpecial">{!! __('buttons.pay_for_special_order') !!}</button>
											</div>
										</div>

									</form>

								</div>

								<div class="orange-spinner order-list-table">
									<div class="order-btn" style="border-radius: 10px">
										@if(Request::get('archive') == 'yes')
											<a href="{{route("special_order", $country_id) . "?archive=no"}}"
											   class="btn btn-success"
											   style="background-color: #ffce00; border-color: #ffce00; float: right; margin: 0 25px 15px 0;">{!! __('buttons.current_orders') !!}</a>
										@else
											<a href="{{route("special_order", $country_id) . "?archive=yes"}}"
											   class="btn btn-success"
											   style="background-color: #ffce00; border-color: #ffce00; float: right; margin: 0 25px 15px 0;">{!! __('buttons.orders_history') !!}</a>
										@endif
									</div>
									@if(count($orders) > 0)
										<div class="n-order-table sp-order-table desktop-show" style="overflow-x: auto;">
											<table>
												<thead>
												<tr>
													<th>{!! __('table.id') !!}</th>
													<th>{!! __('table.url') !!}</th>
													<th>{!! __('table.price') !!}</th>
													<th>{!! __('table.debt') !!}</th>
													<th>{!! __('table.status') !!}</th>
													<th>{!! __('table.amount_for_special_order') !!}</th>
													<th>{!! __('table.pay') !!}</th>
													<th>{!! __('table.actions') !!}</th>
												</tr>
												</thead>
												<tbody>
												@foreach($orders as $order)
													<tr class="order_{{$order->id}}">
														<td>{{$order->id}}</td>
														<td>
															@php($urls = $order->urls)
															@php($url_arr = explode(',', $urls))
															@for($i = 0; $i < count($url_arr); $i++)
																@php($url = $url_arr[$i])
																@php($url_show = $url)
																@if(strlen($url) > 20)
																	@php($url_show = substr($url, 0, 20) . '...')
																@endif
																<p>
																	<a href="{{$url}}" target="_blank">{{$url_show}}</a>
																</p>
															@endfor
														</td>
														<td class="strong-p">
															{{$order->price}} {{$order->currency}}
															{{--                                                            <span class="price-block"> ({{$order->price_azn}} AZN)</span>--}}
														</td>
														<td class="strong-p">
															{{$order->cargo_debt + $order->common_debt}} {{$order->currency}}
															{{--                                                            <span class="price-block"> ({{$order->cargo_debt_azn + $order->common_debt_azn}} AZN)</span>--}}
														</td>
														{{--                                                        <td class="strong-p">--}}
														{{--                                                            {{$order->cargo_debt}} {{$order->currency}}<span class="price-block"> ({{$order->cargo_debt_azn}} AZN)</span>--}}
														{{--                                                        </td>--}}
														{{--                                                        <td class="strong-p">--}}
														{{--                                                            {{$order->common_debt}} {{$order->currency}}<span class="price-block"> ({{$order->common_debt_azn}} AZN)</span>--}}
														{{--                                                        </td>--}}
														<td>
                                                            <span class="order-status">
                                                                {{$order->status}}
                                                            </span>
														</td>
														<td>
															{{$order->total_amount}} {{$order->currency}}
															{{--                                                            <span class="price-block">({{$order->total_amount_azn}} AZN)</span>--}}
														</td>
														<td class="order-payment">
															@if(($order->is_paid == 0 || $order->cargo_debt > 0 || $order->common_debt > 0) && $order->waiting_for_payment == 0)
																@php($not_paid_count++)
																<button class="btn"
																        onclick="pay_special_order('{{route("pay_to_special_order", [$country_id, $order->id])}}', this);">
																	{!! __('buttons.pay') !!}
																</button>
															@else
																<button disabled
																        class="btn">{!! __('static.paid') !!}</button>
															@endif
														</td>
														<td class="order-op">
                                                            <span
				                                                            onclick="show_items_for_special_orders('{{$order->group_code}}', '{{route("show_orders_for_group_special_orders", $country_id)}}');"
				                                                            class="order-view"><i class="fas fa-eye"></i></span>

															@if($order->disable == 0 && $order->is_paid == 0 && $order->waiting_for_payment == 0)
																<a href="{{route("get_special_order_update", [$country_id, $order->id])}}"
																   class="order-update" title=""><i
																					class="fas fa-pencil-alt"></i></a>

																<button class="order-delete-btn"
																        data-confirm="{!! __('static.confirm_delete_for_special_order') !!}"
																        onclick="delete_special_order(this, '{{route("delete_special_order", [$country_id, $order->id])}}');">
																	<i class="fas fa-trash"></i></button>
															@endif
														</td>
													</tr>
												@endforeach
												</tbody>
											</table>
											{{--<div>
												{!! $orders->links(); !!}
											</div>--}}
										</div>

										<div class="mobile-show">
											<div class="order-item">
												<table class="table table-bordered">
													<tbody>
													@foreach($orders as $order)
														<tr>
															<td>{!! __('table.url') !!}</td>
															<td>
																@php($urls = $order->urls)
																@php($url_arr = explode(',', $urls))
																@for($j = 0; $j < count($url_arr); $j++)
																	@php($url = $url_arr[$j])
																	@php($url_show = $url)
																	@if(strlen($url) > 20)
																		@php($url_show = substr($url, 0, 20) . '...')
																	@endif
																	<p>
																		<a href="{{$url}}"
																		   target="_blank">{{$url_show}}</a>
																	</p>
																@endfor
															</td>
														</tr>
														<tr>
															<td>{!! __('table.price') !!}</td>
															<td>
																{{$order->price}} {{$order->currency}}
																<span class="price-block"> ({{$order->price_azn}} AZN)</span>
															</td>
														</tr>
														<tr>
															<td>
																{!! __('table.cargo_debt') !!}
															</td>
															<td>
																{{$order->cargo_debt}} {{$order->currency}}
																<span class="price-block"> ({{$order->cargo_debt_azn}} AZN)</span>
															</td>
														</tr>
														<tr>
															<td>{!! __('table.common_debt') !!}</td>
															<td>
																{{$order->common_debt}} {{$order->currency}}
																<span class="price-block"> ({{$order->common_debt_azn}} AZN)</span>
															</td>
														</tr>
														<tr>
															<td>{!! __('table.status') !!}</td>
															<td>
                                                                <span class="order-status">
                                                                    {{$order->status}}
                                                                </span>
															</td>
														</tr>
														<tr>
															<td>{!! __('table.amount_for_special_order') !!}</td>
															<td>
																{{$order->total_amount}} {{$order->currency}}
																<span class="price-block">({{$order->total_amount_azn}} AZN)</span>
															</td>
														</tr>
														<tr>
															<td>{!! __('table.pay') !!}</td>
															<td class="order-payment">
																@if(($order->is_paid == 0 || $order->cargo_debt > 0 || $order->common_debt > 0) && $order->waiting_for_payment == 0)
																	<button class="btn"
																	        onclick="pay_special_order('{{route("pay_to_special_order", [$country_id, $order->id])}}', this);">
																		{!! __('buttons.pay') !!}
																	</button>
																@else
																	<button disabled
																	        class="btn">{!! __('static.paid') !!}</button>
																@endif
															</td>
														</tr>
														<tr>
															<td>{!! __('table.details') !!}</td>
															<td>
                                                                <span
				                                                                onclick="show_items_for_special_orders('{{$order->group_code}}', '{{route("show_orders_for_group_special_orders", $country_id)}}');"
				                                                                class="order-view"><i
					                                                                class="fas fa-eye"></i></span>
															</td>
														</tr>
														@if($order->disable == 0 && $order->is_paid == 0 && $order->waiting_for_payment == 0)
															<tr>
																<td>{!! __('table.edit') !!}</td>
																<td>
																	<a href="{{route("get_special_order_update", [$country_id, $order->id])}}"
																	   class="order-update" title=""><i
																						class="fas fa-pencil-alt"></i></a>
																</td>
															</tr>
															<tr>
																<td>{!! __('table.delete') !!}</td>
																<td class="order-delete" style="padding-top: 0;">
																	<button class="order-delete-btn"
																	        data-confirm="{!! __('static.confirm_delete_for_special_order') !!}"
																	        onclick="delete_special_order(this, '{{route("delete_special_order", [$country_id, $order->id])}}');">
																		<i class="fas fa-trash"></i></button>
																</td>
															</tr>
														@endif
													@endforeach
													</tbody>
												</table>
												{{--<div>
													{!! $orders->links(); !!}
												</div>--}}
											</div>
										</div>
									@endif
								</div>
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
					<div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding" style="overflow-x: auto;">
						<table class="table table-bordered">
							<thead>
							<tr>
								<th>#</th>
								<th>{!! __('table.url') !!}</th>
								<th>{!! __('table.price') !!}</th>
								<th>{!! __('table.quantity_for_special_order') !!}</th>
								<th>{!! __('table.description') !!}</th>
								<th>{!! __('table.status') !!}</th>
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
@endsection

@section('css')
<style>
.btn-success, .btn-success.disabled, .btn-success:disabled, .show>.btn-outline-success.dropdown-toggle {
    background-color: #51a3da !important;
    border-color: #51a3da !important;
}

.new_order_button:hover{
	background-color: #51a3da !important;
}

.n-form-element button {
	padding: 15px 68px !important;
}

@media only screen and (max-width: 767px) {
    .n-form-element .col-xs-12 {
        margin-bottom: 35px !important;
    }

	.seperate_block {
		margin-bottom: 8px;
	}

	.effect-20:focus~label,
	.has-content.effect-20~label {
		top: -25px;
		left: 0;
		font-size: 12px;
		color: #ffce00;
		transition: 0.3s;
	}
}


</style>
@endsection

@section('js')
	@php($gender_id = Auth::user()->gender())
	@if($gender_id == 0)
		@php($gender = __('static.female'))
	@else
		@php($gender = __('static.male'))
	@endif

	<script>
    special_orders_percent = {{$percent}};

    $(document)
      .ready(function () {
        let not_paid_count = {{$not_paid_count}};

        if (not_paid_count > 0) {
          swal(
            '{!! __('static.attention') !!}!',
            '{!! __('static.special_order_not_paid_orders_attention', ['client' => Auth::user()->name(), 'gender' => $gender, 'count' => $not_paid_count]) !!}',
            'warning'
          )
        }
      })

	</script>
@endsection
