@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- breadcrumb -->
        <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="{{route("home_page")}}"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('menu.faq') !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="container">
                <div class="row">
                    <div class="store-header section-header">
                        <h3> {!! __('menu.faq') !!} </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-block">
            <div class="container ">
                <div class="row">
                    <div class="faq-page-part">
                        <div class="faq-content-right">
                            <div class="faq-block">
                                <ul class="faq-slide-ul">
                                    @foreach ($faqs as $faq)
                                        <li>
                                            <a href="#">{{$faq->question}} </a>
                                            <div class="faq-slide-content">
                                                {!! $faq->answer !!}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page content end-->
@endsection

@section('css')

@endsection

@section('js')

@endsection