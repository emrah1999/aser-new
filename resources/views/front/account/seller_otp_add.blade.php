@extends('web.layouts.web')
@section('content')
    <section class="content-page-section">
        <!-- brand crumb -->

        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part">
                        @include('web.account.account_left_bar')

                        <div class="page-content-right">
                            <div class="order-block profile-information-block">
                                <div class="order-form-header">
                                    <h3> {!! __('buttons.create_otp') !!} </h3>
                                </div>
                                <form id="preliminary_declaration_form" action="" method="post" redirect_url="{{route("post_seller_add",['locale' => app()->getLocale()])}}" style="width: 100% !important;">
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

@section('styles')
<style>
    .page-content-block {
        padding: 20px 90px;
    }

    .page-content-part {
        display: flex;
        flex-wrap: nowrap;
        gap: 20px;
    }

    .page-content-right {
        flex-grow: 1;
        background-color: #f7f7f7;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .order-form-header h3 {
        font-size: 24px;
        color: #10458C;
        font-weight: bold;
    }

    .form-element {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .calculate-input-block .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .order-button {
        text-align: right;
        margin-top: 20px;
    }

    .orange-button {
        background-color: rgba(16, 69, 140, 1);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .orange-button:hover {
        background-color: #08315e;
    }

    @media (max-width: 768px) {
        .page-content-block {
            padding: 20px;
        }

        .page-content-part {
            flex-direction: column;
        }

        .order-button {
            text-align: center;
        }
    }


</style>
@endsection

@section('js')
<script>

</script>
@endsection
