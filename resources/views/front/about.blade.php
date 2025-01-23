@extends('front.app')
@section('content')
	<section class="content-page-section">
			<div class="container">
				<div class="row">
					<!-- page title end-->
					<div class="col-md-10 about_container">
						<div class="row">
							<div class="col-md-12 about_box">
								<div class="about_img">
									<img src="{{asset("front/image/about_img3.jpg")}}">
								</div>

							</div>
							<div class="about_desc">

								<div class="about_desc-main">
									{!! __('static.about_us') !!}
								<div>
										<hr />
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
