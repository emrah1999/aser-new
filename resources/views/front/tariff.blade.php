@extends('front.app')
@section('content')
<section class="content-page-section">


    <div class="container">

        {{-- <div class="alert alert-secondary alert-tariff">
            <h1>{!! __('static.volume_title') !!}</h1>
            <p style="white-space: pre-line">{!! __('static.volume_text') !!}</p>
        </div> --}}

        <div class="tariff-main">
			<div class="tariff-top flex space-between tarif_mobile">
						
				<div class="tariff-select">
					<div class="country-select">
						<div class="country-active flex align-items-center">
							<span class="country-flag">
								<img src="{{$countries[0]->flag}}" alt="{{$countries[0]->name}}">
							</span>
							{!! __('static.tariffs_by_country', ['country' => $countries[0]->name]) !!}
						</div>

						<div class="country-list list-tab no-reload">
							<ul>
								@foreach($countries as $country)
									<li>
										<a href="#" data-id="tariff-box-{{$country->id}}"
											class="flex align-items-center" title="">
											<span class="country-flag">
												<img src="{{$country->flag}}" alt="{{$country->name}}">
											</span>
											{!! __('static.tariffs_by_country', ['country' => $country->name]) !!}
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>

			</div>
		
            <div class="container tariff_desk">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="tarif_tab_links">
                                    @foreach($countries as $index => $country)
                                        <li class="{{ $index === 0 ? 'active' : '' }}">

                                            <a href="#tariff{{$country->id}}" data-id="tariff-box-{{$country->id}}" class="country-tab-link">
                                                <img src="{{$country->flag}}" alt="{{$country->name}}" style="height: 18px">
                                                {{$country->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tariff-bottom">
                @php($country_id = 0)
                @php($type_id = 0)
                @foreach($tariffs as $tariff)
                    @if($country_id !== $tariff->country_id)
                        @if($country_id !== 0)
            </div>
        </div>
        @endif
        @php($country_id = $tariff->country_id)
        @php($type_id = $tariff->type_id)
        <div class="tariff-box cn-box" id="tariff-box-{{$tariff->country_id}}" style="display: none;">
            <div class="tariff-header">
                <h3>{{ $tariff->country_name }}</h3>
                <div class="tariff-type-selector">
                    <button class="tariff-type-button active">{!! __('static.standart', ['locale' => App::getLocale()]) !!}</button>
                    {{-- <button class="tariff-type-button">Maye</button> --}}
                </div>
            </div>
            <div class="tariff-list">
                @endif
                <div class="tariff-item">

                    <div class="tariff-weight">
                        @if($tariff->to_weight > 1000)
                            {!! __('static.tariff_from_weight', ['from_weight' => $tariff->from_weight]) !!}
                        @elseif($tariff->from_weight > 1)
                            {!! __('static.tariff_from_to_by_kg', ['from_weight' => $tariff->from_weight, 'to_weight' => $tariff->to_weight]) !!}
                        @else
                            {!! __('static.tariff_from_to', ['from_weight' => $tariff->from_weight, 'to_weight' => $tariff->to_weight]) !!}
                        @endif
                    </div>
                    <div class="tariff-price">
                        <!-- Normal giymet -->
                        <span>
                            {{ $tariff->icon }}{{ $tariff->rate == 0 ? $tariff->charge : $tariff->rate }} / ₼{{ $tariff->amount_azn }}
                        </span>

                        <!-- endirimli qiymet -->
                        @if ($tariff->sales_rate > 0 || $tariff->sales_charge > 0)
                            <div class="discounted-prices text-danger" style="margin-top: 10px">
                                <!-- endirimli rate -->
                                @if ($tariff->sales_rate > 0)
                                    <span>
                                        <del>{{ $tariff->icon }}{{ $tariff->sales_rate }} / ₼{{ $tariff->sales_amount_azn }}</del>
                                    </span>
                                @endif
                                <!-- endirimli charge -->
                                @if ($tariff->sales_charge > 0)
                                    <span>
                                        <del>{{ $tariff->icon }}{{ $tariff->sales_charge }} / ₼{{ $tariff->sales_amount_azn }}</del>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>

@endsection

@section('css')
<style>
   .tarif_tab_links li.active a {
    border-radius: 5px;
    background-color: #ffce00 !important;
    color: #fff !important;
}

   .tariff-box {
       border: 1px solid #ccc;
       padding: 20px;
       border-radius: 10px;
       margin: 0 auto 20px;
       max-width: 600px;
       background-color: #f9f9f9;
       text-align: center;
   }

   .tariff-header {
       display: flex;
       justify-content: space-between;
       align-items: center;
       margin-bottom: 20px;
       border-bottom: 1px solid #ddd;
       padding-bottom: 10px;
   }

   .tariff-type-selector {
       display: flex;
       gap: 10px;
   }

   .tariff-type-button {
       padding: 5px 20px;
       border: 1px solid #ddd;
       border-radius: 20px;
       cursor: pointer;
       background-color: #fff;
       transition: background-color 0.3s ease;
   }

   .tariff-type-button.active, .tariff-type-button:hover {
       background-color: #e0e0e0;
   }

   .tariff-list {
       display: flex;
       flex-direction: column;
       gap: 10px;
   }

   .tariff-item {
       display: flex;
       justify-content: space-between;
       align-items: center;
       padding: 10px;
       /*background-color: #fff;*/
       border-radius: 5px;
       box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
   }

   .tariff-price {
       font-size: 14px;
       color: #666;
   }

   .tariff-weight {
       font-size: 14px;
       color: #666;
   }
</style>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Show the first country's tariffs by default
        document.getElementById("tariff-box-{{$countries[0]->id}}").style.display = "block";

        // Add click event listeners to each country tab link
        const countryLinks = document.querySelectorAll(".country-tab-link");
        countryLinks.forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault();

                // Hide all tariff boxes
                const tariffBoxes = document.querySelectorAll(".tariff-box");
                tariffBoxes.forEach(box => box.style.display = "none");

                // Remove active class from all tabs
                const tabLinks = document.querySelectorAll(".tarif_tab_links li");
                tabLinks.forEach(tab => tab.classList.remove("active"));

                // Show the selected country's tariff box and set active class
                const countryId = this.getAttribute("data-id");
                document.getElementById(countryId).style.display = "block";
                this.parentElement.classList.add("active");
            });
        });
    });
</script>
@endsection
