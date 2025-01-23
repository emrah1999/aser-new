@extends('front.app')

@section('content')
    <!-- main slider start -->
    <div class="container ">
        <div class="row">
            <div class="default-carousel owl-carousel head_slider">
                <div class="item"><img src="{{asset("front/image/banner_usa.jpg")}}" alt="Image 1"></div>
                <div class="item"><img src="{{asset("front/image/banner_brit.jpg")}}" alt="Image 2"></div>
                <div class="item"><img src="{{asset("front/image/banner_alm.jpg")}}" alt="Image 3"></div>
                <div class="item"><img src="{{asset("front/image/banner_turk.jpg")}}" alt="Image 3"></div>
                <!-- Daha fazla öğe ekleyebilirsiniz -->
            </div>
        </div>
    </div>
    <!-- main slider end --><!-- carry section  start -->

    <section class="instruction-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section_title"  style="margin-bottom: 10px !important">
                    <h2>{!! __('static.using_way_head') !!}</h2>
                </div>
               <div class="col-md-12">
                   <div class="row">
                        <div class="col-md-3 col-xs-6 how_work">
                            <div class="reg_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/register.png")}}" alt="{!! __('static.using_way_register_head') !!}" title="{!! __('static.using_way_register_head') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.using_way_register_head') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.using_way_register_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="col-md-3 col-xs-6 how_work">
                            <div class="reg_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/shopping.png")}}" alt="{!! __('static.using_way_shopping_head') !!}" title="{!! __('static.using_way_shopping_head') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.using_way_shopping_head') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.using_way_shopping_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6 how_work">
                            <div class="reg_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/ware.png")}}" alt="{!! __('static.using_way_warehouse_head') !!}" title="{!! __('static.using_way_warehouse_head') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.using_way_warehouse_head') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.using_way_warehouse_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-3 col-xs-6 how_work">
                            <div class="reg_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/deliveryhome.png")}}" alt="{!! __('static.using_way_delivery_home_head') !!}" title="{!! __('static.using_way_delivery_home_head') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.using_way_delivery_home_head') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.using_way_delivery_home_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
               </div>
           </div>
        </div>
    </section>
    
    <!-- carry section  end -->
    <!-- video section start -->
     <section class="video-section" id="tutorial">
        <div class="container full-height">
            <div class="row full-height">
                <div class="video-block">

                    <div class="video-compile">
                        <div class="video-bg"></div>
                        <div class="video-cover">
                            <img src="{{asset("front/image/video_img.png")}}"/>
                        </div>
                        <div class="video-content video-link">
                            <a href="#video" data-media="https://www.youtube.com/embed/sq_Ubu0by9k"
                               class="play-button  ">
                                <i class="fa fa-play"></i> </a>
                            <div class="popup" id="video">
                                <iframe width="70%" height="70%" src="" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="video-text">
                        {{-- <h3> {!! __('static.video_tutorial_new') !!} </h3>
                        <p> {!! __('static.discover_style') !!} </p> --}}
                        <span>{!! __('static.tutorial_text_new') !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="parnter_section" >
        <div class="container">
            <div class="col-md-12 section_title">
                <h2>{!! __('static.partner_head') !!}</h2>
                {{-- <h5 style="text-align: center;">{!! __('static.partner_title') !!}</h5> --}}
            </div>
            <div class="partner-carousel owl-carousel">
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/ups-logo-qay70p2w766c8xnvxulzohwxuizi1n2xa1khmny3fs.png" alt="Partner 1">
                    </div>
                </div>
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="{{asset("front/image/pasha.jpeg")}}" style="object-fit: cover" alt="Partner 2">
                    </div>
                </div>
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/weworld-2-qay70p2w766c8xnvxulzohwxuizi1n2xa1khmny3fs.png" alt="Partner 3">
                    </div>
                </div>
{{--                <div class="item">--}}
{{--                    <div class="logo-wrapper" style="object-fit: cover">--}}
{{--                        <img src="{{asset("front/image/lsim.png")}}" alt="Partner 3">--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/amazon-logo-qay70p2w766c8xnvxulzohwxuizi1n2xa1khmny3fs.png" alt="Partner 3">
                    </div>
                </div>
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/fedex-logo-qay70p2w766c8xnvxulzohwxuizi1n2xa1khmny3fs.png" alt="Partner 3">
                    </div>
                </div>
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/azal-new-2-qbbvg3sxoxnupjm2bmbzq1puxiudflnz8kkpfrca20.png" alt="Partner 3">
                    </div>
                </div>
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/thy-logo-2-qay70p2w766c8xnvxulzohwxuizi1n2xa1khmny3fs.png" alt="Partner 3">
                    </div>
                </div>
                <div class="item">
                    <div class="logo-wrapper">
                        <img src="https://asercargoshipping.com/wp-content/uploads/elementor/thumbs/silkway-logo-qay70p2w766c8xnvxulzohwxuizi1n2xa1khmny3fs.png" alt="Partner 3">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- video section end -->
    <!-- calculate section start -->
    <!-- calculate section end --><!-- store section start -->
    {{-- <section class="store-section">
        <div class="container">
            <div class="row">
                <div class="store-header section-header">
                    <h3> {!! __('static.stores') !!} </h3>
                </div>
                <div class="section-content">
                    <ul class="sellers">
                        @foreach ($sellers as $seller)
                            <li><a href="{{$seller->url}}" target="_blank"> <img
                                        src="https://manager.asercargo.az/{{$seller->img}}"
                                        alt="{{$seller->title}}"/></a></li>
                        @endforeach

                    </ul>
                    <div class="store-more">
                        
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- store section end-->

    <section class="instruction-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section_title">
                    <h2>{!! __('static.our_offer_head') !!}</h2>
                    {{-- <h5 style="text-align: center;">{!! __('static.our_offer_title') !!}</h5> --}}
                </div>
               <div class="col-md-12">
                   <div class="row">
                        <div class="col-md-4 how_work">
                            <div class="how_work_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/flight.png")}}" alt="{!! __('static.offer_flight') !!}" title="{!! __('static.offer_flight') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.offer_flight') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.offer_flight_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="col-md-4 how_work">
                            <div class="how_work_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/road-freight.png")}}" alt="{!! __('static.offer_road') !!}" title="{!! __('static.offer_road') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.offer_road') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.offer_road_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 how_work">
                            <div class="how_work_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/sea-fregiht.png")}}" alt="{!! __('static.offer_sea') !!}" title="{!! __('static.offer_sea') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.offer_sea') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.offer_sea_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-4 how_work">
                            <div class="how_work_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/warehouse.png")}}" alt="{!! __('static.offer_warehouse') !!}" title="{!! __('static.offer_warehouse') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.offer_warehouse') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.offer_warehouse_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 how_work">
                            <div class="how_work_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/package.png")}}" alt="{!! __('static.offer_package') !!}" title="{!! __('static.offer_package') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.offer_package') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.offer_package_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 how_work">
                            <div class="how_work_box">
                                <div class="row">
                                    <div class="col-md-12 hwi">
                                        <span class="how_w_imgbox hwi_blue">
                                            <img src="{{asset("front/frontend/web/uploads/images/how-it-works/add_basket.png")}}" alt="{!! __('static.offer_fullfillment') !!}" title="{!! __('static.offer_fullfillment') !!}">
                                        </span>
                                    </div>
                                    <div class="col-md-12 hwt">
                                        <h5>{!! __('static.offer_fullfillment') !!}</h5>
                                    </div>
                                    <div class="col-md-12 hwl">
                                        <ul>
                                            <li>{!! __('static.offer_fullfillment_title') !!}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
               </div>
           </div>
        </div>
    </section>


    <section class="calculate_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section_title mobile_show">
                    <h2>{!! __('static.calculator') !!}</h2>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="col-md-12 calculator_box p-0">
                        <div class="row">
                            <div class="col-md-12 how_work_calc">
                                <div class="select form-group">
                                    <select class="select-text form-control" id="country" required="">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}} - {!! __('static.baku') !!}</option>
                                        @endforeach
                                    </select>
                                    <span class="select-highlight"></span>
                                    <label class="select-label">{!! __('static.country') !!}</label>
                                </div>
                            </div>
                            <div class="col-md-6 how_work_calc">
                                <div class="select form-group">
                                    <select class="select-text form-control" id="type" required="">
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="select-highlight"></span>
                                    <label class="select-label">{!! __('static.type') !!}</label>
                                </div>
                            </div>
                            <div class="col-md-6 how_work_calc">
                                <div class="select form-group">
                                    <select class="select-text form-control" id="unit" required="">
                                        <option value="kq"> kg</option>
                                        <option value="gm"> g </option>
                                    </select>
                                    <span class="select-highlight"></span>
                                    <label class="select-label">{!! __('static.unit') !!}</label>
                                </div>
                            </div>
                            <div class="col-md-6 how_work_calc">
                                <div class="form-group">
                                    <input type="text" class="form-control floating-input" id="width" placeholder=" ">
                                    <label class="animate_label">{!! __('static.width') !!}</label>
                                    <span class="input_type">sm</span>
                                </div>
                            </div>
                            <div class="col-md-6 how_work_calc">
                                <div class="form-group">
                                    <input type="text" class="form-control floating-input" id="length" placeholder=" ">
                                    <label class="animate_label">{!! __('static.length') !!}</label>
                                    <span class="input_type">sm</span>
                                </div>
                            </div>
                            <div class="col-md-6 how_work_calc">
                                <div class="form-group">
                                    <input type="text" class="form-control floating-input" id="height" placeholder=" ">
                                    <label class="animate_label">{!! __('static.height') !!}</label>
                                    <span class="input_type">sm</span>
                                </div>
                            </div>
                            <div class="col-md-6 how_work_calc">
                                <div class="form-group weight_select">
                                    <input type="text" class="form-control floating-input" id="weight" placeholder=" ">
                                    <label class="animate_label">{!! __('static.weight') !!}</label>
                                </div>
                            </div>
                            <div class="col-md-12 calc_btn">
                                <button type="button" onclick="calculate_amount('{{route("calculate_amount")}}');"> {!! __('buttons.calculate') !!} </button>
                                <p class="calculate_result" id="calculator-result">
                                    <span id="amount">0.00</span>                          
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 calculate_right">
                    <h3>{!! __('static.calculator') !!}</h3>
                    <p>{!! __('static.calculate_text') !!}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance:textfield;
        }

        .head_slider{
            padding: 0 20px;
        }
    </style>
@endsection

@section('js')

@endsection
