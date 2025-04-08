<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/login-client-account/{token}', 'Api\LoginClientController@login');

use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;
Route::get('/get-api-token', [\App\Http\Controllers\Api\OtherApiController::class, 'getFcmToken']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/forgot-password', [\App\Http\Controllers\Api\AuthController::class, 'sendResetLinkEmail']);
//Route::post('/reset-password', [\App\Http\Controllers\Api\AuthController::class, 'reset_password']);
//Route::get('/get', [\App\Http\Controllers\Api\AuthController::class, 'test'])->middleware('myApi');
Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('myApi');
Route::get('/country/{country_id}', [\App\Http\Controllers\AccountController::class, 'get_country_details'])->middleware('myApi')->name('api_country_details');
Route::get('/packages_price_for_last_month', [\App\Http\Controllers\AccountController::class, 'packages_price_for_last_month'])->middleware('myApi')->name('api_packages_price_for_last_month');
Route::get('/get_user_data', [\App\Http\Controllers\AccountController::class, 'get_user_data'])->middleware('myApi')->name('api_get_user_data');
Route::post('/user/update', [\App\Http\Controllers\AccountController::class, 'post_update_user_account'])->middleware('myApi')->name('api_update_user_data');
Route::get('/packages', [\App\Http\Controllers\AccountController::class, 'get_packages'])->middleware('myApi')->name('api_get_packages');
Route::get('/statuses', [\App\Http\Controllers\AccountController::class, 'get_statuses'])->middleware('myApi')->name('api_get_statuses');Route::get('/branches', [\App\Http\Controllers\AccountController::class, 'get_branches'])->name('get_branches');
Route::post('/add_preliminary_declaration', [\App\Http\Controllers\AccountController::class, 'post_preliminary_declaration'])->middleware('myApi')->name('api_add_preliminary_declaration');
Route::get('/package/update/{locale}/{package_id}', [\App\Http\Controllers\AccountController::class, 'get_package_update'])->middleware('myApi')->name('api_get_package_update');
Route::post('/package/update/{locale}/{package_id}', [\App\Http\Controllers\AccountController::class, 'post_package_update'])->middleware('myApi')->name('api_post_package_update');
Route::delete('/package/delete/{package_id}', [\App\Http\Controllers\AccountController::class, 'delete_package'])->middleware('myApi')->name('api_delete_package');
Route::get('/currencies', [\App\Http\Controllers\AccountController::class, 'get_currencies'])->middleware('myApi')->name('api_get_currency');
Route::get('/categories', [\App\Http\Controllers\AccountController::class, 'get_categories'])->middleware('myApi')->name('api_get_categories');
//Route::get('/sellers', [\App\Http\Controllers\AccountController::class, 'get_sellers'])->middleware('myApi')->name('api_get_sellers');
Route::get('/special_order/update/{country_id}/{order_id}', [\App\Http\Controllers\AccountController::class, 'get_special_order_update'])->middleware('myApi')->name('api_get_special_order_update');
Route::get('/pay_special_order/{country_id}/pay{order_id}', [\App\Http\Controllers\AccountController::class, 'pay_to_special_order'])->middleware('myApi')->name('api_pay_to_special_order');
Route::get('/sellers', [\App\Http\Controllers\Api\LayoutController::class, 'get_seller'])->name("sellers_page");
Route::get('/faq', [\App\Http\Controllers\Api\LayoutController::class, 'faq'])->name("faq");
Route::get('/dangerous-goods', [\App\Http\Controllers\Api\LayoutController::class, 'dangerousGoods']);
Route::get('/calculate-index', [\App\Http\Controllers\Api\CalculateController::class, 'index']);
Route::post('/calculate-amount', [\App\Http\Controllers\Api\CalculateController::class, 'calculate_amount'])->name("calculate_amount");
Route::get('/seller-categories', [\App\Http\Controllers\Api\OtherApiController::class, 'sellerCategories']);

Route::get('/news', [\App\Http\Controllers\Api\OtherApiController::class, 'news'])->name('api_news');
Route::get('/news/{slug}', [\App\Http\Controllers\Api\OtherApiController::class, 'newsSlug']);


Route::group(['prefix' => '/', 'middleware' => 'myApi'], function () {
    Route::get('/country-details/{country_id}', [\App\Http\Controllers\Api\CountryDetailsController::class, 'get_country_details'])->name('api_country_details');
    Route::get('/users', [\App\Http\Controllers\Api\UserDetailsController::class, 'user_details'])->name('user_details');
    Route::post('/user/update', [\App\Http\Controllers\AccountController::class, 'post_update_user_account'])->name('api_update_user_data');
    Route::post('/profile-image', [\App\Http\Controllers\AccountController::class, 'update_user_profile_image'])->name('api_update_user_profile_image');
    Route::get('trendyol-otp',[OTPController::class,'getTrendyolOTP']);
    Route::get('amazon-otp',[OTPController::class,'getAmazonOTP']);


    //special order api
    Route::group(['prefix' => '/special-order/{locale}/{country_id}'], function () {
        Route::get('/get/orders', [\App\Http\Controllers\AccountController::class, 'get_special_orders'])->name('api_get_add_special_order');
        Route::post('/add', [\App\Http\Controllers\AccountController::class, 'add_special_order'])->name('api_add_special_order');
        Route::post('/pay/{order_id}', [\App\Http\Controllers\AccountController::class, 'pay_to_special_order'])->name("api_pay_to_special_order");
        Route::get('/get/update/{order_id}', [\App\Http\Controllers\AccountController::class, 'get_special_order_update'])->name("get_special_order_update");
        Route::post('/update/{order_id}', [\App\Http\Controllers\Api\SpecialOrderSettingsController::class, 'update_special_order'])->name('api_update_add_special_order');
        Route::delete('/delete/{order_id}', [\App\Http\Controllers\AccountController::class, 'delete_special_order'])->name('api_delete_add_special_order');
        Route::get('/show-orders', [\App\Http\Controllers\AccountController::class, 'api_show_orders_for_group_special_orders'])->name("api_show_orders_for_group_special_orders");
        Route::get('/settings', [\App\Http\Controllers\Api\SpecialOrderSettingsController::class, 'get_settings']);

        Route::get('/special-orders/{order_id}', 'AccountController@get_special_orders_mobil');

    });

    // add balance and payment
    Route::get('/balance/operations', 'AccountController@get_balance_logs')->name("get_balance_logs");
    Route::get('/balance', [\App\Http\Controllers\Api\BalanceController::class, 'get_balance']);
    Route::post('/balance/replenish', [\App\Http\Controllers\AccountController::class, 'amount_send_to_millikart'])->name('api_replenish_balance');
    Route::get('payment/operations', 'AccountController@get_payment_logs')->name("get_payment_logs");
    Route::post('/payment/replenish', [\App\Http\Controllers\AccountController::class, 'payment_send_to_millikart'])->name('api_replenish_payment');

    Route::get('/check-callback', [\App\Http\Controllers\Api\BalanceController::class, 'get_check_callback']);

    //package
    Route::group(['prefix' => '/orders'], function () {
        Route::get('/packages', 'AccountController@get_packages')->name("get_orders");
        Route::get('/sent', [\App\Http\Controllers\Api\PackageController::class, 'get_sent'])->name('api_get_sent');
        Route::get('/warehouse', [\App\Http\Controllers\Api\PackageController::class, 'is_warehouse'])->name('api_is_warehouse');
        Route::get('/baku', [\App\Http\Controllers\Api\PackageController::class, 'in_baku'])->name('api_in_baku');
        Route::get('/delivered', [\App\Http\Controllers\Api\PackageController::class, 'delivered'])->name('api_delivered');
        Route::post('/pay/{package_id}', 'AccountController@pay_package')->name("pay_order");
        Route::get('/items', 'AccountController@get_package_items')->name("get_package_items");
        Route::get('/update/{package_id}', 'AccountController@get_package_update')->name("get_package_update");
        Route::post('/update/{package_id}', 'AccountController@post_package_update')->name("post_package_update");

        Route::get('/packages/{package_id}', [\App\Http\Controllers\Api\PackageController::class, 'package_mobile']);

        Route::post('/send-legality', 'AccountController@send_legality')->name("send_legality");


        Route::get('/category', [\App\Http\Controllers\Api\CategoryController::class, 'get_categories']);
        Route::get('/seller', [\App\Http\Controllers\Api\SellerController::class, 'get_sellers']);
        Route::get('/currency', [\App\Http\Controllers\Api\CurrencyController::class, 'get_currencies']);

        Route::post('/bulk-pay', [\App\Http\Controllers\Api\PackageController::class, 'bulk_pay']);
    });


    Route::group(['prefix' => '/seller-otp'], function () {
        Route::get('/', [\App\Http\Controllers\SellerOtpController::class , 'index']);
        Route::post('/store', [\App\Http\Controllers\SellerOtpController::class, 'store'])->middleware('myApi');

    });

    Route::group(['prefix' => '/courier'], function () {
        Route::get('/settings', [\App\Http\Controllers\Api\CourierController::class, 'courier_settings'])->name("courier_settings");
        Route::get('/area', [\App\Http\Controllers\Api\CourierController::class, 'courier_area'])->name("courier_area");
        Route::get('/metro', [\App\Http\Controllers\Api\CourierController::class, 'metro_station'])->name("metro_station");
        Route::get('/packages', [\App\Http\Controllers\Api\CourierController::class, 'courier_package'])->name("courier_package");
        Route::get('/referal-packages', [\App\Http\Controllers\Api\CourierController::class, 'show_packages_referrals']);

        Route::get('/courier-payment-types', 'AccountController@courier_get_courier_payment_types')->name("courier_get_courier_payment_types");
        Route::get('/delivery-payment-types', 'AccountController@courier_get_delivery_payment_types')->name("courier_get_delivery_payment_types");

        // orders
        Route::get('/orders', [\App\Http\Controllers\Api\CourierController::class, 'orders'])->name("orders");
        Route::get('/show-packages', 'AccountController@courier_show_packages')->name("courier_show_packages");
        Route::post('/create-order', 'AccountController@courier_create_order')->name("courier_create_order");

        Route::delete('/delete', 'AccountController@delete_courier_order')->name("delete_courier_order");
        Route::post('/update', 'AccountController@courier_update_packages')->name("courier_update_packages");
        Route::get('/getData','AccountController@getData')->name('getdata');
        Route::get('/orders/{order_id}', [\App\Http\Controllers\Api\CourierController::class, 'get_courier_orders_mobil']);

        //regions
        Route::get('/region', [\App\Http\Controllers\Api\CourierController::class, 'regions'])->name("regions");
        Route::post('/create-order-region', 'AccountController@courier_create_order_region')->name("courier_create_order_region");
        Route::get('/get-courier-payment-types-regions', 'AccountController@courier_get_region_payment_tariff')->name("courier_get_region_payment_tariff");
        Route::get('/get-postindex', [\App\Http\Controllers\Api\CourierController::class, 'azerpostIndexByRegion']);
    });

    Route::post('/save-token', 'NotificationController@saveToken')->name('saveToken');

    Route::group(['prefix' => '/sub-accounts'], function () {
        Route::get('/', [\App\Http\Controllers\Api\ReferalController::class, 'get_sub_accounts']);

        Route::group(['prefix' => '/orders'], function () {
            Route::get('/sent', [\App\Http\Controllers\Api\ReferalController::class, 'get_sent_referal']);
            Route::get('/warehouse', [\App\Http\Controllers\Api\ReferalController::class, 'is_warehouse_referal']);
            Route::get('/in-baku', [\App\Http\Controllers\Api\ReferalController::class, 'in_baku_referal']);
            Route::get('/delivered', [\App\Http\Controllers\Api\ReferalController::class, 'delivered_referal']);
            Route::post('/update/{package_id}', [\App\Http\Controllers\Api\ReferalController::class, 'post_package_update_by_sub_accounts']);
        });
    });

    Route::prefix('/notifications')->group(function (){
        Route::get('/',[\App\Http\Controllers\Api\NotificationController::class,'index']);
        Route::post('/read',[\App\Http\Controllers\Api\NotificationController::class,'readnotification']);
        Route::post('/delete',[\App\Http\Controllers\Api\NotificationController::class,'deletenotification']);
        Route::get('/readall', [\App\Http\Controllers\Api\NotificationController::class,'readallnotifications']);
        Route::get('/deleteall', [\App\Http\Controllers\Api\NotificationController::class,'deleteallnotification']);
        
    });

    Route::post('/send-token', [\App\Http\Controllers\Api\NotificationController::class, 'CreatOrUpdateUserDevice']);
    Route::get('/get-notifications', [\App\Http\Controllers\Api\NotificationController::class, 'GetNotifications']);
    Route::get('/read-single-notification/{client}/{notification}', [\App\Http\Controllers\Api\NotificationController::class, 'ReadSingleNotification']);
    Route::post('/read-all', [\App\Http\Controllers\Api\NotificationController::class, 'ReadAllNotification']);
    Route::get('/search-tracking', [\App\Http\Controllers\Api\PackageController::class, 'SearchTracking']);
    Route::get('/special-orders/countries', [\App\Http\Controllers\AccountController::class,'special_orders_country']);
    Route::get('/trendyol-onay-kodu', [\App\Http\Controllers\SellerOtpController::class,'getTrendyolOtp']);
    Route::post('/change-password',[\App\Http\Controllers\Api\UserDetailsController::class,'change_password'])->name('change_password');
    Route::group(['prefix' => '/azerpost'], function () {
        Route::get('/orders', [\App\Http\Controllers\Api\CourierController::class,'get_azerpost_courier_page']);
    });
});


Route::post('/check-forgot-password-otp', [\App\Http\Controllers\Api\AuthController::class, 'checkOTP']);
Route::post('resend-otp', [\App\Http\Controllers\Auth\RegisterController::class,'resendOTP']);
Route::post('check-otp', [\App\Http\Controllers\Auth\RegisterController::class,'checkOTP']);
Route::post('/new-password',[\App\Http\Controllers\Api\AuthController::class,'new_password']);


Route::get('/prohibited-items', [\App\Http\Controllers\Api\OtherApiController::class, 'prohibitedItems'])->name("prohibitedItems");

Route::get('/cities', [\App\Http\Controllers\Api\CityController::class, 'get_cities'])->name('api_get_cities');
Route::get('/countries', [\App\Http\Controllers\Api\CountryController::class, 'get_countries'])->name('api_get_countries');
Route::get('/seller', [\App\Http\Controllers\SellerController::class, 'show_sellers'])->name('api_seller');
Route::get('/categories', [\App\Http\Controllers\Api\OtherApiController::class, 'categories'])->name('api_categories');
Route::get('/currency', [\App\Http\Controllers\Api\OtherApiController::class, 'currency'])->name('api_currency');
Route::get('/tariffs', [\App\Http\Controllers\Api\TariffController::class, 'tariffs'])->name("tariffs");
Route::post('/check-order', [\App\Http\Controllers\Api\OtherApiController::class, 'local_tracking_search']);
Route::post('/send-otp', [\App\Http\Controllers\Api\OtherApiController::class, 'send_incoming_otp']);

Route::group(['prefix' => 'external', 'middleware' => ['thirdPlatform', 'throttle:600,1']], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('order', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'store_v1']);
        Route::get('order/{hash}', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'index_v1']);
        Route::delete('order/{hash}', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'destroy']);
    });

    Route::group(['prefix' => 'v2'], function () {
        Route::post('order', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'store']);
        Route::get('order/{hash}', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'index']);
        Route::delete('order/{hash}', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'destroy']);

        Route::get('categories', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'partner_categories']);

        Route::get('flights', [\App\Http\Controllers\Api\ThirdPlatform\PartnerFlightController::class, 'get_flight']);
        Route::post('create-flights', [\App\Http\Controllers\Api\ThirdPlatform\PartnerFlightController::class, 'create_flight']);
        Route::post('flights', [\App\Http\Controllers\Api\ThirdPlatform\PartnerFlightController::class, 'close_flight']);


        Route::get('containers/{flight_id}', [\App\Http\Controllers\Api\ThirdPlatform\PartnerContainerController::class, 'get_container']);
        Route::post('create-containers', [\App\Http\Controllers\Api\ThirdPlatform\PartnerContainerController::class, 'create_container']);

        Route::post('package-to-container', [\App\Http\Controllers\Api\ThirdPlatform\PackageCollectController::class, 'add_partner_collector']);

        Route::get('locations', [\App\Http\Controllers\Api\ThirdPlatform\LocationController::class, 'get_locations']);

        Route::get('create-waybill/{hash}', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'createPDF']);

        Route::get('generate-waybill/{hash}', [\App\Http\Controllers\Api\ThirdPlatform\OrderController::class, 'waybillGenerate']);

        Route::post('package-status', [\App\Http\Controllers\Api\ThirdPlatform\PackageStatusController::class, 'check_package_status']);
        Route::get('approve', [\App\Http\Controllers\Api\ThirdPlatform\PackageStatusController::class, 'approve_partner']);
        Route::get('status/{internal_id}', [\App\Http\Controllers\Api\ThirdPlatform\PackageStatusController::class, 'package_all_status']);


        Route::post('package-update', [\App\Http\Controllers\Api\ThirdPlatform\OrderUpdateController::class, 'order_update']);
    });
});


