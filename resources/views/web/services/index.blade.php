@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-services">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">{!! __('menu.our_services') !!}</h1>
                <div class="row">

                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="{{route('ourServices_cargomat', ['locale' => App::getLocale()])}}" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-1.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Anbar xidməti</h6>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="{{route('ourServices_cargomat', ['locale' => App::getLocale()])}}" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-2.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">Ünvandan təhfil alma xidməti</h6>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail thumbnail-services">
                            <a href="{{route('ourServices_cargomat', ['locale' => App::getLocale()])}}" class="thumbnail-services__link">
                                <div class="thumbnail-services__img-block">
                                    <img class="thumbnail-services__img img-responsive" src="{{asset('web/images/content/service-3.png')}}" alt="Service">
                                </div>
                                <div class="thumbnail-services__caption">
                                    <h6 class="thumbnail-services__title text-center font-n-b">E-ticarət əməliyyətları</h6>
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
        <section class="section section-tarifs-country">
            <div class="container-lg">
                <div class="media media-tarif-country">
                    <div class="row">
                        <div class="media-tarif-country__body">
                            <h1 class="media-tarif-country__title font-n-b">{{$text->name}}</h1>
                            <p class="media-tarif-country__desc">
                                {{$text->content}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-contact">
            <div class="container-lg">
                <div class="section-contact__block center-block">
                    <form class="form form-contact" name="formContact" id="formContact" method="post" action="/" novalidate="novalidate">
                        <h3 class="form-contact__title text-center font-n-b">Sualınız var? Bizə yazın</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userName">Ad</label>
                                    <input class="form__input" name="user_name" type="text" id="userName" placeholder="Adınızı daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userSurname">Soyad</label>
                                    <input class="form__input" name="user_surname" type="text" id="userSurname" placeholder="Soyadınızı daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userEmail">Email</label>
                                    <input class="form__input" name="user_email" type="email" id="userEmail" placeholder="Emailiniz daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form__group">
                                    <label class="form__label" for="userPhone">Telefon</label>
                                    <input class="form__input" name="user_phone" type="text" id="userPhone" placeholder="Telefon nömrənizi daxil edin" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form__group">
                                    <label class="form__label" for="userMessage">Mesaj</label>
                                    <textarea class="form__textarea" name="user_message" id="userMessage" rows="6" placeholder="Mesajınızı yazın......" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-8">

                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-yellow btn-block form__btn form-contact__btn font-n-b" name="formContactSubmit" type="submit">Göndər</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="section section-blogs">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">Bloqlar</h1>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="/web/images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="/web/images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="/web/images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-questions">
            <div class="container-lg">
                <h1 class="section-title text-center font-n-b">Suallar və cavablar</h1>
                <div class="accordion accordion-questions" id="accordionQuestions">

                    <div class="row">
                        @foreach($faqs->chunk(6) as $faqChunk)
                            <div class="col-md-6">
                                @foreach($faqChunk as $faq)
                                    <div class="accordion-item accordion-questions__item">
                                        <h2 class="accordion-header accordion-questions__header">
                                            <button class="accordion-button accordion-questions__button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="false">
                                                {{$faq->name_az}}
                                            </button>
                                        </h2>
                                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionQuestions{{$faq->id}}">
                                            <div class="accordion-body accordion-questions__body">
                                                {!! $faq->content_az !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
@section('styles')
    <style>
        .media-tarif-country__title{
            text-align: center;
        }
        .thumbnail-services__img{
            border-radius: 10px;
            height: 320px;
        }
    </style>
@endsection