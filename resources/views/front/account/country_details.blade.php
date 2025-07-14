@extends('front.app')
@section('content')
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
			<div class="container-fluid page_containers">
				<div class="row">
					<div class="page-content-part campaign-content-part">
						@include('front.account.account_left_bar')
						<div class="page-content-right">
							<div class="account-home-top account-home-top-mod">
								<div class="account-home-top">
									<div class="account-address-info account-address-main">
										<div class="row">
											@foreach($countries as $country)
												<div class="col-md-2 col-xs-12">
													<a href="{{route('get_country_details', $country->id)}}" class="country-block-link">
														<div class="country-block @if($country->id == $selected_country->id) selected-country @endif">
															<div class="country-f">
																<img src="{{$country->flag}}" alt="">
															</div>
															<div class="c-btn" title="">
																{{$country->name}}
															</div>
														</div>
													</a>
												</div>
											@endforeach
{{--												<div class="col-md-2 col-xs-12">--}}
{{--													<a href="{{route('get_country_details', 'special')}}" class="country-block-link">--}}
{{--														<div class="country-block">--}}
{{--															<div class="country-f">--}}
{{--																<img src="https://asercargo.az/front/frontend/web/uploads/images/country/usa.png" alt="">--}}
{{--															</div>--}}
{{--															<div class="c-btn" title="">--}}
{{--																New York--}}
{{--															</div>--}}
{{--														</div>--}}
{{--													</a>--}}
{{--												</div>--}}
										</div>
									</div>

								</div>
								@if($selected_country->id == 2 || $selected_country->id == 12)
									<div class="last-30-day-notf" style="line-height: 20px;">
										Qeyd: Bağlamanızın itməsinin qarşısını almaq üçün məhsul  sifariş etdiyiniz mağazanın ünvan bölməsindəki Adress Line 2-də aser ID(AS123XXX) nömrənizi qeyd etmək mütləqdir.
									</div>
								@endif

								<div class="account-address-info">
									<div class="cn-box">
										<div class="row form-element">
											@if(count($details_local)>0)
												<div class="col-md-12">
													<h1>English</h1>
													<br>
												</div>
											@endif
											@foreach($details as $detail)
												@php($information = $detail->information)
												@php($information = str_replace('{name_surname}', Auth::user()->full_name(), $information))
												@php($information = str_replace('{aser_id}', Auth::user()->suite(), $information))

												<div class="col-md-3">
													<div class="info-div">
														<p>{{$detail->title}}</p>
														<p>{{$information}}</p>
													</div>
												</div>
											@endforeach
											@if(count($details_local)>0)
												<div class="col-md-12">
													<br>
													<h1>{{$selected_country->name_en}}</h1>
													<br>
												</div>
												@foreach($details_local as $detail)
													@php($information = $detail->information)
													@php($information = str_replace('{name_surname}', Auth::user()->full_name(), $information))
													@php($information = str_replace('{aser_id}', Auth::user()->suite(), $information))
													@php($title = $detail->title)
													@php($title = str_replace($selected_country->name_en . '_', '', $title))
													<div class="col-md-3">
														<div class="info-div">
															<p>{{$title}}</p>
															<p>{{$information}}</p>
														</div>
													</div>
												@endforeach
											@endif

											{{--@foreach($details as $detail)
												@php($information = $detail->information)
												@php($information = str_replace('{name_surname}', Auth::user()->full_name(), $information))
												@php($information = str_replace('{aser_id}', Auth::user()->suite(), $information))
												<div class="col-md-3">
													<div class="info-div">
														<p>{{$detail->title}}</p>
														<p>{{$information}}</p>
													</div>
												</div>
											@endforeach--}}

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('css')
<style>
.selected-country {
    background-color: #ffce00;
}

.info-div{
	padding: 15px;
}

.info-div p:last-child{
	height: fit-content;
    border-radius: 8px;
    /* border: solid 1px #ddd; */
    background-color: #fbfbfb;
    width: 100%;
    font-size: 13px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #2c2c51;
    display: flex;
    -webkit-display: flex;
    -moz-display: flex;
    -ms-display: flex;
    -o-display: flex;
    align-items: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    -ms-align-items: center;
    -o-align-items: center;
    padding: 22px 15px;
}
</style>
@endsection

@section('js')

@endsection


