@extends('front.app')
@section('content')
    <section class="content-page-section">
        <div class="page-content-block">
            <div class="container-fluid page_containers ">
                <div class="row">
                    <div class="page-content-part campaign-content-part">
                        @include("front.account.account_left_bar")
                        <div class="page-content-right">

                            <div class="n-order-list">

                                <div class="n-order-top flex space-between">
                                    <h1>{!! __('courier.title') !!}</h1>
                                    {{-- <div class="col-md-6 store-selection">
                                        <div class="form-group field-userorder-shop_title required has-error">
                                            <div class="calculate-input-block for-select">
                                                <select id="selectChange"
                                                        class="form-control"
                                                        required>
                                                    <option value="baki">Bakı</option>
                                                    <option value="rayonlar">Regionlar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>



                                <div class="orange-spinner order-list-table">
                                    <div class="order-btn">
                                        
                                        @if(Request::get('archive') == 'yes')
                                            <a href="{{route("get_azerpost_courier_page") . "?archive=no"}}"
                                               class="btn btn-orange btn-success"
                                               style="background-color: #f4a51c; border-color: #f4a51c; float: right; margin: 8px 5px 5px 0;">{!! __('buttons.current_orders') !!}</a>
                                        @else
                                            <a href="{{route("get_azerpost_courier_page") . "?archive=yes"}}"
                                               class="btn btn-orange btn-success"
                                               style="background-color: #f4a51c; border-color: #f4a51c; float: right; margin: 8px 5px 5px 0;">{!! __('buttons.orders_history') !!}</a>
                                        @endif
                                        <a href="{{route("get_create_azerpost_page")}}"
                                               class="btn btn-orange btn-success"
                                               style="background-color: rgba(16, 69, 140, 1); border-color: rgba(16, 69, 140, 1); float: right; margin: 8px 5px 5px 0;">{!! __('buttons.create_courier') !!}</a>
                                    </div>
                                    @if(count($orders) > 0)
                                        <div class="n-order-table sp-order-table desktop-show">
                                            <table id="dataTable">
                                                <thead>
                                                <tr>
                                                    {{-- <th>{!! __('table.id') !!}</th> --}}
                                                  {{--  <th>{!! __('courier.area') !!}</th> --}}
                                                  {{--  <th>{!! __('courier.metro_station') !!}</th> --}}
                                                    <th>{!! __('courier.address') !!}</th>
                                                    <th>{!! __('courier.date') !!}</th>
                                                    <th>{!! __('courier.payment_type') !!}</th>
                                                    <th>{!! __('courier.courier_payment') !!}</th>
                                                    <th>{!! __('courier.total_payment') !!}</th>
                                                    <th>{!! __('courier.status') !!}</th>
                                                    <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($orders as $order)
                                                    @php($address = $order->address)
                                                    @php($azerpost = $order->is_send_azerpost == true ? $order->azerpost_track : "")
                                                    @if(strlen($address) > 15)
                                                        @php($address = substr($address, 0, 12) . '...')
                                                    @endif
                                                    @if(strlen($order->area) > 15)
                                                        @php($area_name = substr($order->area, 0, 12) . '...')
                                                    @else
                                                        @php($area_name = $order->area)
                                                    @endif
                                                    @if(strlen($order->metro_station) > 15)
                                                        @php($metro_station_name = substr($order->metro_station, 0, 12) . '...')
                                                    @else
                                                        @php($metro_station_name = $order->metro_station)
                                                    @endif
                                                    <tr class="order_{{$order->id}}">
                                                        <td title="{{$order->address}}">{{$address}}</td>
                                                        <td>{{date('d.m.Y', strtotime($order->date))}}</td>
                                                        <td>{{$order->payment_type}}</td>
                                                        <td>{{$order->amount}} AZN</td>
                                                        {{-- <td>{{$order->delivery_amount}} AZN</td>--}}
                                                        <td>
                                                            <p>{{$order->total_amount}} AZN</p>
                                                            <p>{{$order->amount}} + {{$order->delivery_amount}}</p>
                                                        </td>
                                                        <td>
                                                            <span class="order-status"
                                                                  data-message="{!! __('courier.order_not_selected') !!}"
                                                                  onclick="courier_show_status_history({{$order->id}}, '{{route("courier_show_statuses_history")}}');">
                                                                {{$order->status}}
                                                                <p class="order-status-changed"><span>{{date('d.m.Y', strtotime($order->last_status_date))}}</span></p>
                                                                <p><span>{{$azerpost}}</span></p>
                                                            </span>
                                                        </td>
                                                      
                                                        <td class="order-op">
                                                            <span class="order-view"
                                                                  data-message="{!! __('courier.order_not_selected') !!}"
                                                                  onclick="courier_show_packages({{$order->id}}, '{{route("courier_show_packages")}}', this);">
                                                                  <i class="fas fa-eye"></i>
                                                            </span>
                                                            <a order-id="{{$order->id}}" class="order-view edit-click">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        @if($order->last_status_id != 12)
                                                        {{-- <td class="order-op">
                                                            <a order-id="{{$order->id}}" class="order-view edit-click">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td> --}}
                                                        {{--<td class="order-op">
                                                            <span class="order-view" onclick="delet({{$order->id}}, '{{route("delete_courier_order")}}')">
                                                            <i class="fas fa-trash"></i></span>
                                                        </td> --}}
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div>
                                                {!! $orders->links(); !!}
                                            </div>
                                        </div>

                                        <div class="mobile-show">
                                            <div class="order-item">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    @foreach($orders as $order)
                                                        @php($address = $order->address)
                                                        @if(strlen($address) > 20)
                                                            @php($address = substr($address, 0, -20) . '...')
                                                        @endif
                                                        @if(strlen($order->area) > 15)
                                                            @php($area_name = substr($order->area, 0, 12) . '...')
                                                        @else
                                                            @php($area_name = $order->area)
                                                        @endif
                                                        @if(strlen($order->metro_station) > 15)
                                                            @php($metro_station_name = substr($order->metro_station, 0, 12) . '...')
                                                        @else
                                                            @php($metro_station_name = $order->metro_station)
                                                        @endif
                                                        <tr>
                                                            <td>{!! __('table.id') !!}</td>
                                                            <td>{{$order->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.area') !!}</td>
                                                            <td>{{$area_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.metro_station') !!}</td>
                                                            <td>{{$metro_station_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.address') !!}</td>
                                                            <td title="{{$order->address}}">{{$address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date</td>
                                                            <td>{{date('d.m.Y', strtotime($order->date))}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.payment_type') !!}</td>
                                                            <td>{{$order->payment_type}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.courier_payment') !!}</td>
                                                            <td>{{$order->amount}} AZN</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.shipping_payment') !!}</td>
                                                            <td>{{$order->delivery_amount}} AZN</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.total_payment') !!}</td>
                                                            <td>{{$order->total_amount}} AZN</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.status') !!}</td>
                                                            <td>
                                                                <span class="order-status"
                                                                      data-message="{!! __('courier.order_not_selected') !!}"
                                                                      onclick="courier_show_status_history({{$order->id}}, '{{route("courier_show_statuses_history")}}');">
                                                                    {{$order->status}}
                                                                    <p class="order-status-changed"><span>{{date('d.m.Y', strtotime($order->last_status_date))}}</span></p>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{!! __('courier.look_button') !!}</td>
                                                            <td class="order-op">
                                                                <span class="order-view"
                                                                      data-message="{!! __('courier.order_not_selected') !!}"
                                                                      onclick="courier_show_packages({{$order->id}}, '{{route("courier_show_packages")}}', this);"><i
                                                                            class="fas fa-eye"></i></span>
                                                            </td>
{{--                                                            <td class="order-op">--}}
{{--                                                                <span class="order-view" onclick="delet({{$order->id}}, '{{route("delete_courier_order")}}')">--}}
{{--                                                                <i class="fas fa-trash"></i></span>--}}
{{--                                                            </td>--}}
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div>
                                                    {!! $orders->links(); !!}
                                                </div>
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


    <div class="modal fade" id="show-packages-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! __('courier.track') !!}</th>
                                <th>{!! __('courier.gross_weight') !!}</th>
                                <th>{!! __('courier.amount') !!}</th>
                                <th>{!! __('courier.payment_type') !!}</th>
                                <th>{!! __('courier.client') !!}</th>
                                <th>{!! __('courier.status') !!}</th>
                            </tr>
                            </thead>
                            <tbody id="show_packages_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('show-packages-modal')"></div>
    </div>

    <div class="modal fade" id="show-statuses-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="order-popup-info" class="colorbox-block store-list-colorbox ch-padding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! __('courier.status') !!}</th>
                                <th>{!! __('courier.date') !!}</th>
                            </tr>
                            </thead>
                            <tbody id="show_statuses_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="close_modal" class="close_modal" onclick="close_modal('show-statuses-modal')"></div>
    </div>

  


    <!-- Modal -->
    <div class="modal fade" style="opacity: 1!important; background: #00000080; transition: width 2s;" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('courier_update_packages')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group field-userorder-product_name required">
                            <label class="control-label"
                                    for="updated_date">{!! __('courier.date') !!}</label>
                            <input type="date" id="updated_date"
                                    min="{{ $min_date }}"
                                    max="{{ $max_date }}"
                                    class="form-control" name="date"
                                    required>
                            <input type="hidden" id="id" name="id">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="update_button" type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <style>
        .packages_button {
            height: 40px;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 19px;
            cursor: pointer;
            background-color: white;
            color: #919191;
            border: 2px solid greenyellow;
        }

        .courier-pay-buttons, .delivery-pay-buttons {
            outline: none;
            margin: 0;
            border: none;
            cursor: not-allowed;
            width: 30%;
            /*background-color: darkgrey;*/
            opacity: 0.3;
        }

        .courier-pay-buttons > img, .delivery-pay-buttons > img {
            width: 30%;
            margin-top: 5px;
        }

        .courier-pay-buttons > small, .delivery-pay-buttons > small {
            display: block;
            margin: 5px 0;
        }

        .referrals_packages_class {
            display: none;
        }

        #courier-map {
            height: 340px;
        }

        #baki{
            display: block;
        }
        #rayonlar{
            display: none;
        }

    </style>
@endsection

@section('js')
    <script src="{{asset("frontend/js/courier.js?ver=0.1.8")}}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


{{--    <script>--}}
{{--        function initMap () {--}}
{{--            var geocoder = new google.maps.Geocoder();--}}
{{--                    var infowindow = new google.maps.InfoWindow();--}}

{{--                    // if(data.latitude & data.longitude){--}}
{{--                    //     var map = new google.maps.Map(document.getElementById('courier-map'), {--}}
{{--                    //         zoom: 10,--}}
{{--                    //         center: {lat:Number(data.latitude), lng:Number(data.longitude)},--}}
{{--                    //         mapTypeId: 'terrain',--}}
{{--                    //         gestureHandling: 'greedy'--}}
{{--                    //     });--}}
{{--                    //     var marker1 = new google.maps.Marker({--}}
{{--                    //         position: {lat:Number(data.latitude), lng:Number(data.longitude)},--}}
{{--                    //         map: map,--}}
{{--                    //         draggable: true,--}}
{{--                    //         anchorPoint: new google.maps.Point(0, -29)--}}
{{--                    //     });--}}
{{--                    // }--}}
{{--                        var map = new google.maps.Map(document.getElementById('courier-map'), {--}}
{{--                            zoom: 9,--}}
{{--                            center: {lat:40.5572989 , lng: 49.7188462},--}}
{{--                            mapTypeId: 'terrain',--}}
{{--                            gestureHandling: 'greedy'--}}
{{--                        });--}}
{{--                        var marker1 = new google.maps.Marker({--}}
{{--                            map: map,--}}
{{--                            draggable: true,--}}
{{--                            anchorPoint: new google.maps.Point(0, -29)--}}
{{--                        });--}}
{{--                    --}}
{{--                    var input1 = document.getElementById('address');--}}
{{--                    var options = {--}}
{{--                        componentRestrictions: {country: "az"}--}}
{{--                    };--}}
{{--                    google.maps.event.addDomListener(input1, 'keydown', function(event) {--}}
{{--                        if (event.keyCode === 13) {--}}
{{--                            event.preventDefault();--}}
{{--                        }--}}
{{--                    });--}}

{{--                    var autocomplete1 = new google.maps.places.Autocomplete(input1, options);--}}
{{--                    var pacContainerInitialized = false;--}}
{{--                    $('#address').keypress(function() {--}}
{{--                        if (!pacContainerInitialized) {--}}
{{--                            $('.pac-container').css('z-index', '9999');--}}
{{--                            pacContainerInitialized = true;--}}
{{--                        }--}}
{{--                    });--}}

{{--                    autocomplete1.addListener('place_changed', function () {--}}
{{--                        var place = autocomplete1.getPlace();--}}
{{--                        var location = place.geometry.location;--}}
{{--                        $('#delivery-long').val(location.lng());--}}
{{--                        $('#delivery-lat').val(location.lat());--}}
{{--                        // coord.LatLng = location;--}}
{{--                        if (place.geometry.viewport) {--}}
{{--                            map.fitBounds(place.geometry.viewport);--}}
{{--                        } else {--}}
{{--                            map.setCenter(location);--}}
{{--                            map.setZoom(17);--}}
{{--                        }--}}
{{--                        marker1.setPosition(location);--}}
{{--                        marker1.setVisible(true);--}}
{{--                    });--}}
{{--                    google.maps.event.addListener(marker1, 'dragend', function () {--}}
{{--                        geocoder.geocode({'latLng': marker1.getPosition()}, function (results, status) {--}}
{{--                            if (status == google.maps.GeocoderStatus.OK) {--}}
{{--                                if (results[0]) {--}}
{{--                                    // coord.LatLng = results[0].geometry.location;--}}
{{--                                    jQuery('#address').val(results[0].formatted_address);--}}
{{--                                    $('#delivery-long').val(results[0].geometry.location.lng());--}}
{{--                                    $('#delivery-lat').val(results[0].geometry.location.lat());--}}
{{--                                    infowindow.setContent(results[0].formatted_address);--}}
{{--                                    infowindow.open(map, marker1);--}}
{{--                                }--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}

{{--                        google.maps.event.addListener(map, "idle", function(){--}}
{{--                            google.maps.event.trigger(map, 'resize');--}}
{{--                        });--}}
{{--                    map.setZoom( map.getZoom() - 1 );--}}
{{--                    map.setZoom( map.getZoom() + 1 );--}}
{{--        }--}}
{{--    </script>--}}

    <script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false&amp;libraries=places,geometry&key=AIzaSyAfz-DTeJFbN0ZUnDLrpxZLb3nlDvA0uO8&callback=initMap" type="text/javascript"></script>

    <script>
        // update ajax start
        $('#update_button').click(function(e){

            id = $("#id").val();
            let date =$('#updated_date').val();
            
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
                console.log(date);
                e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: '{{route('courier_update_packages')}}',
                        data: {
                            'id': id,
                            date,
                            '_token': CSRF_TOKEN,
                        },
                        success: function (response) {
                        
                            swal.close();
                            if (response.case === 'success') {
                                $('.order_' + response.id).remove();
                                swal({
                                    position: 'top-end',
                                    type: response.case,
                                    title: response.title,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else {
                                swal(
                                    response.title,
                                    response.content,
                                    response.case
                                );
                            }
                            $('#updateModal').modal();
                        }
                });
        })
        
        $('#dataTable').on("click", ".edit-click", function(){
            addEventListenerToModal();
            id = $(this)[0].getAttribute('order-id');
            let date =$('#updated_date').val();
            
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
                console.log(date);

            $.ajax({
                    type: "GET",
                    url: '{{route('getdata')}}',
                    data: {
                        'id': id,
                        '_token': CSRF_TOKEN,
                    },
                    success: function (response) {
                        $('#updated_date').val("qweqw");
                        document.getElementById("updated_date").value = response.date;
                        let b= $('#id').val(response.id);
                        swal.close();
                        if (response.case === 'success') {
                            $('.order_' + response.id).remove();
                            swal({
                                position: 'top-end',
                                type: response.case,
                                title: response.title,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            swal(
                                response.title,
                                response.content,
                                response.case
                            );
                        }
                        $('#updateModal').modal();
                    }
            });

        });

        // update ajax end

        function addEventListenerToModal() {
            var today = new Date();
            var dateInput = document.getElementById("updated_date");

            dateInput.addEventListener("input", function() {
                var selectedDate = new Date(dateInput.value);
                var year = selectedDate.getFullYear();
                var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                var day = selectedDate.getDate().toString().padStart(2, '0');

                var formattedDate = year + '-' + month + '-' + day;
                if (formattedDate < '{{$min_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                } else if (formattedDate > '{{$max_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                }
            });
        }
    
    </script>

    <script>

        $(function() {
            $('#selectChange').change(function(){
                $('.show-hide').hide();
                $('#' + $(this).val()).show();
            });
        });


    </script>

    <script>
        $(".region_id").on("change", function () {
            var regionId = $(this).val();
            //console.log(regionId);

            $("#post_index").prop("disabled", false);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

            $.ajax({
                type: "GET",

                url: '{{route('azerpost_index_by_region')}}',
                data: { region_id: regionId, '_token': CSRF_TOKEN },
                dataType: "json",
                success: function (response) {

                    $("#post_index").empty().append('<option value="">' + "{!! __('courier.zip') !!}" + '</option>');
                    $.each(response.data, function (index, item) {
                        $("#post_index").append('<option value="' + item.id + '">' + item.index_code + ' - ' + item.address + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>

    <script>

        window.onload = function() {
            var today = new Date();
            var dateInput = document.getElementById("date");



            dateInput.addEventListener("input", function() {
                var selectedDate = new Date(dateInput.value);
                var year = selectedDate.getFullYear();
                var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                var day = selectedDate.getDate().toString().padStart(2, '0');

                var formattedDate = year + '-' + month + '-' + day;
                if (formattedDate < '{{$min_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                } else if (formattedDate > '{{$max_date}}') {
                    dateInput.value = '';
                    alert("Əllə seçim edə bilməzsiniz!");
                }
            });
        };
        if (window.innerWidth >= 768) {
            window.onload = function() {
                var today = new Date();
                var dateInput = document.getElementById("date");



                dateInput.addEventListener("input", function() {
                    var selectedDate = new Date(dateInput.value);
                    var year = selectedDate.getFullYear();
                    var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                    var day = selectedDate.getDate().toString().padStart(2, '0');

                    var formattedDate = year + '-' + month + '-' + day;
                    if (formattedDate < '{{$min_date}}') {
                        dateInput.value = '';
                        alert("Əllə seçim edə bilməzsiniz!");
                    } else if (formattedDate > '{{$max_date}}') {
                        dateInput.value = '';
                        alert("Əllə seçim edə bilməzsiniz!");
                    }
                });
            };
        }
        else{
            window.onload = function() {

                var dateInput = document.getElementById("date");
                dateInput.addEventListener("click", function() {
                   // console.log(this.type);
                    this.type = "date";
                });
                    //console.log(this.value);
                dateInput.addEventListener("input", function() {

                    var minDate = '{{$min_date}}';
                    var maxDate = '{{$max_date}}';
                    var selectedDate = new Date(dateInput.value);



                    var year = selectedDate.getFullYear();
                    var month = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
                    var day = selectedDate.getDate().toString().padStart(2, '0');

                    var formattedDate = year + '-' + month + '-' + day;

                   /* if (formattedDate < '{{$min_date}}') {
                        console.log(formattedDate < '{{$min_date}}');
                        this.value = minDate.toISOString().slice(0, 10);
                    } else if (formattedDate > '{{$max_date}}') {
                        console.log(formattedDate > '{{$max_date}}');
                        this.value = maxDate.toISOString().slice(0, 10);
                    }*/

                    //console.log(formattedDate);

                    if (formattedDate < '{{$min_date}}') {
                       // console.log(formattedDate < '{{$min_date}}');
                        dateInput.value = '';
                    } else if (formattedDate > '{{$max_date}}') {
                        //console.log(formattedDate > '{{$max_date}}');
                        dateInput.value = '';
                    }
                });
            };
        }

    </script>



@endsection
