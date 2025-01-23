@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-services">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{!! __('menu.our_services') !!}</h1>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="#" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-1.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Xaricdəki ünvanlar</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="#" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-2.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Kuryer</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="{{route('ourServices_branhces', ['locale' => App::getLocale()])}}" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-3.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Filiallar</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="{{route('ourServices_cargomat', ['locale' => App::getLocale()])}}" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-4.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Kargomat</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="#" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-5.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Etibarnamə</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection