<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-5 left-bar-new-style">
    <div class="d-none d-lg-none text-center mobile-menu-head">
        <div class="profile-info">
            <h4 style="text-transform: capitalize;">
                {{Auth::user()->full_name()}}
            </h4>
            <span style="display: block !important; color: #333" class="userIdCode"> ID: <strong> AS{{Auth::user()->suite()}} </strong> </span>
        </div>

        <div class="mobile-show account-main-menu">
            <div class="account-menu-control" id="account-menu-title">Menyu <i class="fa fa-chevron-down mobile-icon-menu"></i></div>

        </div>
    </div>
    <ul class="nav nav-profile-menu d-none d-lg-block">
        <li class="nav-profile-menu__item">
            <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}"
                class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_account') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-address.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-address.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.my_account') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('get_orders', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_orders') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-package.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-package.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.order') !!}</span>
            </a>
        </li>

        <li class="nav-profile-menu__item">
            <a href="{{ route('branchAndPudo', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('branchAndPudo') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-package.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/profile-menu-package.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{{ optional($menu['branch'])->{'name_' . App::getLocale()} }}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_courier_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_courier_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-curier.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-curier.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.courier') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('special_order_select', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('special_order_select') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/other-plus-4.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/other-plus-4.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.order_title') !!}</span>
            </a>
        </li>

        <li class="nav-profile-menu__item">
            <a href="{{route("get_azerpost_courier_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_azerpost_courier_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-azerpoct.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-azerpoct.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.courier_azerpost') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_balance_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_balance_page') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-balance.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-balance.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('account_menu.balance') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_sub_accounts", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_sub_accounts') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/referal-new.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/referal-new.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.refereal_account') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('get_seller_otp', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('get_seller_otp', ['locale' => App::getLocale()]) ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/otp-new.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/otp-new.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.otp') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('onay_code_list', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('onay_code_list') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/otp-new.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/otp-new.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.trendyol_otp') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{ route('spain_otp_list', ['locale' => App::getLocale()]) }}"
               class="nav-profile-menu__link d-flex justify-content-start align-items-center
                    {{ request()->routeIs('spain_otp_list') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/otp-new.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img nav-profile-menu__link-img--active" src="/web/images/content/otp-new.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.otp_messages') !!}</span>
            </a>
        </li>
        <li class="nav-profile-menu__item">
            <a href="{{route("get_user_settings", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_user_settings') ? 'nav-profile-menu__link--active' : '' }}">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-user.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-user.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.profile') !!}</span>
            </a>
        </li>

        {{--<li class="nav-profile-menu__item">
            <a href="#" class="nav-profile-menu__link d-flex justify-content-start align-items-center">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-promocode.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-promocode.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">Promokod</span>
            </a>
        </li>--}}

        {{--<li class="nav-profile-menu__item">
            <a href="{{route("get_notification_page", ['locale' => App::getLocale()])}}" class="nav-profile-menu__link d-flex justify-content-start align-items-center {{ request()->routeIs('get_notification_page') ? 'nav-profile-menu__link--active' : '' }}">
        <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-notification.png" alt="ProfileMenu">
        <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-notification.png" alt="ProfileMenu">
        <span class="nav-profile-menu__link-title">Bildirişlər</span>
        </a>
        </li>--}}

        <li class="nav-profile-menu__item">
            <a class="nav-profile-menu__link d-flex justify-content-start align-items-center" data-bs-toggle="modal" data-bs-target="#modalProfileLogout">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-exit.png" alt="ProfileMenu">
                <img class="nav-profile-menu__link-img" src="/web/images/content/profile-menu-exit.png" alt="ProfileMenu">
                <span class="nav-profile-menu__link-title">{!! __('static.logout') !!}</span>
            </a>
        </li>
    </ul>
</div>


@section('styles1')
<style>
    .mobile-menu-head{
        background: #fdf9e9;
        border-radius: 10px;
        margin-top: 10px;
        padding-bottom: 10px;
        padding-top: 10px;
    }
    .mobile-icon-menu{
        margin-left: 8px;
    }
    
</style>
@endsection
@section('scripts1')
<script>
    $('#account-menu-title').click(function() {
        if ($('.nav-profile-menu').hasClass('d-none')) {
            $('.nav-profile-menu').addClass('d-block')
            $('.nav-profile-menu').removeClass('d-none')
            $('.mobile-menu-head').css('margin-bottom','-11px')
            $('.mobile-icon-menu').removeClass('fa-chevron-down')
            $('.mobile-icon-menu').addClass('fa-chevron-up')
        } else {
            $('.nav-profile-menu').removeClass('d-block')
            $('.nav-profile-menu').addClass('d-none')
            $('.mobile-menu-head').css('margin-bottom','10px')
            $('.mobile-icon-menu').removeClass('fa-chevron-up')
            $('.mobile-icon-menu').addClass('fa-chevron-down')
        }
    })

</script>
@endsection