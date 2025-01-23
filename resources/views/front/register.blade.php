@extends('front.app')
@section('content')
	<div id="registration" class="register-section">
		<div class="register-left-panel">
			
		</div>

		<div class="login-right-panel">
			<div class="sign-main">
				<div class="login-form-block only-register ">
					{{-- <div class="form-header" style="display: flex; align-items: center">
						<h4 style="padding-left: 2.3rem">
							<a target="_blank" href="" style="color: #ffce00;">
								Qeydiyyat prosesinə bax
							</a>
						</h4>
					</div> --}}

					@if (session('case'))
						<div class="alert alert-{{ session('case') }}" style="height: 4rem;">
							<strong>{{ session('title') }}</strong> {{ session('content') }}
						</div>
					@endif

					@if ($errors->any())
						<div class="alert alert-danger" style="height: 4rem;">
							<strong>{{ __('static.error') }}!</strong> {{ __('static.error_text') }}
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="container mt-5">
						<div class="row justify-content-center">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header text-white text-center" style="border-radius: 28px;">
										<h4>{!! __('auth.register') !!}</h4>
									</div>
									<div class="card-body">
										<form id="registrationForm" action="{{route("register")}}" method="post">
											@csrf
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="name">{!! __('auth.Name') !!}</label>
													<input type="text" id="name" name="name" class="form-control" required>
													<div class="invalid-feedback"></div>
												</div>
												<div class="form-group col-md-6">
													<label for="surname">{!! __('auth.Surname') !!}</label>
													<input type="text" id="surname" name="surname" class="form-control" required>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="email">{!! __('auth.Email') !!}</label>
													<input type="email" id="email" name="email" class="form-control" required>
													<div class="invalid-feedback"></div>
												</div>
												<div class="form-group col-md-6">
													<label for="phone">{!! __('auth.Phone') !!}</label>
													<input type="tel" id="phone" name="phone1" class="form-control" placeholder="(###)-###-##-##" required>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="phone2">{!! __('auth.Phone2') !!}</label>
													<input type="tel" id="phone2" name="phone2" class="form-control" placeholder="(###)-###-##-##">
													<div class="invalid-feedback"></div>
												</div>
												<div class="form-group col-md-6">
													<label for="birthday">{!! __('auth.Birthday') !!}</label>
													<div class="date-container">
														{{-- <input type="text" id="birthday" name="birthday"
																class="form-control" required placeholder="dd-mm-yyyy"> --}}
														<input class="form-text-field" type="date"  id="birthday" name="birthday" pattern="\d{2}-\d{2}-\d{4}">
														<span class="date-icon">&#x1F4C5;</span>
														<div class="invalid-feedback"></div>
													</div>
												</div>

											</div>
											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="language">{!! __('auth.Language') !!}</label>
													<select id="language" name="language" class="form-control reg_select" required>
														<option value="AZ">AZ</option>
														<option value="EN">EN</option>
														<option value="RU">RU</option>
													</select>
													<span class="select-icon">&#9660;</span>
													<div class="invalid-feedback"></div>
												</div>
												<div class="form-group col-md-4">
													<label for="city">{!! __('auth.City') !!}</label>
													<select id="city" name="city" class="form-control reg_select" required>
														<option value="">Seç</option>
														@foreach($cities as $city)
															<option value="{{$city->name}}">{{$city->name}}</option>
														@endforeach
													</select>
													<span class="select-icon">&#9660;</span>
													<div class="invalid-feedback"></div>
												</div>
												<div class="form-group col-md-4">
													<label for="branch_id">{!! __('auth.branch') !!}</label>
													<select id="branch_id" name="branch_id" class="form-control reg_select" required>
														<option value="">Seç</option>
														@foreach($branchs as $branch)
															<option value="{{$branch->id}}">{{$branch->name}}</option>
														@endforeach
													</select>
													<span class="select-icon">&#9660;</span>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="form-group col-md-12">
												<label for="address">{!! __('auth.Address') !!}</label>
												<input type="text" id="address" name="address1" class="form-control" required>
												<div class="invalid-feedback"></div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-3 col-xs-12 position-relative" style="padding: 15px 15px">
													<label for="passport_number">{!! __('auth.PassportSeries') !!}</label>
													<select id="passport_series" name="passport_series" class="form-control reg_select passport-series-select" required>
														<option value="AA">AA</option>
														<option value="AZE">AZE</option>
														<option value="MYI">MYI</option>
														<option value="DYI">DYI</option>
														<option value="VOEN">VOEN</option>
													</select>
													<span class="select-icon">&#9660;</span>
												</div>

												<div class="form-group col-md-5 col-xs-12 position-relative" style="padding: 15px 15px">
													<label for="passport_number">{!! __('auth.PassportNumber') !!}</label>
													<input type="number" id="passport_number" name="passport_number" class="form-control" required>
													<div class="invalid-feedback"></div>
												</div>

												<div class="form-group col-md-4 col-xs-12">
													<label for="passport_fin">{!! __('auth.PassportFIN') !!}</label>
													<input type="text" id="passport_fin" name="passport_fin" class="form-control" required>
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="gender">{!! __('auth.Gender') !!}</label>
													<select id="gender" name="gender" class="form-control reg_select" required>
														<option value="">{!! __('auth.gender_select') !!}</option>
														<option value="1">{!! __('auth.male') !!}</option>
														<option value="0">{!! __('auth.female') !!}</option>
													</select>
													<span class="select-icon">&#9660;</span>
													<div class="invalid-feedback"></div>
												</div>
												<div class="form-group col-md-6">
													<img src="{{asset('uploads/static/info.png')}}" height="15px" width="15px" data-toggle="tooltip" data-placement="right" title="" style="display: inline-block;" data-original-title="Bu bölmə “Dostunu gətir daha çox qazan” kampaniyası üçün nəzərdə tutulmuşdur. Burada, sizi xidmətimizdən istifadə etmək üçün dəvət edən dostunuzun Aser şəxsi nömrəsi yazılmalı və yaxud xidmətimizdən istifadə üçün sizin dəvət linkinizlə gələn dostlarınız qeydiyyat zamanı linkdə sizə məxsus olan Aser şəxsi nömrənizi qeyd etməlidilər.">
													<label for="parent_code">{!! __('auth.ParentCode') !!}</label>
													<input type="text" id="parent_code" name="parent_code" class="form-control">
													<div class="invalid-feedback"></div>
												</div>
											</div>
											<div class="form-group col-md-12">
												<label for="password">{!! __('auth.Password') !!}</label>
												<input type="password" id="password" name="password" class="form-control" minlength="8" required>
												<div class="invalid-feedback"></div>
											</div>
											<div class="def-label field-register-checkbox required">
												<input type="checkbox" id="register-checkbox" name="agreement" />
												<label class="def-checkbox" for="register-checkbox">
													<a target="_blank" href="">{!! __('auth.agreement') !!}</a>
												</label>
												<p class="agreement_error" id="agreement_error">{!! __('auth.agreement_terms') !!}</p>
											</div>

											<div class="d-flex justify-content-between">
												<button type="submit" class="btn" style="background-color: #ffce00;">{!! __('auth.register') !!}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection

