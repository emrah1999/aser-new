<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return redirect('/' . app()->getLocale());
});
Route::get('/branch2','OurServiceController@branchNew');
Route::get('/sitemap.xml','SitemapController@sitemap');

Route::get('/testMurad', [RegisterController::class, 'testMurad']);
Route::get('/language/{locale}', 'LanguageController@set_locale_language')->name("set_locale_language");
Route::get('/r', 'RedirectController@redirect')->name('redirect_seller');
Route::group(['prefix' => '/{locale}', 'middleware' => 'Language'], function () {
    Route::post('change-password',[\App\Http\Controllers\Auth\ResetPasswordController::class,'resetPasswordPage'])->name('resetPasswordPage');

    Route::get('/', 'IndexController@index')->name("home_page");
    Route::get('/home', 'IndexController@index');
    Route::get('/login-test', 'LoginClientController@index');
    Route::get('/register-physical', 'RegisterController@getPhysicalRegister');
    Route::get('/registevvv', 'RegisterController@getPhysicalRegister');
    Route::get('/register-juridical', 'RegisterController@getJuridicalRegister');
    Route::get('/register-otp', 'RegisterController@getOTPRegister');
    Route::get('/terms-and-conditions', 'IndexController@terms_and_conditions') -> name("terms_and_conditions");
    Route::get('/get-sellers/{type}', 'IndexController@get_seller_by_type') -> name("get_seller_by_type");
    Route::post('/feedback', 'IndexController@feedback') -> name("send_feedback");
//    Route::get('/transport', 'IndexController@show_transport')->name("transport_page");
    Route::get('/promo-code', 'IndexController@promo_code') -> name("promo_code");
    Route::get('/index', 'IndexController@index');
    Route::get('/blogs', 'BlogController@index')->name("blogs");



    Route::post('/reset-password/{type?}', 'OTPController@reset')->name('reset_email');
//    Route::get('/tracking-search', 'TrackingSearchController@get_tracking_search')->name("get_tracking_search");
    Route::get('/local-tracking-search', 'TrackingSearchController@local_tracking_search')->name("local_tracking_search");
//    Route::get('/tracking-search-in-ASER', 'TrackingSearchController@tracking_search_in_aser')->name('tracking_search_in_aser');
    Route::post('/tracking-search-in-ASER', 'TrackingSearchController@tracking_search_in_aser')->name('tracking_search_in_aser');


    Route::group(['prefix' => '/contact'], function () {
        Route::get('/', 'ContactController@index')->name("contact_page");
        Route::get('/test', 'ContactController@index_footer')->name("contact_footer_page");
        Route::post('/', 'ContactController@message')->name("contact_message");
    });

    Route::group(['prefix' => '/services'], function () {
        Route::get('/dangerous-goods', 'DangerousGoodsController@index')->name("dangerous_goods_page");
    });

    Route::post('/calculate-amount', 'IndexController@calculate_amount')->name("calculate_amount");

    Route::get('/faq', 'FaqController@index')->name("faq_page");
    Route::get('/sellers', 'SellerController@show_sellers')->name("sellers_page");
    /*Route::get('/tariffs', 'TariffController@show_tariffs')->name("tariffs_page");*/
    Route::get('/videos', 'NewsController@video_show')->name("video_page");
    Route::get('/about', 'AboutController@index')->name("about_page");
    Route::get('/prohibited-items', 'ProhibitedItemsController@index')->name("prohibited_items");
    Route::get('/tutorial', 'TutorialController@index')->name("tutorial");

    Route::get('/branch-station', 'AccountController@branchAndPudo')->name("branchAndPudo");



    Route::group(['prefix' => '/our-services'], function () {
        Route::get('/', 'OurServicesController@index')->name("ourServices_page");
        Route::get('/branches', 'OurServicesController@branches')->name("ourServices_branhces");
        Route::get('/cargomat', 'OurServicesController@cargomat')->name("ourServices_cargomat");
    });

    Route::group(['prefix' => '/tariffs'], function () {
        Route::get('/', 'TariffController@index')->name("tariffs_page");
        Route::get('/{country_id}/', 'TariffController@show_tariffs')->name("show_tariffs");
    });

    Route::group(['prefix' => '/transport'], function () {
        Route::get('/', 'TransportController@show_transport')->name("transport_page");
        Route::get('/{id}', 'TransportController@getTransportPage')->name("getTransportPage");
    });


    Route::group(['prefix' => '/news'], function () {
        Route::get('/', 'NewsController@show_news')->name("news_page");
        Route::get('/{id}', 'NewsController@news_details')->name("news_details");
    });

    Route::group(['middleware' => ['Login', 'auth']], function () {
        Route::get('/onay-kodu', 'OTPController@getOnayCodeList')->name("onay_code_list")->middleware(['auth', 'Login']);
        Route::get('/shipping-days', 'AccountController@get_shipping_days')->name("shipping_days.index");
        Route::get('/shipping-days/{country_id}', 'AccountController@get_shipping_days_details')->name("shipping_days.details");
    });

    Route::group(['prefix' => '/account', 'middleware' => ['Login', 'auth']], function () {

        Route::get('/', 'AccountController@get_account')->name("get_account");
        Route::post('/change-branch', 'AccountController@change_branch')->name("change_branch");
        Route::post('/save-token', 'NotificationController@saveToken')->name('saveToken');

        Route::group(['prefix' => '/details'], function () {
            Route::get('/', 'AccountController@get_user_account')->name("get_user_settings");
            Route::get('/change-notification-settings', 'AccountController@change_notification')->name("change_notification_settings");

            Route::get('/update', 'AccountController@get_update_user_account')->name("get_update_user_account");
            Route::post('/update', 'AccountController@post_update_user_account')->name("post_update_user_account");

            Route::get('/update-password', 'AccountController@get_update_user_password')->name("get_update_user_password");
            Route::post('/update-password', 'AccountController@post_update_user_password')->name("post_update_user_password");
            Route::post('/profile-image', 'AccountController@update_user_profile_image')->name("update_user_profile_image");
        });

        Route::get('/referral/approve/{referral}', 'AccountController@approve_referral_user')->name("approve_referral_user_account");

        Route::get('/country/{country_id}', 'AccountController@get_country_details')->name("get_country_details");
        Route::group(['prefix' => '/orders'], function () {
            Route::get('/', 'AccountController@get_packages')->name("get_orders");
            Route::post('/pay/{package_id}', 'AccountController@pay_package')->name("pay_order");
            Route::get('/items', 'AccountController@get_package_items')->name("get_package_items");
            Route::post('/item/{id}', 'AccountController@invoiceUpload')->name("post_invoice_upload");
            Route::get('/add', 'AccountController@get_preliminary_declaration')->name("get_package_add");
            Route::post('/add', 'AccountController@post_preliminary_declaration')->name("post_package_add");
            Route::get('/update/{package_id}', 'AccountController@get_package_update')->name("get_package_update");
            Route::post('/update/{package_id}', 'AccountController@post_package_update')->name("post_package_update");
            Route::delete('/delete/{package_id}', 'AccountController@delete_package')->name("delete_package");


            Route::post('/send-legality', 'AccountController@send_legality')->name("send_legality");
            Route::post('/bulk-pay', 'AccountController@bulk_pay')->name("bulk_pay");
        });

        Route::group(['prefix' => '/seller-otp'], function () {
            Route::get('/spain', 'SellerOtpController@getForwardSmsLog')->name("spain_otp_list");

            Route::get('/', 'SellerOtpController@index')->name("get_seller_otp");
            Route::get('/add', 'SellerOtpController@create')->name("get_seller_add");
            Route::post('/add', 'SellerOtpController@store')->name("post_seller_add");
            Route::get('/update/{package_id}', 'SellerOtpController@get_package_update')->name("get_seller_package_update");
            Route::post('/update/{package_id}', 'SellerOtpController@post_package_update')->name("post_seller_package_update");
            Route::delete('/delete/{package_id}', 'SellerOtpController@delete_package')->name("delete_package");


            Route::post('/send-legality', 'AccountController@send_legality')->name("send_legality");
            Route::post('/bulk-pay', 'AccountController@bulk_pay')->name("bulk_pay");
        });

        Route::group(['prefix' => '/special-order'], function () {
            Route::get('/', 'AccountController@get_special_orders_select')->name("special_order_select");
            Route::get('/{country_id}', 'AccountController@get_special_orders')->name("special_order");
            Route::get('/{country_id}/show-orders', 'AccountController@show_orders_for_group_special_orders')->name("show_orders_for_group_special_orders");
            Route::post('/', 'AccountController@add_special_order')->name("add_special_order");
            Route::post('/{country_id}/pay{order_id}', 'AccountController@pay_to_special_order')->name("pay_to_special_order");
            Route::delete('/{country_id}/{order_id}', 'AccountController@delete_special_order')->name("delete_special_order");
            Route::get('/{country_id}/{order_id}', 'AccountController@get_special_order_update')->name("get_special_order_update");
            Route::post('/{country_id}/{order_id}', 'AccountController@update_special_order')->name("update_special_order");
        });
        Route::group(['prefix' => '/sub-accounts'], function () {
            Route::get('/', 'AccountController@get_sub_accounts')->name("get_sub_accounts");
            Route::post('/login', 'AccountController@login_referal_account')->name("login_referal_account");
            Route::post('/balance/add', 'AccountController@add_referal_balance')->name("add_referal_balance");
            Route::post('/pay-all-debt', 'AccountController@pay_all_referral_debt')->name("pay_all_referral_debt");
            //        Route::group(['prefix'=>'/balance/add'], function () {
            //            Route::post('/my-balance', 'AccountController@add_referal_balance_from_my_balance')->name("add_referal_balance_from_my_balance");
            //            Route::post('/cart', 'AccountController@add_referal_balance_from_cart')->name("add_referal_balance_from_cart");
            //        });
            Route::group(['prefix' => '/orders'], function () {
                Route::get('/', 'AccountController@get_packages_by_sub_accounts')->name("get_orders_by_sub_accounts");

                Route::post('/update/{package_id}', 'AccountController@post_package_update_by_sub_accounts')->name("post_package_update_by_sub_accounts");
            });
        });
        Route::group(['prefix' => '/balance'], function () {
            Route::get('/', 'AccountController@get_balance_page')->name("get_balance_page");
            Route::post('/', 'AccountController@amount_send_to_millikart')->name("post_balance_page");
            Route::get('/operations', 'AccountController@get_balance_logs')->name("get_balance_logs");
        });
        Route::group(['prefix' => '/courier'], function () {
            Route::get('/', 'AccountController@get_courier_page')->name("get_courier_page");
            Route::get('/create-courier', 'AccountController@get_create_courier_page')->name("get_create_courier_page");
            Route::get('/show-referrals-packages', 'AccountController@show_packages_of_referrals')->name("courier_show_packages_of_referrals");
            Route::get('/show-status-history', 'AccountController@courier_show_statuses_history')->name("courier_show_statuses_history");
            Route::get('/show-packages', 'AccountController@courier_show_packages')->name("courier_show_packages");
            Route::get('/get-courier-payment-types', 'AccountController@courier_get_courier_payment_types')->name("courier_get_courier_payment_types");
            Route::get('/get-delivery-payment-types', 'AccountController@courier_get_delivery_payment_types')->name("courier_get_delivery_payment_types");
            Route::get('/get-packages', 'AccountController@courier_get_packages')->name("courier_get_packages");
            Route::post('/create-order', 'AccountController@courier_create_order')->name("courier_create_order");

            Route::get('/azerpost', 'AccountController@get_azerpost_courier_page')->name("get_azerpost_courier_page");
            Route::get('/create-azerpost', 'AccountController@get_create_azerpost_page')->name("get_create_azerpost_page");
            Route::post('/create-order-region', 'AccountController@courier_create_order_region')->name("courier_create_order_region");
            Route::delete('/delete', 'AccountController@delete_courier_order')->name("delete_courier_order");
            Route::post('/update', 'AccountController@courier_update_packages')->name("courier_update_packages");
            Route::get('/getData','AccountController@getData')->name('getdata');
            Route::get('/get-courier-payment-types-regions', 'AccountController@courier_get_region_payment_tariff')->name("courier_get_region_payment_tariff");
            Route::get('/azerpost_index_by_region', 'AccountController@azerpostIndexByRegion')->name("azerpost_index_by_region");
        });

        Route::group(['prefix' => '/payment'], function () {
            Route::get('/', 'AccountController@get_payment_page')->name("get_payment_page");
            Route::post('/', 'AccountController@payment_send_to_millikart')->name("post_payment_page");
            Route::get('/operations', 'AccountController@get_payment_logs')->name("get_payment_logs");
            Route::get('/test-azeri-card', 'PaymentController@payment');
        });

        Route::group(['prefix' => '/address-otp'], function () {
            Route::post('/incoming-otp', 'AccountController@set_incoming_otp')->name("set_incoming_otp");
        });

        Route::group(['prefix' => '/notification'], function () {
            Route::get('/', 'AccountController@get_notification_page')->name("get_notification_page");
        });

    });

    Auth::routes(['verify' => true]);
    Route::get('/login-client-account/{token}', 'LoginClientController@login');
    Route::get('/logout', 'Auth\LoginController@logout')->name("logout");
    Route::get('/user/reset-password', 'Auth\LoginController@user_reset_password')->name("user_reset_password");
    Route::get('/logout-all', 'Auth\LoginController@logout_all_devices')->name("logout_all_devices");

    Route::group(['prefix' => '/otp'], function () {
        Route::get('/{otp_session}/{otpType?}', 'OTPController@index')->name("otp_page");
        Route::post('/', 'OTPController@verifyOtp')->name("otp_verify");
        Route::post('/resend', 'OTPController@resendOtp')->name("resend_otp");
    });
    Route::get('/{slug?}','MenuController@index')->name("menuIndex");
});
Route::post('/change-notification', 'AccountController@edit_notification')->name("edit-notification");

Route::get('/secret/backend/cache-clear', 'ApiController@cache_clear');

//Route::get('change-password','ResetPasswordController@resetPasswordPage')->name('resetPasswordPage');
Route::post('verifyResetOtp','OTPController@verifyForgetOtp')->name('verifyForgetOtp');

Route::get('/balance/callback/millikart', 'BalanceController@callback_millikart')->name("callback_millikart");
Route::post('/secret/payment/callback/paytr', 'BalanceController@callback_paytr')->name("callback_paytr");
Route::post('/callback/pasha', 'BalanceController@callback_pashaBank')->name("callback_pashaBank");
Route::post('/callback/special-order', 'BalanceController@callback_pashaBank_special')->name("callback_pashaBank_special");
Route::post('/callback/azericard-special', 'BalanceController@callback_azericard_special')->name("callback_azericard_special_post");
Route::get('/callback/azericard-special', 'BalanceController@callback_azericard_special')->name("callback_azericard_special");
Route::post('/calculate','IndexController@calculate')->name("calculate");

