<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-5 left-bar-new-style">
    <ul class="nav nav-profile-menu">
        <li class="nav-profile-menu__item">
            <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}"
            class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_account') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-address.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-address-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.my_account') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('special_order_select', ['locale' => App::getLocale()]) }}"
            class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_account') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-address.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-address-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.order_title') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('get_orders', ['locale' => App::getLocale()]) }}"
            class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_orders') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-package.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-package-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.order') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('get_seller_otp', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_seller_otp', ['locale' => App::getLocale()]) ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-package.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-package-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">OTP</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_balance_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_balance_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-balance.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-balance-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.balance') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="#" class="nav-profile-menu__link d-flex justify-content-start align-items-center">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-promocode.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-promocode-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">Promokod</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_courier_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_courier_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-curier.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-curier-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.courier') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_azerpost_courier_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_azerpost_courier_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-azerpoct.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-azerpoct-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.courier_azerpost') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_notification_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_notification_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-notification.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-notification-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">Bildirişlər</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_sub_accounts", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_sub_accounts') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-notification.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-notification-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">Referal Hesablar</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_user_settings", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_user_settings') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-user.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-user-active.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">Profil</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a class="nav-profile-menu__link d-flex justify-content-start align-items-center" data-bs-toggle="modal" data-bs-target="#modalProfileLogout">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-exit.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-exit.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">Çıxış</span>
            </a>
        </li>
    </ul>
</div>

<div class="modal modal-profile-logout fade" id="modalProfileLogout" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-profile-logout__dialog center-block">
        <div class="modal-content modal-profile-logout__content">
            <div class="modal-header modal-profile-logout__header justify-content-end">
                <img class="modal-profile-logout__img-close" src="/web/images/content/modal-close.png" alt="Modal Close" data-bs-dismiss="modal">
            </div>
            <div class="modal-body modal-profile-logout__body">
                <form class="form form-modal-profile form-modal-profile-logout center-block" name="formModalProfileLogout" id="formModalProfileLogout" method="get" action="{{route("logout", ['locale' => App::getLocale()])}}" novalidate="novalidate">
                    <h6 class="form-modal-profile__title form-modal-profile-logout__title text-center font-n-b">Hesabdan çıxış edilsin?</h6>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-trns-black btn-block form__btn form-modal-profile__btn form-modal-profile-logout__btn font-n-b" type="button" data-bs-dismiss="modal">Xeyr</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-blue btn-block form__btn form-modal-profile__btn form-modal-profile-logout__btn font-n-b" name="formModalProfileLogoutSubmit" type="submit">Bəli</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>