@section('css')
<style>

	.select-icon {
		position: absolute;
		top: 63%;
		right: 23px;
		pointer-events: none;
		transform: translateY(-50%);
		font-size: 15px;
		color: #666;
	}
	.def-checkbox a {
		color: #ffce00;
	}
.card {
  border-radius: 28px;
}

.card-header {
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

.form-check-input {
  margin-top: 0.3em;
}

.form-check-label {
  margin-left: 1.25em;
}

.d-flex {
  margin-top: 20px;
}

#registrationForm .col-md-6{
	padding: 15px 15px;
}

#registrationForm .col-md-12{
	padding: 15px 8px;
}

.reg_select{
	height: 38px !important;
	padding-left: 15px !important;
}

.card input{
	border-radius: 10px;
	border: solid 1px #cecee2;
}

.card select{
	border-radius: 10px;
	border: solid 1px #cecee2;
}

.agreement_error {
    display: none;
    color: red;
}

.agreement_error.error {
    display: block;
}

input[type="date"] {
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	padding: 9px;
	font-size: 14px;
}

.date-container {
	position: relative;
}

.flatpickr-input {
	padding-right: 40px;
}

.flatpickr-calendar {
	z-index: 1000;
}

.date-container {
	position: relative;
}
.date-icon {
	position: absolute;
	top: 50%;
	right: 10px;
	transform: translateY(-50%);
	pointer-events: none;
	color: #aaa;
}

.passport_serie{
	padding: 0 15px !important;
}

#registrationForm .col-md-4 {
	padding: 15px 15px;
}

	.form-text-field {
		width: 100%;
	}


	input::-webkit-calendar-picker-indicator {
		filter: invert(1);

	}

	input {
		padding-left: 12px;
		padding-right: 12px;
	}
</style>
@endsection

