@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-cargo-service">
            <div class="container-lg">
                <div class="media media-cargo-service">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="media-cargo-service__body">
                                <h4 class="media-cargo-service__title font-n-b">Hava nəqliyyatı</h4>
                                <p class="media-cargo-service__desc">
                                    Türkiyədən Azərbaycana kargo şirkətləri geniş xidmət spektri
                                    ilə müştərilərə sürətli və etibarlı çatdırılma təklif edir.
                                    Bu şirkətlər arasında müxtəlif qiymət və şərtlərlə Türkiyədən
                                    sifariş xidmətləri göstərənlər mövcuddur, beləliklə, müştərilər
                                    öz tələblərinə uyğun ən sərfəli seçim edə bilərlər.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-cargo-service__right">
                                <img class="media-cargo-service__img img-responsive" src="/web/images/content/cargo-service.png" alt="Cargo">
                            </div>
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
    </div>
@endsection