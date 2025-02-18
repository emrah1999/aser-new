@extends('web.layouts.web')
@section('content')
    <div class="container new-style">
        <h1 class="section-title text-center font-n-b">{{$title->tracking_search}}</h1>
        <div class="form form-tracking-search center-block" name="formTrackingSearch" id="formTrackingSearch" novalidate="novalidate">
            <div class="row">
                <form id="trackingSearchForm" action="{{ route('tracking_search_in_aser', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <div class="col-sm-12">
                        <div class="form__group">
                            <label class="form__label" for="trackNumber">Trek nömrə</label>
                            <input class="form__input" name="track_number" type="text" id="trackNumber" placeholder="Trek nömrəni yazın" required>
                        </div>
                    </div>
                    <div class="col-sm-6" style="display: inline-block; width: 48%; padding-right: 5px;">
                        <button class="btn btn-yellow btn-block form__btn form-tracking-search__btn font-n-b" onclick="global_tracking_search();" name="formTrackingSearchGlobalSubmit" type="button">{!! __('tracking_search.global_search_button') !!}</button>
                    </div>
                    <div class="col-sm-6" style="display: inline-block; width: 48%; padding-left: 5px;">
                        <button class="btn btn-trns-yellow btn-block form__btn form-tracking-search__btn font-n-b" onclick="submitTrackingSearchForm()">Aserdə axtar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
@section('styles')
    <style>
        .new-style{
            margin-bottom: 30px;
            margin-top: 20px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function global_tracking_search () {
            let track = $('#trackNumber')
                .val()

            window.open('http://parcelsapp.com/az/tracking/' + track)
        }
    </script>

    <script>
        function submitTrackingSearchForm() {
            // Kullanıcıdan alınan trek numarasını al
            const trackNumber = document.getElementById('trackNumber').value;

            // Eğer trackNumber boşsa bir uyarı ver
            if (!trackNumber) {
                alert('Lütfen trek nömrəsini yazın!');
                return;
            }

            // Formu manuel olarak submit et
            const form = document.getElementById('trackingSearchForm');
            // Trek numarasını form alanına yerleştir
            form.track_number.value = trackNumber;

            // Formu gönder
            form.submit();
        }
    </script>


@endsection