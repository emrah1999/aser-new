@extends('front.app')
@section('content')
    <section class="content-page-section padding-bottom-14">
        <!-- brand crumb -->
    </section>
    <section class="store-section">
        <div class="container">
            <div class="row">
                <div class="store-header section-header">
                    <h3> {!! __('static.stores') !!} </h3>
                </div>
                <div class="section-content">
                    <ul class="sellers">
                        @foreach ($sellers as $seller)
                            <li>
                                <a href="{{ url('/r?url=' . urlencode($seller->url)) }}" target="_blank">
                                    <img src="https://manager.asercargo.az/{{ $seller->img }}" alt="{{ $seller->title }}" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="store-more">
                        
                    </div>
                </div>
            </div>
            <div class="pagination">
                {{ $sellers->links() }}
            </div>
        </div>
    </section>
@endsection

@section('css')

@endsection

@section('js')

@endsection