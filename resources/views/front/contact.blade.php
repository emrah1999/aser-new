@extends('front.app')
@section('content')
	<section class="content-page-section padding-bottom-0">

		{{-- <div class="container contact-map-block" id="contact-map" data-coordinate="41.380252, 49.8565326">  <!--  map --> </div> --}}
		<div class="contact-page-block">
			<div class="container">
				<div class="row">
					<div class="contact-page-part">
					<div class="contact-page-right">
							<ul class="footer-menu-ul contact-ul">
								<li>
									<ul class="child-ul">
										<li><span class="address">  <strong>{!! __('static.address') !!}: </strong> {!! __('static.address_text_footer') !!} </span>
										</li>
										<li><span class="phone"> <strong>{!! __('static.phone') !!}:</strong>  (+99412) 310 07 09 </span></li>
										<li><span class="email"> <strong>{!! __('static.email') !!}: </strong> </span><a
															href="mailto:info@asercargo.az"> info@asercargo.az </a></li>
									</ul>
									<span class="job-time"> {!! $general_settings->{"working_hours_" . \Illuminate\Support\Facades\App::getLocale()} !!} </span>

									<ul class="footer_social mobile_show_social">
										<li>
											<a href="https://www.facebook.com/" target="_blank" class="fb">
												<i class="fab fa-facebook-f" aria-hidden="true"></i>
											</a>
										</li>
										<li>
											<a href="#" target="_blank" class="tw">
												<i class="fab fa-twitter" aria-hidden="true"></i>
											</a>
										</li>
										<li>
											<a href="https://www.instagram.com/" target="_blank" class="inst">
												<i class="fab fa-instagram" aria-hidden="true"></i>
											</a>
										</li>
										<li>
											<a href="https://www.youtube.com/" target="_blank" class="youtube">
												<i class="fab fa-youtube" aria-hidden="true"></i>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="col-lg-6 col-md-12">
                
						<div class="contact-page-left">
						
							<div class="contact-form-block spinner ajax-form orange-spinner">
								<form id="contact-form" action="{{route("contact_message")}}" method="post" role="form"
								      class="validate">
									@csrf
									<fieldset class="form-success">
										<h4 id="success-message"></h4>
									</fieldset>

									<fieldset class="contact_fieldset">
										<input type="text" id="contactform-name_surname" class="static-input floating-input"
										       name="name" placeholder=""
										       aria-required="true">
											   <label class="animate_label">{!! __('inputs.name_surname') !!}</label>
									</fieldset>
									<fieldset class="contact_fieldset">

										<input type="text" id="contactform-email" class="static-input floating-input"
										       name="email" placeholder="" aria-required="true">
											   <label class="animate_label">{!! __('inputs.email') !!}</label>

									</fieldset>
									<fieldset class="contact_fieldset">
										<input type="text" id="contactform-phone_number" class="static-input floating-input"
										       name="phone" placeholder=""
										       aria-required="true">
											   <label class="animate_label">{!! __('inputs.phone') !!}</label>
									</fieldset>
									<fieldset class="contact_fieldset">
										<input type="text" id="contactform-subject" class="static-input floating-input"
										       name="subject" placeholder="" aria-required="true">
											   <label class="animate_label">{!! __('inputs.subject') !!}</label>
									</fieldset>
									<fieldset class="contactform-message contact_fieldset">
                                    <textarea id="contactform-message" class="static-textarea floating-input"
                                              name="message" placeholder=""
                                              aria-required="true"></textarea>
											  <label class="animate_label">{!! __('inputs.message') !!}</label>
									</fieldset>

				
									<button type="submit" class="orange-button">{!! __('buttons.send') !!}</button>
									<span class="response-el"></span>
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
	{{--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;key="></script>--}}
	<script>
    function initMap () {
      var myLatLng = { lat: 40.480252, lng: 49.856326 }

      var map        = new google.maps.Map(document.getElementById('contact-map'), {
        zoom  : 14,
        center: myLatLng
      })
      var infowindow = new google.maps.InfoWindow({
        content: 'Aser Cargo\n' +
          ',Kuryer xidməti\n' +
          ',Habil Memmedov'
      })
      var marker     = new google.maps.Marker({
        position: myLatLng,
        map     : map,
        title   : 'Aser Cargo'
      })
      marker.addListener('click', function () {
        infowindow.open(map, marker)
      })
    }
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfz-DTeJFbN0ZUnDLrpxZLb3nlDvA0uO8&callback=initMap"
	        type="text/javascript"></script>

	{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>--}}
	{{--<script>
			$(".validate").validate({
					rules: {
							"name": "required",
							'phone': "required",
							"subject": "required",
							"message": "required",
							"email": {
									required: true,
									email: true
							}
					},
					messages: {
							"name": "Please specify your name and surname",
							'phone': "Please specify your phone number",
							'subject': "Please specify your subject",
							'message': "Please specify your message",
							email: {
									required: "We need your email address to contact you",
									email: "Your email address must be in the format of name@domain.com"
							}
					},
					submitHandler: function (form) {
							$.ajax({
									url: form.action,
									type: form.method,
									data: $(form).serialize(),
									headers: {
											'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									},
									success: function (response) {
											$(".validate").resetForm();
											$("#success-message").html(response.content);
											$(".form-success").css('display', 'block');
									},
							});
					},
					invalidHandler: function () {
							$(".form-success").css('display', 'none');
					}
			});
	</script>--}}
@endsection
