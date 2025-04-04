@extends('web.layouts.web')
@section('content')
    <section class="content-page-section">
        <div class="page-content-block">
            @if (session('case') == 'success')
                <div class="alert alert-success d-flex align-items-center p-3 shadow-lg rounded-3" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle me-2">
                        <path d="M16 8a.5.5 0 0 1 .374.833l-5.5 6a.5.5 0 0 1-.748 0l-2.5-3a.5.5 0 0 1 .748-.664l2.126 2.553 5.126-5.593A.5.5 0 0 1 16 8z"/>
                        <!--<path d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zm0 1a7 7 0 1 1-7 7A7 7 0 0 1 8 1z"/>-->
                    </svg>
                    <div>
                        <strong>{{ session('content') }}</strong>
                    </div>
                </div>
            @endif
                @if (session()->has('case') && session('case') === 'error')
                    <div class="alert alert-danger d-flex align-items-center p-3 shadow-lg rounded-3" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle me-2">
                        </svg>
                        <div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif


                <div class="container-fluid page_containers">
                <div class="row">
                    <div class="page-content-part campaign-content-part d-flex">
                        @include('web.account.account_left_bar')
                        <div class="page-content-right flex-grow-1">

                            <div class="n-order-list">
                                <div class="n-order-top flex space-between">
                                    <div class="row">
                                        <div class="col-md-6 col-4">
                                            <h1>{!! __('OTP') !!}</h1>
                                        </div>
                                        <div class="col-md-6 col-8">
                                            <div class="order-btn">
                                                <a href="{{route("get_seller_add", ['locale' => App::getLocale()])}}"
                                                   class="btn btn-orange btn-success"
                                                   style="background-color: rgba(16, 69, 140, 1); border-color: rgba(16, 69, 140, 1); float: right; margin: 0px 5px 5px 0;">{!! __('buttons.create_otp') !!}</a>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="orange-spinner order-list-table">

                                    @if(count($sellerOtps) > 0)
                                        <div class="n-order-table sp-order-table desktop-show">
                                            <table id="dataTable">
                                                <thead>
                                                <tr>
                                                    <th>Track</th>
                                                    <th>OTP</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sellerOtps as $order)
                                                    <tr class="order_{{$order->id}}">
                                                        <td title="{{$order->otp_text}}">{{$order->otp_text}}</td>
                                                        <td title="{{$order->otp_code}}">{{$order->otp_code}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div>
                                                {!! $sellerOtps->links(); !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
        .page-content-block {
            padding: 20px 90px;
            /* Üstten 20px, sağ ve soldan 90px boşluk bırakmak için */
        }

        .page-content-part {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
        }

        .page-content-right {
            flex-grow: 1;
        }

        .page-content-right .n-order-table table {
            width: 100%;
        }

        .n-order-top h1 {
            font-size: 28px;
            color: #10458C;
            font-weight: bold;
        }

        .order-btn .btn {
            background-color: #10458C;
            border-color: #10458C;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            float: right;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .order-btn .btn:hover {
            background-color: #08315e;
            border-color: #08315e;
        }

        .n-order-table th,
        .n-order-table td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .n-order-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .n-order-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .n-order-table tr:hover {
            background-color: #f1f1f1;
        }

        .n-order-table .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        .n-order-table .pagination li {
            margin: 0 5px;
        }

        .n-order-table .pagination li a {
            display: block;
            padding: 8px 12px;
            color: #10458C;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
        }

        .n-order-table .pagination li.active a,
        .n-order-table .pagination li a:hover {
            background-color: #10458C;
            color: #fff;
            border-color: #10458C;
        }

        @media (max-width: 768px) {
            .order-btn .btn {
                width: 100%;
                text-align: center;
                margin-bottom: 15px;
            }

            .n-order-top h1 {
                font-size: 24px;
                text-align: center;
            }

            .page-content-part {
                flex-direction: column;
            }

            .page-content-block {
                padding: 20px;
                /* Mobil uyumluluk için sadece 20px boşluk bırakır */
            }
            .n-order-table th, .n-order-table td {
                min-width: 150px;
                max-width: 150px;
                word-break: break-word;
                white-space: normal;
            }
        }
    </style>

    @if(count($sellerOtps)==0)
            <style>
                @media (max-width: 575.98px) {
                    .footer{
                        padding: 10px 0;
                        position: absolute;
                        bottom: 0;
                        width: 100%;
                    }
                }
            </style>
    @endif
@endsection
@section('scripts')
    <script>
        setTimeout(() => {
            document.getElementById('alert-box').classList.add('opacity-0');
            setTimeout(() => document.getElementById('alert-box').remove(), 500);
        }, 3000);
    </script>
@endsection

@section('js')
    <!-- Buraya JavaScript kodlarınızı ekleyebilirsiniz -->
@endsection