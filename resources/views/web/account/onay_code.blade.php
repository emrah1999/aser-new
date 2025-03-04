@extends('web.layouts.web')
@section('content')
<section class="content-page-section">
    <div class="page-content-block">
        <div class="container-fluid page_containers">
            <div class="container-lg">
                <div class="page-content-part campaign-content-part">
                    <div class="row">
                        @include("web.account.account_left_bar")
                        <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7 page-content-right">
                            <div class="n-order-list row">
                                <div class="n-order-top flex space-between">
                                    <h1>Trendyol Onay Kodu</h1>
                                </div>
                                <div class="orange-spinner order-list-table">
                                    @if(count($data) > 0)
                                    <div class="n-order-table sp-order-table desktop-show">
                                        <table id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th>Onay kodu</th>
                                                    <th>{!! __('table.date') !!}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $key=>$d)
                                                @if(strtotime($d->created) > strtotime($date))
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $d->onaykodu }}</td>
                                                    <td>{{ $d->created }}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
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
    .content-page-section {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .page-content-right {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .n-order-top h1 {
        font-size: 22px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    /* Tablo Stili */
    .n-order-table table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 5px;
        overflow: hidden;
    }

    .n-order-table table th {
        background: #F2C516;
        color: white;
        padding: 12px;
        text-align: left;
    }

    .n-order-table table td {
        padding: 15px;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

    .n-order-table table tr:nth-child(even) {
        background: #f2f2f2;
    }

    .n-order-table table tr:hover {
        background: #e9ecef;
    }

   
    
</style>
@endsection

@section('js')

@endsection