
@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-promocodes">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">Promokod</h1>
                <div class="thumbnail thumbnail-orders center-block text-center">
                    <div class="thumbnail-orders__img-block">
                        <img class="thumbnail-orders__img" src="/web/images/content/promocode/promocode.png" alt="Promocode">
                    </div>
                    <div class="thumbnail-orders__caption">
                        <h5 class="thumbnail-orders__title font-n-b">Sizin promokodunuz yoxdur</h5>
                        <a href="#" class="btn btn-yellow thumbnail-orders__link d-flex justify-content-center align-items-center font-n-b">
                            <span class="thumbnail-orders__link-title">Promokod əlavə et</span>
                            <img class="thumbnail-orders__link-img" src="/web/images/content/promocode/plus-2.png" alt="Add">
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection