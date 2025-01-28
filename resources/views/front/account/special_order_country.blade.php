@extends('web.layouts.web')
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
                    @include('web.account.account_left_bar')
                    <div class="col-md-9 page-content-part campaign-content-part">
                        <div class="page-content-right">
                            <div class="account-home-top">
                                <div class="account-address-info account-address-main">
                                    <div class="row">
                                        @foreach($countries as $country)
                                            <div class="col-md-3 col-xs-12">
                                                <a href="{{ route('special_order', ['locale' => App::getLocale(), 'country_id' => $country->id]) }}" class="country-block-link">
                                                    <div class="country-block flex align-items-center">
                                                        <div class="country-flag">
                                                            <img src="{{$country->flag}}" height="30px" width="30px" alt="">
                                                        </div>
                                                        <div class="country-name">
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


@section('styles')
<style>
    .left-bar-new-style{
        margin-top: -113px;
    }
   /* Genel layout ve container ayarları */
   .page-content-block {
       padding: 20px 90px; /* Sol, sağ 90px, üst 20px boşluk */
   }

   .page-content-part {
       display: flex;
   }

   .page-content-right {
       flex-grow: 1;
       background-color: #fff7e6;
       padding: 20px;
       border-radius: 8px;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       height: 20%;
   }

   .account-home-top {
       margin-bottom: 20px;
   }

   .account-address-info {
       background-color: #fff;
       padding: 20px;
       border-radius: 8px;
       box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
   }

   .account-address-main .row {
       display: flex;
       flex-wrap: wrap;
   }

   .country-block-link {
       display: block;
       text-decoration: none;
       color: inherit;
       margin-bottom: 20px; /* Her ülke bloğu arasına boşluk bırak */
       transition: transform 0.3s ease;
   }

   .country-block-link:hover {
       transform: scale(1.05);
   }

   .country-block {
       display: flex;
       align-items: center;
       padding: 10px;
       background-color: #fff;
       border: 1px solid #ddd;
       border-radius: 8px;
       transition: background-color 0.3s ease, transform 0.3s ease;
       box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
   }

   .country-block:hover {
       background-color: #f0f0f0;
   }

   .country-flag img {
       max-width: 100%;
       height: auto;
       border-radius: 50%;
       margin-right: 15px; /* Bayrak ile ülke adı arasında boşluk bırak */
   }

   .country-name {
       font-weight: bold;
       color: #333;
       white-space: nowrap; /* Metnin taşmasını engelle */
       text-overflow: ellipsis;
       overflow: hidden;
       max-width: 150px; /* Genişliği ayarla */
   }

   /* Uyarı mesajı */
   .alert {
       border-radius: 5px;
       margin-bottom: 20px;
       padding: 15px;
   }

   .alert-warning {
       background-color: #fff3cd;
       color: #856404;
       border: 1px solid #ffeeba;
   }

   .alert-success {
       background-color: #d4edda;
       color: #155724;
       border: 1px solid #c3e6cb;
   }

   .alert-danger {
       background-color: #f8d7da;
       color: #721c24;
       border: 1px solid #f5c6cb;
   }

   .alert strong {
       font-weight: bold;
   }

   .alert ul {
       padding-left: 20px;
   }

   /* Mobil uyumluluk */
   @media (max-width: 768px) {
       .page-content-part {
           flex-direction: column;
       }

       .page-content-block {
           padding: 20px;
       }

       .country-block {
           margin-bottom: 10px;
       }
   }



</style>

@endsection

@section('scripts')
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countryActive = document.querySelector('.country-active');
            const countryList = document.querySelector('.country-list');

            countryActive.addEventListener('click', function() {
                countryList.style.display = countryList.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(event) {
                if (!countryActive.contains(event.target) && !countryList.contains(event.target)) {
                    countryList.style.display = 'none';
                }
            });
        });


    </script>
@endsection
