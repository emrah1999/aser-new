@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->
        <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="{{route("home_page")}}"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('account_menu.balance') !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- page content header -->
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text">
                        <h3> {!! __('account_menu.balance') !!} </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-block">
            <div class="container ">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')

                        <div class="page-content-right">
                            <div class="profile-tab-block">
                                <ul class="nav profile-tab-ul" role="tablist">
                                    <li><a href="{{route("get_payment_page")}}" class="active">{!! __('buttons.payment') !!}</a></li>
                                    <li><a href="{{route("get_payment_logs")}}">{!! __('buttons.payment_log') !!}</a></li>
                                </ul>
                                <div class="tab-content profile-tab-content">
                                    <div role="tabpanel" class="tab-pane request-ajax fade in active" id="balance-inside" style="">

                                        <div class="profile-tab-header">
                                           {{-- <h3> {!! __('static.balance') !!} : <span> ${{Auth::user()->balance()}}  </span></h3> --}}

                                           {{-- <p> {!! __('static.balance_text') !!} </p> --}}

                                        </div>
                                        <div class="profile-tab-form main-form" style="margin-top: 25px;">
                                            <form id="payment-task" action="{{route("post_payment_page")}}" method="post">
                                                @csrf
                                                <div class="form-group field-paymenttask-amount required">
                                                    <input type="text" id="amount" class="form-control"
                                                           name="amount" placeholder="* {!! __('inputs.amount') !!}" required>
                                                </div>
                                                <button type="submit" class="orange-button"> Ödəmə</button>
                                            </form>
                                        </div>
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

@endsection

@section('js')

@endsection
