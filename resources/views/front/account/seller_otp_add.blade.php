@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->

        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part">
                        @include('front.account.account_left_bar')

                        <div class="page-content-right">
                            <div class="order-block profile-information-block">
                                <div class="order-form-header">
                                    <h3> {!! __('account_menu.declaration') !!} </h3>
                                </div>
                                <form id="preliminary_declaration_form" action="" method="post" redirect_url="{{route("post_seller_add")}}" style="width: 100% !important;">
                                    @csrf
                                    <div class="order-form">
                                        <div class="store-inputs">
                                            <div class="form-element row" style="padding: 0 20px">
                                                <div class="col-md-6">
                                                    <div class="form-group field-userorder-category_id required">
                                                        <div class="calculate-input-block for-select">
                                                            <input type="text" id="otp_text" class="form-control" name="otp_text" placeholder="Track" maxlength="255">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group field-userorder-category_id required">
                                                        <div class="calculate-input-block for-select">
                                                            <input type="text" id="otp_code" class="form-control" name="otp_code" placeholder="OTP" maxlength="255">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-button">
                                            <button type="submit" class="orange-button"> {!! __('buttons.save') !!}</button>
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

</style>
@endsection

@section('js')
<script>

</script>
@endsection