<link href="{{asset("css/registration.css?v=1.0.3")}}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
@section('js')
	<script defer src="{{asset("js/registration.js?ver=1.0.1")}}"></script>

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAfz-DTeJFbN0ZUnDLrpxZLb3nlDvA0uO8&language=az"></script>
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
    var languageArr = @json($language_arr);

    document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('#registrationForm input, #registrationForm select');

        inputs.forEach(function (input) {
            input.addEventListener('blur', function () {
                validateInput(input);
            });
        });

        function validateInput(input) {
            if (input.id === 'name' || input.id === 'surname') {
                if (input.value.trim() === '') {
                    showError(input, languageArr[`input_${input.id}_error`]);
                } else {
                    hideError(input);
                }
            }

            if (input.id === 'passport_fin' || input.id === 'passport_number' || input.id === 'passport_series') {
                validatePassportFields();
            }
        }

        function validatePassportFields() {
            var passportSeries = document.getElementById('passport_series');
            var passportFin = document.getElementById('passport_fin');
            var passportNumber = document.getElementById('passport_number');

            var passportSeriesValue = passportSeries.value;
            var { finError, finLength, numberError, numberLength } = getErrorMessagesAndLengths(passportSeriesValue);
			console.log(getErrorMessagesAndLengths(passportSeriesValue));
            if (finLength !== null && passportFin.value.trim().length !== finLength) {
                showError(passportFin, finError);
            } else {
                hideError(passportFin);
            }

            if (numberLength !== null && passportNumber.value.trim().length !== numberLength) {
                showError(passportNumber, numberError);
            } else {
                hideError(passportNumber);
            }
        }

        function showError(input, message) {
            var errorDiv = input.nextElementSibling;
            if (errorDiv) {
                errorDiv.textContent = message;
                input.classList.add('is-invalid');
            }
        }

        function hideError(input) {
            var errorDiv = input.nextElementSibling;
            if (errorDiv) {
                errorDiv.textContent = '';
                input.classList.remove('is-invalid');
            }
        }

        function getErrorMessagesAndLengths(series) {
            switch (series) {
                case 'AZE':
					return {
						finError: languageArr['input_passport_fin_error_7'],
						finLength: 7,
						numberError: languageArr['input_passport_error_8'],
						numberLength: 8
					};
                case 'AA':
                    return {
                        finError: languageArr['input_passport_fin_error_7'],
                        finLength: 7,
                        numberError: languageArr['input_passport_error_7'],
                        numberLength: 7
                    };
                case 'MYI':
                    return {
                        finError: languageArr['input_passport_fin_error_6'],
                        finLength: 6,
                        numberError: languageArr['input_passport_error_7'],
                        numberLength: 7
                    };
                case 'DYI':
                    return {
                        finError: languageArr['input_passport_fin_error_7'],
                        finLength: 7,
                        numberError: languageArr['input_passport_error_7'],
                        numberLength: 7
                    };
                case 'VOEN':
                    return {
                        finError: languageArr['input_passport_fin'],
                        finLength: 4,
                        numberError: languageArr['input_passprot_voen_error'],
                        numberLength: 10
                    };
                default:
                    return {
                        finError: languageArr['input_passport_series_error_require'],
                        finLength: null,
                        numberError: languageArr['input_passport_series_error_require'],
                        numberLength: null
                    };
            }
        }
    });
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('register-checkbox');
    const errorElement = document.getElementById('agreement_error');

    checkbox.addEventListener('change', function() {
        if (!checkbox.checked) {
            errorElement.classList.add('error');
        } else {
            errorElement.classList.remove('error');
        }
    });
});
</script>

<script>
       document.addEventListener('DOMContentLoaded', function() {
            var phoneInputs = document.querySelectorAll('#phone, #phone2');

            phoneInputs.forEach(function(phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    var value = phoneInput.value.replace(/\D/g, '');
                    var formattedValue = '';

                    if (value.length > 0) {
                        formattedValue += '(' + value.substring(0, 3);
                    }
                    if (value.length > 3) {
                        formattedValue += ')-' + value.substring(3, 6);
                    }
                    if (value.length > 6) {
                        formattedValue += '-' + value.substring(6, 8);
                    }
                    if (value.length > 8) {
                        formattedValue += '-' + value.substring(8, 10);
                    }

                    phoneInput.value = formattedValue;
                });

                phoneInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        var value = phoneInput.value.replace(/\D/g, '');
                        if (value.length <= 1) {
                            phoneInput.value = '';
                        }
                    }
                });
            });
        });
    </script>
@endsection

