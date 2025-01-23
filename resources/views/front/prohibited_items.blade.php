@extends('front.app')
@section('content')
    <section class="content-page-section">
        <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="#" target="/"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('menu.prohibited_products') !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content-header">
            <div class="container">
                <div class="row">
                    <div class="page-content-text">
                        <h3> {!! __('menu.prohibited_products') !!} </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="prohibited-textarea-block hide-on-mobile">
            <div class="container">
                <div class="row">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($items as $key=>$item)
                            @if($key==0)
                                <a class="nav-link active show" id="v-pills-tab{{$key+1}}" data-toggle="pill"
                                   href="#v-pills-{{$key+1}}" role="tab" aria-controls="v-pills-{{$key+1}}"
                                   aria-selected="true">{{$item->name}}</a>
                            @else
                                <a class="nav-link" id="v-pills-tab{{$key+1}}" data-toggle="pill"
                                   href="#v-pills-{{$key+1}}" role="tab" aria-controls="v-pills-{{$key+1}}"
                                   aria-selected="false">{{$item->name}}</a>
                            @endif
                        @endforeach
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">

                        @foreach($items as $key=>$item)
                            @if( $key==0)
                                <div class="tab-pane fade active show" id="v-pills-{{$key+1}}" role="tabpanel"
                                     aria-labelledby="v-pills-tab{{$key+1}}">
                                    {!! $item->item !!}
                                </div>
                            @else
                                <div class="tab-pane fade" id="v-pills-{{$key+1}}" role="tabpanel"
                                     aria-labelledby="v-pills-tab{{$key+1}}">
                                    {!! $item->item !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="prohibited-textarea-block hide-on-web">
            <div class="accordion" id="accordionExample">
                @foreach($items as $key=>$item)
                    <div class="card">
                        <div class="card-header" id="heading{{$key+1}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key+1}}" aria-expanded="true" aria-controls="collapse{{$key+1}}">
                                    {{$item->name}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$key+1}}" class="collapse" aria-labelledby="heading{{$key+1}}" data-parent="#accordion">
                            <div class="card-body">
                                {!! $item->item !!}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection

@section('css')
@endsection

@section('js')
@endsection