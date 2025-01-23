@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-breadcrumbs">
            <div class="container-lg">
                <div class="row justify-content-center align-items-start">
                    <div class="col-sm-6 col-7">
                        <ul class="nav nav-breadcrumbs font-n-b">
                            <li class="nav-breadcrumbs__item">
                                <a href="{{ route('ourServices_page', ['locale' => App::getLocale()]) }}" class="nav-breadcrumbs__link">Xidmətlərimiz</a>
                            </li>
                            <li class="nav-breadcrumbs__item nav-breadcrumbs__item--active">Kargomat</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-5">

                    </div>
                </div>
            </div>
        </section>
        <section class="section section-cargomats">
            <div class="container-lg">
                <div class="thumbnail thumbnail-cargomats">
                    <div class="thumbnail-cargomats__caption">
                        <p class="thumbnail-cargomats__title2 font-n-b">KARGOMAT-dan istifadə ödənişlidir?</p>
                        <p class="thumbnail-cargomats__desc2">KARGOMAT xidmətindən istifadə haqqı 1 azn təşkil edir</p>
                        <br>
                        <p class="thumbnail-cargomats__title2 font-n-b">KARGOMAT-dan necə istifadə edə bilərəm?</p>
                        <p class="thumbnail-cargomats__desc2">Sifariş ediln bağlamanın çatdırılma məntəqəsi olaraq sizə ən yaxın  ünvanda yerləşən KARGOMAT-i seçirsiniz?</p>
                        <br>
                        <p class="thumbnail-cargomats__title2 font-n-b">Sifariş KARGOMAT-a hnsı zaman müddətində çatdırılacaq?</p>
                        <p class="thumbnail-cargomats__desc2">Anbar statusu alan 24 saat ərzində KARGOMAT səbətlərinə yerləşdiriləcək</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
