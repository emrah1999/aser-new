@extends('front.app')
@section('content')
	<section class="content-page-section">
		<!-- brand crumb -->
		<!-- <div class="brandcrumb-block">
			<div class="container">
				<div class="row space-between">
					<ul class="brandcrumb-ul">
						<li><a href="{{route("home_page")}}"> {!! __('static.aser') !!} </a></li>
						<li>{!! __('account_menu.update_user_details') !!}</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="page-content-header">
			<div class="container">
				<div class="row">
					<div class="page-content-text">
						<h3> {!! __('account_menu.update_user_details') !!} </h3>
					</div>
				</div>
			</div>
		</div> -->

		<div class="page-content-block">
			<div class="container-fluid page_containers ">
				<div class="row">
					<div class="page-content-part">
						@include('front.account.account_left_bar')

						<div class="page-content-right">
							<div class="order-block profile-information-block">
								<form id="update_user_details_form" method="post" action="{{route("post_update_user_account")}}">
									@csrf
									<div class="order-form">
										<div class="store-inputs">
												<div class="form-group field-userorder-country">
												<div class="order-product-list">
													<div class="list-item">
														<div class="form-element">
															<div class="row">
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label"
																		       for="name">{!! __('register.input_name') !!}</label>
																		<input type="text" id="name" disabled readonly
																		       value="{{Auth::user()->name}}">
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label" for="surname">{!! __('register.input_surname') !!}</label>
																		<input type="text" id="surname" disabled
																		       readonly
																		       value="{{Auth::user()->surname}}">
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																		<div class="form-group field-userorder-product_count required">
																			<label class="control-label"
																				   for="passport_prefix">{!! __('register.input_passport_no') !!}</label>
																			<input type="text" name="passport_prefix" id="passport_prefix"
																				   value="{{Auth::user()->passport_series}}">
																		</div>
																	</div>
																	<div class="col-md-6 user_change_info">
																		<div class="form-group field-userorder-product_count required">
																			<label class="control-label"
																				   for="passport_number">{!! __('register.input_passport_no') !!}</label>
																			<input type="text" id="passport_number" name="passport_number"
																				   value="{{Auth::user()->passport_number}}">
																		</div>
																	</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label" for="passport_fin">{!! __('register.input_passport_fin') !!}</label>
																		<input type="text" id="passport_fin"
																		       name="passport_fin"
																		       
																		       value="{{Auth::user()->passport_fin}}" readonly disabled>
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label" for="birthday">{!! __('register.input_birthday') !!}</label>
																		<input type="date" id="birthday" name="birthday" pattern="\d{2}-\d{2}-\d{4}" value="{{ Auth::user()->birthday }}">
																		<span class="date-icon">&#x1F4C5;</span>
																		<div class="invalid-feedback"></div>
																	</div>
																</div>

																
																<div class="col-md-12 user_change_info">
																	<div class="form-group field-userorder-comment">
																		<div class="form-group field-userorder-amount">
																			<label class="control-label" id="address_label" for="address">{!! __('register.input_address') !!}</label>
																			<input type="text" name="address" class="form-control" id="address" value="{{Auth::user()->address1}}" placeholder="Type address..." />
																			
																		</div>
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	@php($phone1 = Auth::user()->phone1)
																	@if(strlen($phone1) > 3)
																		@php($phone1 = '0' . substr($phone1, 3))
																	@endif
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label" for="phone1">{!! __('register.input_phone1') !!} *</label>
																		<input type="text" name="phone1" id="phone1"
																		       value="{{$phone1}}"
																		       disabled readonly>
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	@php($phone2 = Auth::user()->phone2)
																	@if(isset($phone2) && strlen($phone2) > 3)
																		@php($phone2 = '0' . substr($phone2, 3))
																	@endif
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label" for="phone2">{!! __('register.input_phone2') !!}</label>
																		<input type="text" name="phone2" id="phone2"
																		       value="{{$phone2}}">
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-category_id required">
																		<label class="control-label" for="language">{!! __('register.input_language') !!} *</label>
																		<div class="calculate-input-block for-select">
																			<select id="language" class="form-control"
																			        name="language" required>
																				@switch(Auth::user()->language)
																					@case('AZ')
																					<option selected value="AZ">AZ
																					</option>
																					<option value="EN">EN</option>
																					<option value="RU">RU</option>
																					@break
																					@case('EN')
																					<option value="AZ">AZ</option>
																					<option selected value="EN">EN
																					</option>
																					<option value="RU">RU</option>
																					@break
																					@case('RU')
																					<option value="AZ">AZ</option>
																					<option value="EN">EN</option>
																					<option selected value="RU">RU
																					</option>
																					@break
																				@endswitch
																			</select>
																			<span class="select-icon">&#9660;</span>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-category_id required">
																		<label class="control-label" for="branch_id">Filiallar *</label>
																		<div class="calculate-input-block for-select">
																			<select id="branch_id" class="form-control"
																					name="branch_id" required>
																				<option value="">Filial seç</option>
																				@foreach($branchs as $branch)
																					<option value="{{$branch->id}}" {{ isset(Auth::user()->branch_id) && Auth::user()->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
																				@endforeach
																			</select>
																			<span class="select-icon">&#9660;</span>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label"
																		       for="email">{!! __('register.input_email') !!}</label>
																		<input type="text" id="email"
																		       value="{{Auth::user()->email}}">
																	</div>
																</div>
																<div class="col-md-6 user_change_info">
																	<div class="form-group field-userorder-product_count required">
																		<label class="control-label" for="password">{!! __('register.input_password') !!}</label>
																		<input type="password" name="password"
																		       id="password" value="">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="order-button">
													<button type="submit"
													        class="orange-button"> {!! __('buttons.save') !!}</button>
												</div>
											</div>
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
<style>
	.date-container {
		position: relative;
	}
	.date-icon {
		position: absolute;
		top: 55%;
		right: 19px;
		transform: translateY(-50%);
		pointer-events: none;
		color: #aaa;
	}
	.select-icon {
		position: absolute;
		top: 53%;
		right: 12px;
		pointer-events: none;
		transform: translateY(-50%);
		font-size: 15px;
		color: #666;
	}
	.user_change_info{
		padding: 15px;
	}
	.field-userorder-country>* input, .field-userorder-country>* select, .field-userorder-country>* textarea{
		border-radius: 0 !important;
	}
	.list-item {
		box-shadow: 0 !important;
	}

	.user_change_info {
		position: relative;
	}

	#birthday {
		width: 100%;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 4px;
		font-size: 16px;
	}

	#birthday::-webkit-inner-spin-button,
	#birthday::-webkit-calendar-picker-indicator {
		display: none;
		-webkit-appearance: none;
	}

	@media (max-width: 767px) {
		#birthday {
			font-size: 14px;
			padding: 8px;
		}
	}

	.order-button{
		padding: 0 30px;
	}
	.order-button a.orange-button, .order-button button.orange-button {
		padding: 13px 20px;
		text-align: center;
		/* min-width: 214px; */
		border-radius: 20px;
		font-size: 15px;
		font-family: 'kanit-regular', sans-serif;
		color: #fff;
		width: 100%;
	}

	.flatpickr-input {
		padding-right: 40px;
	}

	.flatpickr-calendar {
		z-index: 1000;
	}
