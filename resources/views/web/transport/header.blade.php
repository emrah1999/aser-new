@extends('web.layouts.web')
@section('content')
    <div class="content" id="content">
        <section class="section section-cargo">
            <div class="container-lg">
                <h2 class="section-title text-center font-n-b">Yük daşıma</h2>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-cargo">
                            <a href="header-cargo-service.html" class="thumbnail-cargo__link">
                                <div class="thumbnail-cargo__img-block">
                                    <img class="thumbnail-cargo__img img-responsive" src="images/content/cargo-1.png" alt="Cargo">
                                </div>
                                <div class="thumbnail-cargo__caption text-center">
                                    <h4 class="thumbnail-cargo__title font-n-b">Hava nəqliyyatı</h4>
                                    <p class="thumbnail-cargo__desc">
                                        Hava nəqliyyatı ilə istənilən ölçülü yüklərin,
                                        həmçinin təhlükəli yüklərin və canlı  heyvanların
                                        dünyanın istənilən nöqtələrə daşınması
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-cargo">
                            <a href="header-cargo-service.html" class="thumbnail-cargo__link">
                                <div class="thumbnail-cargo__img-block">
                                    <img class="thumbnail-cargo__img img-responsive" src="images/content/cargo-2.png" alt="Cargo">
                                </div>
                                <div class="thumbnail-cargo__caption text-center">
                                    <h4 class="thumbnail-cargo__title font-n-b">Avtomobil  nəqliyyatı</h4>
                                    <p class="thumbnail-cargo__desc">
                                        Fəaliyyət göstərdiyimiz xarici ölkələrdə
                                        istənilən ölçülü yüklərin avtomobil nəqliyyatı ilə bir nöqtədə digər nöqtəyə daşınması
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-cargo">
                            <a href="header-cargo-service.html" class="thumbnail-cargo__link">
                                <div class="thumbnail-cargo__img-block">
                                    <img class="thumbnail-cargo__img img-responsive" src="images/content/cargo-3.png" alt="Cargo">
                                </div>
                                <div class="thumbnail-cargo__caption text-center">
                                    <h4 class="thumbnail-cargo__title font-n-b">Dəniz nəqliyyatı</h4>
                                    <p class="thumbnail-cargo__desc">
                                        Dəniz nəqliyyatı ilə istənilən ölçülü yüklərin dünyanın istənilən nöqtəsinə daşınması
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail thumbnail-cargo">
                            <a href="header-cargo-service.html" class="thumbnail-cargo__link">
                                <div class="thumbnail-cargo__img-block">
                                    <img class="thumbnail-cargo__img img-responsive" src="images/content/cargo-4.png" alt="Cargo">
                                </div>
                                <div class="thumbnail-cargo__caption text-center">
                                    <h4 class="thumbnail-cargo__title font-n-b">Dəmiryolu nəqliyyatı</h4>
                                    <p class="thumbnail-cargo__desc">
                                        Dəmiryolu nəqliyyatı ilə istənilən ölçülü yüklərin dünyanın istənilən nöqtəsinə daşınması
                                    </p>
                                </div>
                            </a>
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
                                    <img class="thumbnail-blogs__img img-responsive" src="images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumbnail-blogs">
                            <a href="#" class="thumbnail-blogs__link">
                                <div class="thumbnail-blogs__img-block">
                                    <img class="thumbnail-blogs__img img-responsive" src="images/content/blog-1.png" alt="Blog">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection