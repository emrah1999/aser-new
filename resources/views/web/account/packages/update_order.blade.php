@extends('web.layouts.web')
@section('content')

<div class="content" id="content">
    <section class="section section-profile-settings">
        <div class="container-lg">
            @if (session('case') === 'warning')
                <div class="alert alert-warning">
                    <strong>{{ session('title') }}</strong>
                    @if (is_array(session('content')))
                        <ul>
                            @foreach (session('content') as $field => $errors)
                                @foreach ($errors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    @else
                        <p>{{ session('content') }}</p>
                    @endif
                </div>
            @endif

            @if (session('case') === 'exist')
                <div class="alert alert-warning">
                    <strong>{{ session('title') }}</strong>
                    <p>{{ session('content') }}</p>
                </div>
            @endif

            @if (session('case') === 'success')
                <div class="alert alert-success">
                    <strong>{{ session('title') }}</strong>
                    <p>{{ session('content') }}</p>
                </div>
            @endif

            @if (session('case') === 'error')
                <div class="alert alert-danger">
                    <strong>{{ session('title') }}</strong>
                    <p>{{ session('content') }}</p>
                </div>
            @endif
            <div class="row">
                @include('web.account.account_left_bar')
                @php($disable_input = '')
                @if($package->internal_id != null && $package->last_status_id != 6 && $package->last_status_id != 9)
                    @php($disable_input = 'readonly')
                @endif
                @if($package->seller_id == 0)
                    @php($seller_id_required = '')
                    @php($other_seller_required = 'required')
                @else
                    @php($seller_id_required = 'required')
                    @php($other_seller_required = '')
                @endif
                @php($required = '')
                @if($package->country_id == 9)
                    @php($required = 'required')
                @endif
                <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                    <div class="profile-title-block">
                        <div class="row justify-content-center align-items-start">
                            <div class="col-xxl-8">
                                
                            </div>
                            <div class="col-xxl-4">

                            </div>
                        </div>
                    </div>
                    <form class="form form-profile-information-edit" name="formProfileInformationEdit" id="formProfileInformationEdit" method="post" action="{{route("post_package_update", ['locale' => App::getLocale(), $package->id])}}" novalidate="novalidate" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userName">{!! __('inputs.tracking_id') !!}</label>
                                    <input class="form__input" name="user_name" type="text" id="track" placeholder="{!! __('inputs.tracking_id') !!}" value="{{$package->track}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSex">{!! __('inputs.seller_name') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select select2" id="seller_id" name="seller_id" {{$disable_input}} {{$seller_id_required}} onchange="show_other_seller_input(this);">
                                            <option value="" {{$package->seller_id == null ? 'selected' : ''}}>{!! __('inputs.seller_name') !!}</option>

                                            @foreach($sellers as $seller)
                                                <option value="{{$seller->id}}" {{$package->seller_id == $seller->id ? 'selected' : ''}}>{{$seller->title}}</option>
                                            @endforeach
                                            <option value="0" >{!! __('static.other') !!}...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form__group" id="other_seller_area">
                                    <label class="form__label" for="userName">{!! __('inputs.seller_name') !!}</label>
                                    <input class="form__input" {{$other_seller_required}} id="other_seller"  name="other_seller" placeholder="{!! __('inputs.seller_name') !!}" maxlength="255" value="{{$package->other_seller}}">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form__group">
                                    <label class="form__label" for="userSex">{!! __('inputs.category') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select" id="category_id"  name="category_id" required {{$disable_input}}>
                                            <option value="">{!! __('inputs.select_category') !!}</option>
                                            @foreach($categories as $category)
                                                @if($category->id == $package->category_id)
                                                    <option selected value="{{$category->id}}">{{$category->name}}</option>
                                                @else
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form__group">
                                    <label class="form__label" for="title">{!! __('labels.product_name') !!}</label>
                                    <input class="form__input" id="title"  name="title" placeholder='{!! __('labels.product_name') !!}' value="{{$package->title}}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form__group" id="other_seller_area">
                                    <label class="form__label" for="userName">{!! __('labels.invoice') !!} (<span id="currency">{{$package->currency}}</span>)</label>
                                    <input class="form__input" id="price"  name="price" placeholder='{!! __('labels.invoice') !!}' step="0.01" min="0" value="{{$package->price}}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSex">{!! __('labels.currency') !!}</label>
                                    <div class="form__select-wrapper">
                                        <select class="form__select"id="currency_id" name="currency_id" required>
                                            <option value="">{!! __('inputs.select_currency') !!}</option>
                                            @foreach($currencies as $currency)
                                                @if($currency->id == $package->currency_id)
                                                    <option selected value="{{$currency->id}}">{{$currency->name}}</option>
                                                @else
                                                    <option value="{{$currency->id}}">{{$currency->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            @if($package->invoice_doc == null)
                                @php($file_input_required = 'required')
                            @else
                                @php($file_input_required = '')
                            @endif
                            <div class="col-md-12">
                                <div class="form-group field-userorder-amount" style="display: flex; flex-direction: column">
                                    <label class="control-label" for="invoice">{!! __('labels.file') !!}</label>
                                    <label for="file-upload" class="custom-file-upload">
                                        <img src="{{asset('uploads/static/upload_img.png')}}" alt="Upload Image" style="cursor: pointer; max-width: 57px; max-height: 32px;">
                                    </label>
                                    <input type="file" id="file-upload" class="form-control" name="invoice" {{$file_input_required}} style="display: none;" onchange="handleFileSelect(event)">
                                    <span id="file-name"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                @if($package->invoice_doc != null)
                                    <div class="uploaded-list">
                                        <label>{!! __('labels.uploaded_files') !!}</label>
                                        <br>
                                        <div id="current-gallery" class="qq-gallery">
                                            @php($ext_arr = ['png' ,'jpg' ,'jpeg'])
                                            @php($doc_parse = explode('.', $package->invoice_doc))
                                            @php($doc_ext = $doc_parse[count($doc_parse) - 1])
                                            @if(in_array($doc_ext, $ext_arr))
                                                <div class="qq-thumbnail-wrapper announce-img">
                                                    <a target="_blank" href="{{$package->invoice_doc}}">
                                                        <img class="qq-thumbnail-selector"style="max-width: 200px;max-height: 200px"  src="{{$package->invoice_doc}}">
                                                    </a>
                                                </div>
                                            @else
                                                <div class="qq-thumbnail-wrapper announce-img">
                                                    <a target="_blank" href="{{$package->invoice_doc}}">
                                                        <img class="qq-thumbnail-selector" style="max-width: 200px;max-height: 200px" src="/uploads/static/download.png">
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-blue btn-block form__btn form-profile-information-edit__btn font-n-b" name="formProfileInformationEditSubmit" type="submit">Yadda saxla</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    .select2-container--default .select2-selection--single {
        height: 52px !important;
        padding-top: 10px;
    }
    .select2-selection__arrow{
        display: none;
    }
</style>
@endsection


@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#seller_id').select2();
    $('#category_id').select2();
    function handleFileSelect(event) {
        var input = event.target;
        var fileName = input.files[0].name;
        document.getElementById('file-name').textContent = fileName;
    }

</script>
<script>
    function show_other_seller_input(selectElement) {
        var otherSellerArea = document.getElementById('other_seller_area');
        if (selectElement.value == '0' || selectElement.value == '2824' ) {
            otherSellerArea.style.display = 'block';
        } else {
            otherSellerArea.style.display = 'none';
        }
    }


    document.addEventListener("DOMContentLoaded", function () {
        var selectElement = document.getElementById('seller_id');
        show_other_seller_input(selectElement);
    });
</script>

@endsection