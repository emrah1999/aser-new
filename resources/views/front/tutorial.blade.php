@extends('front.app')
@section('content')
    <section class="content-page-section">
        <!-- breadcrumb -->
        <div class="brandcrumb-block">
            <div class="container">
                <div class="row space-between">
                    <ul class="brandcrumb-ul">
                        <li><a href="#" target="/"> {!! __('static.aser') !!} </a></li>
                        <li>{!! __('menu.tutorial') !!}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tutorial-section">
            <div class="container">
                <div class="row">
                    <div class="tutorial-block">
                        <ul class="tutorial-ul">
                            @foreach($tutorials as $key=>$tutorial)
                                <li>
                                    <div class="tutorial-image">
                                        <img src="{{$tutorial->img}}" title="{{$tutorial->content}}"
                                             alt="{{$tutorial->content}}">
                                    </div>
                                    <div class="tutorial-content">
                                        <p> {{$tutorial->content}}</p>
                                    </div>
                                    <div class="tutorial-link video-link">
                                        <a id="click{{$key+1}}" href="#video{{$key+1}}" data-media="{{$tutorial->video}}"
                                           class="play-button"> <i class="fa fa-play"></i> </a>
                                        <div class="popup" id="video{{$key+1}}">
                                            <iframe width="70%" height="70%" src="" frameborder="0"
                                                    allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
@endsection

@section('js')
@endsection