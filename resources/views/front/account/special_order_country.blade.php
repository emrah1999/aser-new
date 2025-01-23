@extends('front.app')
@section('content')
    <section class="content-page-section">
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
                        @include("front.account.account_left_bar")
                        <div class="page-content-right">
                            <div class="account-home-top">
                                <div class="account-address-info account-address-main">
                                    <div class="row">
                                        @foreach($countries as $country)
                                            <div class="col-md-2 col-xs-12">
                                                <a href="{{route('special_order', $country->id)}}" class="country-block-link">
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
                                    </div>
                                </div>
                                @if(session('display') == 'block')
                                    <div class="{{session('class')}}">
                                        <h3>{{session('description')}}</h3>
                                        <p>{{session('message')}}</p>
                                    </div>
                                @endif
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
   .tarif_tab_links li.active a {
    border-radius: 5px;
    background-color: #ffce00 !important;
    color: #fff !important;
}
</style>
@endsection

@section('js')
    @if(Request::get('approve-referral') == 'OK')
        <script>
            let swal_case = '{{Request::get('case')}}';
            let swal_message = '{{Request::get('message')}}';

            swal(
                'Referral account',
                swal_message,
                swal_case
            );
        </script>
    @endif

    @if(session('special_orders_active') == 'false')
        <script>
            let swal_message = '{{session('message')}}';
            let swal_title = "{!! __('buttons.order') !!}";

            swal(
                swal_title,
                swal_message,
                'warning'
            );
        </script>
    @endif
@endsection
