@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- breadcrumb -->
        <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="{{route("home_page")}}"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('menu.dangerous_goods') !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text">
                        <h3> {!! __('menu.dangerous_goods') !!} </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-block">
            <div class="container ">
                {!! $dangerous_goods_text !!}
            </div>
        </div>
    </section>
    <!-- page content end-->
@endsection

@section('css')

@endsection

@section('js')

@endsection