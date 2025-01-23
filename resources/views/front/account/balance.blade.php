@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->
        <!-- <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="{{route("home_page")}}"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('account_menu.balance') !!}</li>
                    </ul>
                </div>
            </div>
        </div> -->
        <!-- page content header -->
        <!-- <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text">
                        <h3> {!! __('account_menu.balance') !!} </h3>
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
                            <div class="profile-tab-block">
                                <ul class="nav profile-tab-ul" role="tablist">
                                    <li><a href="{{route("get_balance_page")}}" class="active">{!! __('buttons.add_balance') !!}</a></li>
                                    <li><a href="{{route("get_balance_logs")}}">{!! __('buttons.balance_log') !!}</a></li>
                                </ul>
                                <div class="tab-content profile-tab-content">
                                    <div role="tabpanel" class="tab-pane request-ajax fade in active" id="balance-inside" style="padding: 55px 20px;">
                                        
                                        <div class="profile-tab-header">
                                            <h3> {!! __('static.balance') !!} : <span> ${{Auth::user()->balance()}}  </span></h3>
                                        </div>
                                        <div class="last-30-day-notf" style="line-height: 20px;">
                                            <p> {!! __('static.balance_text') !!} </p>
                                        </div>
                                        <div class="profile-tab-form main-form" style="margin-top: 25px;">
                                            <form id="payment-task" action="{{route("post_balance_page")}}" method="post">
                                                @csrf
                                                <div class="form-group field-paymenttask-amount required">
                                                    @if($amount == 0)
                                                        <input type="text" id="amount" class="form-control"
                                                           name="amount" placeholder="* US$" required>
                                                    @else
                                                        <input type="text" id="amount" class="form-control" name="amount" placeholder="*Məbləğ USD" value="{{ $amount }}" required>
                                                    @endif
                                                </div>
                                                <button type="submit" class="orange-button add_balance_save"> {!! __('buttons.add_balance_save') !!}</button>
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
<style>
    @media only screen and (max-width: 767px) {
        .add_balance_save{
            margin-top: 15px !important;
        }
    }
</style>
@endsection

@section('js')

@endsection