</style>
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.4-beta.33/jquery.inputmask.min.js"></script>
	<script defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAfz-DTeJFbN0ZUnDLrpxZLb3nlDvA0uO8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

	<script>
		$(document).ready(function() {

			if (!Modernizr.inputtypes.date) {
				$("#birthday").datepicker({
					dateFormat: 'dd-mm-yy',
					onSelect: function(dateText, inst) {
						var dateObject = $(this).datepicker('getDate');
						var formattedDate = $.datepicker.formatDate('yy-mm-dd', dateObject);

						console.log('Backend format: ' + formattedDate);

						$("#datepicker").val(formattedDate);
					}
				});
			} else {
				$("#datepicker").on("change", function() {
					var dateObject = new Date($(this).val());
					var formattedDate = $.datepicker.formatDate('yy-mm-dd', dateObject);

					console.log('Backend format: ' + formattedDate);

					$(this).val(formattedDate);
				});
			}


			$("#dateForm").on("submit", function(event) {
				var dateInput = $("#datepicker").val();
				if (dateInput.match(/^\d{2}-\d{2}-\d{4}$/)) {
					var parts = dateInput.split("-");
					var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
					$("#datepicker").val(formattedDate);
				}
			});
		});
	</script>
	<script>
    $('#phone1')
      .inputmask({ 'mask': '(999)-999-99-99' })
    $('#phone2')
      .inputmask({ 'mask': '(999)-999-99-99' })
    $(document)
      .ready(function () {
        $(window)
          .keydown(function (event) {
            if (event.keyCode === 13) {
              event.preventDefault()
              return false
            }
          })
      })
    var searchInput = 'address'

    // $(document)
    //   .ready(function () {
    //     var autocomplete
    //     autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
    //       types                : ['geocode'],
    //       componentRestrictions: {
    //         country: 'AZE'
    //       }
    //     })
    //     /*$(document)
    //       .on('input', '#' + searchInput, function () {
    //         document.getElementById('address_label').style.color = 'red'

    //         document.getElementById('location_latitude').value  = ''
    //         document.getElementById('location_longitude').value = ''

    //         /!*document.getElementById('latitude_view').innerHTML  = ''
    //         document.getElementById('longitude_view').innerHTML = ''*!/
    //       })*/
    //     google.maps.event.addListener(autocomplete, 'place_changed', function () {
    //       var near_place = autocomplete.getPlace()
    //       /*if (near_place.geometry) {
    //         document.getElementById('address_label').style.color = 'black'
    //       }*/
    //       setTimeout(() => {
    //         document.getElementById('location_latitude').value  = near_place.geometry.location.lat()
    //         document.getElementById('location_longitude').value = near_place.geometry.location.lng()

    //         /*document.getElementById('latitude_view').innerHTML  = near_place.geometry.location.lat()
    //         document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng()*/
    //       }, 10)
    //     })
    //   })

	</script>
	{{--<script>
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    var searchInput = 'address'


add &callback=initMap

    function initMap () {
      var map   = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -33.8688, lng: 151.2195 },
        zoom  : 13
      })
      var card  = document.getElementById('pac-card')
      var input = document.getElementById('address')

      map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card)

      var autocomplete = new google.maps.places.Autocomplete(input, {
        types                : ['geocode'],
        componentRestrictions: {
          country: 'AZE'
        }
      })
      var addr         = `{{Auth::user()->address1}}`
      var latt         ={{Auth::user()->location_latitude}}
      var long = ({{Auth::user()->location_longitude}})

      // Bind the map's bounds (viewport) property to the autocomplete object,
      // so that the autocomplete requests use the current map bounds for the
      // bounds option in the request.
      autocomplete.bindTo('bounds', map)

      // Set the data fields to return when the user selects a place.
      autocomplete.setFields(
        ['address_components', 'geometry', 'icon', 'name'])

      var infowindow        = new google.maps.InfoWindow()
      var infowindowContent = document.getElementById('infowindow-content')
      infowindow.setContent(infowindowContent)
      var marker = new google.maps.Marker({
        map        : map,
        anchorPoint: new google.maps.Point(0, -29)
      })
      if ({{!!Auth::user()->location_latitude}}) {
        console.log(1)
        console.log(latt)
        console.log(long)
        marker.setPosition({ lat: latt, lng: long })
        map.setCenter({ lat: latt, lng: long })
        map.setZoom(16)
        marker.setVisible(true)
        infowindowContent.children['place-address'].textContent = addr
        // infowindowContent.children['place-icon'].src            = 'place.icon'
        infowindowContent.children['place-name'].textContent    = addr
        infowindow.open(map, marker)
      }
      autocomplete.addListener('place_changed', function () {
        infowindow.close()

        marker.setVisible(false)
        var place = autocomplete.getPlace()

        document.getElementById('location_latitude').value  = place.geometry.location.lat()
        document.getElementById('location_longitude').value = place.geometry.location.lng()

        document.getElementById('latitude_view').innerHTML  = place.geometry.location.lat()
        document.getElementById('longitude_view').innerHTML = place.geometry.location.lng()

        if (!place.geometry) {
          // User entered the name of a Place that was not suggested and
          // pressed the Enter key, or the Place Details request failed.
          window.alert('No details available for input: \'' + place.name + '\'')
          return
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport)
        } else {
          map.setCenter(place.geometry.location)
          map.setZoom(17)  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location)
        marker.setVisible(true)

        var addressMarker = ''
        if (place.address_components) {
          addressMarker = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
          ].join(' ')
        }

        infowindowContent.children['place-icon'].src            = place.icon
        infowindowContent.children['place-name'].textContent    = place.name
        infowindowContent.children['place-address'].textContent = addressMarker
        infowindow.open(map, marker)
      })

      $(document)
        .on('change', '#' + searchInput, function () {
          document.getElementById('location_latitude').value  = ''
          document.getElementById('location_longitude').value = ''
          console.log(11)
          document.getElementById('latitude_view').innerHTML  = ''
          document.getElementById('longitude_view').innerHTML = ''
        })
    }
	</script>--}}
@endsection
