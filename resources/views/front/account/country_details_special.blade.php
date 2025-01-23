@extends('front.app')
@section('content')
	<section class="content-page-section">
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
														<div class="country-block">
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
												<div class="col-md-2 col-xs-12">
													<a href="{{route('get_country_details', 'special')}}" class="country-block-link">
														<div class="country-block selected-country">
															<div class="country-f">
																<img src="https://asercargo.az/front/frontend/web/uploads/images/country/usa.png" alt="">
															</div>
															<div class="c-btn" title="">
																New York
															</div>
														</div>
													</a>
												</div>
										</div>
									</div>

								</div>

								<div class="last-30-day-notf" style="line-height: 20px;">
									Diqqət!!!
									Bu ünvan yalnız Amerikada yaşayan həmyerlilərimiz tərəfindən şəxsi göndərişlər üçün nəzərdə tutulmuşdur. 
									Nyu York vergi ştatı olduğu üçün onlayn sifarişlərinizə vergi hesablanacaqdır. 
									Bu səbəbdən onlayn sifarişləriniz üçün mütləq Delaware ştatındakı anbar ünvanımızı istifadə edin.
								</div>
								<div class="account-address-info">
									<div class="cn-box">
										<div class="row form-element">
											<div class="col-md-3">
												<div class="info-div">
													<p>Full Name:</p>
													<p>{{Auth::user()->full_name()}}</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>Address Line1:</p>
													<p>144 Highlawn Ave Brooklyn NY 11223</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>State/Province/Region:</p>
													<p>NY(New York)</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>Country:</p>
													<p>United States</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>Phone Number:</p>
													<p>+1 (347) 433-33-55</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>Address Line2:</p>
													<p>ASER CARGO EXPRESS AS{{Auth::user()->id}}</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>City:</p>
													<p>New York</p>
												</div>
											</div>
											<div class="col-md-3">
												<div class="info-div">
													<p>ZIP postal code:</p>
													<p>11223</p>
												</div>
											</div>
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


