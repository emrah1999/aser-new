<style>
    @keyframes blink {
        0% {
            color: red;
        }
        50% {
            color: #203f2d;
        }
        100% {
            color: red;
        }
    }

    .blink {
        animation: blink 1s infinite;
    }

</style>

<div class="page-content-left">
    <!-- profile block panel -->


    <div class="profile-block-panel inside-account-sidebar">
        <div class="profile-image upload-profile-img">
            <img id="imgArea" src="{{Auth::user()->profile_image()}}" title="profile" alt="profile"/>
            <label class="change-profile">
                <span class="form-group field-change-img">
                    <input type="file" id="change-img" class="hidden image_upload_file"
                           onchange="change_profile_image(this, '{{route("update_user_profile_image", ['locale' => App::getLocale()])}}');"
                           accept="image/jpeg,png,jpg,jpeg,gif,svg">
                </span>
            </label>
        </div>
        <div class="profile-info">
            <h4 style="text-transform: capitalize;">
                {{Auth::user()->full_name()}}
                <a class="edit-account-info" href="{{route("get_update_user_account", ['locale' => App::getLocale()])}}"><i class="fas fa-pencil-alt"></i></a>
            </h4>
            <span style="display: block !important; color: #333" class="userIdCode" > ID: <code> AS{{Auth::user()->suite()}} </code> </span>
        </div>

        <ul class="profile-control-ul desktop-show">
            <li><a href="{{route("get_account", ['locale' => App::getLocale()])}}">{!! __('account_menu.my_account') !!} </a></li>
            <li><a href="{{route("special_order_select", ['locale' => App::getLocale()])}}" class="blink">{!! __('static.order_title') !!} </a></li>
            <li><a href="{{route("get_orders", ['locale' => App::getLocale()])}}">{!! __('account_menu.order') !!} </a></li>
            <li><a href="{{route("get_seller_otp", ['locale' => App::getLocale()])}}">OTP </a></li>
            <li><a href="{{route("get_courier_page", ['locale' => App::getLocale()])}}">{!! __('account_menu.courier') !!} </a></li>
            <li><a href="{{route("get_azerpost_courier_page", ['locale' => App::getLocale()])}}">{!! __('account_menu.courier_azerpost') !!} </a></li>
            <li><a href="{{route("get_balance_page", ['locale' => App::getLocale()])}}">{!! __('account_menu.balance') !!} </a></li>
            @if(Auth::user()->is_partner == 1)
                <li><a href="{{route("get_payment_page", ['locale' => App::getLocale()])}}">Ödəmə et </a></li>
            @endif
            <li><a href="{{route("get_sub_accounts", ['locale' => App::getLocale()])}}">{!! __('account_menu.referral_accounts') !!} </a></li>
            <li><a href="{{route("get_update_user_account", ['locale' => App::getLocale()])}}">{!! __('account_menu.update_user_details') !!} </a></li>
            <li style="padding-bottom: 18px;"><a href="{{route("logout", ['locale' => App::getLocale()])}}"> {!! __('account_menu.logout') !!} </a></li>
        </ul>

        <div class="mobile-show account-main-menu">
            <br><br><br>
            <div class="account-menu-control" id="account-menu-title">{!! __('static.key_links') !!}</div>
            <ul>
                <li id="menu-warehouse">
                    <a href="{{ route('get_account', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-warehouse', '{!! __('account_menu.my_account') !!}')">
                        {!! __('account_menu.my_account') !!}
                    </a>
                </li>
                <li id="menu-special_order">
                    <a href="{{ route('special_order_select', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-special_order', '{!! __('static.order_title') !!}')">
                        {!! __('static.order_title') !!}
                    </a>
                </li>
                <li id="menu-warehouse">
                    <a href="{{ route('get_seller_otp', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-seller_otp', 'OTP')">
                        OTP
                    </a>
                </li>
                <li id="menu-orders">
                    <a href="{{ route('get_orders', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-orders', '{!! __('account_menu.order') !!}')">
                        {!! __('account_menu.order', ['locale' => App::getLocale()]) !!}
                    </a>
                </li>
                <li id="menu-courier">
                    <a href="{{ route('get_courier_page', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-courier', '{!! __('account_menu.courier') !!}')">
                        {!! __('account_menu.courier') !!}
                    </a>
                </li>
                <li id="menu-balance">
                    <a href="{{ route('get_balance_page', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-balance', '{!! __('account_menu.balance') !!}')">
                        {!! __('account_menu.balance') !!}
                    </a>
                </li>
                <li id="menu-referral">
                    <a href="{{ route('get_sub_accounts', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-referral', '{!! __('account_menu.referral_accounts') !!}')">
                        {!! __('account_menu.referral_accounts') !!}
                    </a>
                </li>
                <li id="menu-referral">
                    <a href="{{ route('get_sub_accounts', ['locale' => App::getLocale()]) }}" title="" onclick="setActiveMenu('menu-referral', '{!! __('account_menu.referral_accounts') !!}')">
                       Referal Hesablar
                    </a>
                </li>
                <li id="menu-update">
                    <a href="{{ route('get_update_user_account', ['locale' => App::getLocale()]) }}" onclick="setActiveMenu('menu-update', '{!! __('account_menu.update_user_details') !!}')">
                        {!! __('account_menu.update_user_details') !!}
                    </a>
                </li>
                <li id="menu-logout" style="padding-bottom: 18px;">
                    <a href="{{ route('logout', ['locale' => App::getLocale()]) }}" onclick="setActiveMenu('menu-logout', '{!! __('account_menu.logout') !!}')">
                        {!! __('account_menu.logout') !!}
                    </a>
                </li>
            </ul>
        </div>


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function setActiveMenu(menuId, menuTitle) {
            localStorage.setItem('activeMenu', menuId);
            localStorage.setItem('activeMenuTitle', menuTitle);
            updateMenuTitle(menuTitle);
        }

        function updateMenuTitle(menuTitle) {
            var menuTitleElement = document.getElementById('account-menu-title');
            if (menuTitleElement) {
                menuTitleElement.innerHTML = menuTitle;
            }
        }

        function showActiveMenu() {
            var activeMenu = localStorage.getItem('activeMenu');
            var activeMenuTitle = localStorage.getItem('activeMenuTitle');
            if (activeMenu && activeMenuTitle) {
                updateMenuTitle(activeMenuTitle);
            } else {
                setActiveMenu('menu-warehouse', '{!! __('account_menu.my_account') !!}');
            }
        }

        window.setActiveMenu = setActiveMenu;
        window.showActiveMenu = showActiveMenu;

        showActiveMenu();
    });
</script>
