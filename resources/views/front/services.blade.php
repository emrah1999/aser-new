@extends('front.app')
@section('content')
	<section class="instruction-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section_title">

					{{-- <h5 style="text-align: center;">{!! __('static.our_offer_title') !!}</h5> --}}
				</div>
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4 how_work">
							<div class="how_work_box">
								<div class="overlay"></div>
								<div class="row">
									<div class="col-md-12 hwi">
										<span class="how_w_imgbox hwi_blue"></span>
									</div>
									<div class="col-md-12 hwt">
										<h5>{!! __('static.offer_flight') !!}</h5>
									</div>
									<div class="col-md-12 hwl">
										<ul>
											<li>{!! __('static.offer_flight_title') !!}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4 how_work">
							<div class="how_work_box" style="background-image: url(/front/image/road.jpg) !important;">
								<div class="overlay"></div>
								<div class="row">
									<div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">

                                        </span>
									</div>
									<div class="col-md-12 hwt">
										<h5>{!! __('static.offer_road') !!}</h5>
									</div>
									<div class="col-md-12 hwl">
										<ul>
											<li>{!! __('static.offer_road_title') !!}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 how_work">
							<div class="how_work_box" style="background-image: url(/front/image/deniz.JPG) !important;">
								<div class="overlay"></div>
								<div class="row">
									<div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">

                                        </span>
									</div>
									<div class="col-md-12 hwt">
										<h5>{!! __('static.offer_sea') !!}</h5>
									</div>
									<div class="col-md-12 hwl">
										<ul>
											<li>{!! __('static.offer_sea_title') !!}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>


						<div class="col-md-4 how_work">
							<div class="how_work_box" style="background-image: url(/front/image/anbar.jpg) !important;">
								<div class="overlay"></div>
								<div class="row">
									<div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">

                                        </span>
									</div>
									<div class="col-md-12 hwt">
										<h5>{!! __('static.offer_warehouse') !!}</h5>
									</div>
									<div class="col-md-12 hwl">
										<ul>
											<li>{!! __('static.offer_warehouse_title') !!}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4 how_work">
							<div class="how_work_box" style="background-image: url(/front/image/pickup.jpg) !important;">
								<div class="overlay"></div>
								<div class="row">
									<div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">

                                        </span>
									</div>
									<div class="col-md-12 hwt">
										<h5>{!! __('static.offer_package') !!}</h5>
									</div>
									<div class="col-md-12 hwl">
										<ul>
											<li>{!! __('static.offer_package_title') !!}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4 how_work">
							<div class="how_work_box" style="background-image: url(/front/image/fullfilement.jpg) !important;">
								<div class="overlay"></div>
								<div class="row">
									<div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">

                                        </span>
									</div>
									<div class="col-md-12 hwt">
										<h5>{!! __('static.offer_fullfillment') !!}</h5>
									</div>
									<div class="col-md-12 hwl">
										<ul>
											<li>{!! __('static.offer_fullfillment_title') !!}</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	{{-- <section class="content-page-section">
		<div class="container">
			<div class="row">
				<!-- page title end-->
				<div class="col-md-12 about_container">
					<div class="row">
						<div class="col-md-12 about_box">
							<div class="service_img">
								<img src="{{ asset('front/image/aboutImage.png') }}" alt="About Image">
							</div>
							<div class="col-md-12 service_head_title">
								<h3>{!! __('service.service_head_title') !!}</h3>
							</div>
							<div class="row">
								<div class="col-md-6 service_titles">
									{!! __('service.service_first_title_v1') !!}
								</div>
								<div class="col-md-6 service_titles">
									{!! __('service.service_second_title') !!}
								</div>
							</div> <!-- .row end -->
						</div>
					</div> <!-- .row end -->
				</div>
			</div> <!-- .row end -->
		</div> <!-- .container end -->
	</section> --}}
@endsection



@section('css')

<style>

	.how_work_box {
		position: relative;
		background-image: url("/front/image/aboutImage.png");
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		padding: 30px 15px;
		min-height: 287px;
		border-radius: 15px;
		-webkit-transition: transform 0.5s cubic-bezier(.25, .46, .45, .94), box-shadow 0.5s cubic-bezier(.25, .46, .45, .94);
		-moz-transition: transform 0.5s cubic-bezier(.25, .46, .45, .94), box-shadow 0.5s cubic-bezier(.25, .46, .45, .94);
		transition: transform 0.5s cubic-bezier(.25, .46, .45, .94), box-shadow 0.5s cubic-bezier(.25, .46, .45, .94);
	}

	.how_work_box .overlay {
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		height: 55%;
		background-color: rgb(0 0 0 / 77%);
		transition: height 0.5s ease;
		border-radius: 15px 15px 0 0;
		z-index: 1;
	}

	.how_work_box:hover .overlay {
		height: 100%;
	}

	.how_work_box .row {
		position: relative;
		z-index: 2;
		color: #fff;
	}

	.how_work_box:hover {
		box-shadow: 0 20px 50px 0 rgba(0, 0, 0, 0.08);
		-ms-box-shadow: 0 20px 50px 0 rgba(0, 0, 0, 0.08);
		-moz-box-shadow: 0 20px 50px 0 rgba(0, 0, 0, 0.08);
	}


	.hwt {
		margin-top: 40px;
		margin-bottom: 12px;
	}

	.hwt h5 {
	font-size: 17px;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.33;
	letter-spacing: normal;
	text-align: center;
	color: #fff;
}

.hwl ul li {
	width: 100%;
	font-size: 13px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.36;
	letter-spacing: normal;
	text-align: left;
	color: #fff;
	text-align: center;
	margin-bottom: 6px;
}

.service_img{
	height: 400px;
	margin-bottom: 80px;
}

.service_img img {
	position: relative;
	float: left;
	width: 820px;
	height: 100%;
	object-fit: cover;
	border-radius: 10px;
	z-index: 1;
}

.service_head_title h3{
	position: relative;
	width: 100%;
	margin-bottom: 50px;
	font-size: 28px;
	font-weight: bold;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.32;
	letter-spacing: normal;
	text-align: left;
	color: #2c2c51;
}
.service_titles{
	padding: 15px
}

.service_titles h4{
	display: block;
	color: var(--wd-title-color);
	text-transform: var(--wd-title-transform);
	font-weight: var(--wd-title-font-weight);
	font-style: var(--wd-title-font-style);
	font-family: var(--wd-title-font);
	line-height: 1.4;
}

.service_titles span{
	background-color: transparent;
	color: rgb(0, 0, 0);
	font-family: times new roman;
	font-size: 13pt;
	font-size: 16px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.5;
	letter-spacing: normal;
	text-align: left;
	color: #7b7b93;
}
</style>
@endsection

@section('js')

@endsection
