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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', 'Public\HomeController@index')->name('home');
Route::get('clear', 'Public\HomeController@clearCache')->name('clear_cache');//check it
Route::post('cookie-accept', ['as' => 'cookie_accept','uses' => 'Public\HomeController@acceptCookie']);
Route::get('p/{slug}', ['as' => 'single_page', 'uses' => 'Public\HomeController@showPage']);

// Campaigns
Route::get('campaign/{id}/{slug?}', ['as' => 'campaign_single', 'uses' => 'Public\CampaignsController@show']);
Route::get('campaign-backers/{id}/{slug?}', ['as' => 'campaign_backers', 'uses' => 'Public\CampaignsController@showBackers']);
Route::get('campaign-updates/{id}/{slug?}', ['as' => 'campaign_updates', 'uses' => 'Public\CampaignsController@showUpdates']);
Route::get('campaign-faqs/{id}/{slug?}', ['as' => 'campaign_faqs', 'uses' => 'Public\CampaignsController@showFaqs']);
Route::group(['prefix'=>'ajax'], function() {
    Route::get('new-campaigns', ['as'=>'new_campaigns_ajax', 'uses' => 'Public\CampaignsController@newCampaignsAjax']);
});

// Contact Us
Route::get('contact-us', ['as' => 'contact_us', 'uses' => 'Public\HomeController@contactUs']);
Route::post('contact-us', ['as' => 'contact_us', 'uses' => 'Public\HomeController@contactUsPost']);

// categories
Route::get('search', ['as' => 'search', 'uses' => 'Public\CategoriesController@search']);
Route::get('categories', ['as' => 'browse_categories', 'uses' => 'Public\CategoriesController@index']);
Route::get('categories/{id}/{slug?}', ['as' => 'single_category', 'uses' => 'Public\CategoriesController@show']);

//checkout
Route::any('add-to-cart/{reward_id?}', ['as' => 'add_to_cart', 'uses' => 'Public\CheckoutController@addToCart']);
Route::get('checkout', ['as' => 'checkout', 'uses' => 'Public\CheckoutController@checkout']);
Route::post('checkout', ['uses' => 'Public\CheckoutController@checkoutPost']);
Route::post('checkout/paypal', ['as' => 'payment_paypal_receive','uses' => 'Public\CheckoutController@paypalRedirect']);
Route::any('checkout/payment-success/{transaction_id?}', ['as' => 'payment_success','uses' => 'Public\CheckoutController@paymentSuccess']);
Route::any('checkout/paypal-notify/{transaction_id?}', ['as' => 'paypal_notify', 'uses' => 'Public\CheckoutController@paypalNotify']);
Route::post('checkout/stripe', ['as' => 'payment_stripe_receive', 'uses' => 'Public\CheckoutController@paymentStripeReceive']);
Route::post('checkout/bank-transfer', ['as' => 'bank_transfer_submit', 'uses' => 'Public\CheckoutController@paymentBankTransferReceive']);

Route::get('checkout/payment/callback', 'PaymentController@handleGatewayCallback')->name('payment.callback');
Route::post('checkout/paystack-payment', ['as' => 'paystack.payment', 'uses' => 'Public\CheckoutController@payWithPaystack']);

Route::post('checkout/chimoney-payment', ['as' => 'chimoney.payment', 'uses' => 'Public\CheckoutController@payWithChimoney']);

//Route::post('checkout/paystack-payment', 'Public\CheckoutController@payWithPaystack')->name('paystack.payment');


// Social Logins
Route::group(['prefix'=>'login'], function(){
    Route::get('facebook', ['as' => 'facebook_redirect', 'uses'=>'Auth\SocialLoginController@redirectFacebook']);
    Route::get('facebook-callback', ['as' => 'facebook_callback', 'uses'=>'Auth\SocialLoginController@callbackFacebook']);

    Route::get('google', ['as' => 'google_redirect', 'uses'=>'Auth\SocialLoginController@redirectGoogle']);
    Route::get('google-callback', ['as' => 'google_callback', 'uses'=>'Auth\SocialLoginController@callbackGoogle']);

});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix'=>'dashboard', 'middleware' => 'auth'], function() {
    Route::get('/', ['as' => 'dashboard', 'uses' => 'Dashboard\DashboardController@dashboard']);

    // My Campaigns
    Route::group(['prefix'=>'my_campaigns'], function(){
        Route::get('/', ['as'=>'my_campaigns', 'uses' => 'Dashboard\CampaignsController@myCampaigns']);
        Route::get('my_pending_campaigns', ['as'=>'my_pending_campaigns', 'uses' => 'Dashboard\CampaignsController@myPendingCampaigns']);

        Route::get('start_campaign', ['as'=>'start_campaign', 'uses' => 'Dashboard\CampaignsController@create']);
        Route::post('start_campaign', ['uses' => 'Dashboard\CampaignsController@store']);

        Route::get('edit_campaign/{id}', ['as'=>'edit_campaign', 'uses' => 'Dashboard\CampaignsController@edit']);
        Route::post('edit_campaign/{id}', [ 'uses' => 'Dashboard\CampaignsController@update']);

        //Reward
        Route::get('edit_campaign/{id}/rewards', ['as'=>'edit_campaign_rewards', 'uses' => 'Dashboard\RewardController@index']);
        Route::post('edit_campaign/{id}/rewards', [ 'uses' => 'Dashboard\RewardController@store']);

        Route::get('edit_campaign/{id}/rewards/update/{reward_id}', ['as'=>'reward_edit', 'uses' => 'Dashboard\RewardController@edit']);
        Route::post('edit_campaign/{id}/rewards/update/{reward_id}', [ 'uses' => 'Dashboard\RewardController@update']);
        Route::post('delete_reward', ['as' => 'delete_reward', 'uses' => 'Dashboard\RewardController@destroy']);

        //Updates
        Route::get('edit_campaign/{id}/updates', ['as'=>'edit_campaign_updates', 'uses' => 'Dashboard\UpdateController@index']);
        Route::post('edit_campaign/{id}/updates', [ 'uses' => 'Dashboard\UpdateController@store']);

        Route::get('edit_campaign/{id}/updates/update/{update_id}', ['as'=>'update_update', 'uses' => 'Dashboard\UpdateController@edit']);
        Route::post('edit_campaign/{id}/updates/update/{update_id}', [ 'uses' => 'Dashboard\UpdateController@update']);
        Route::post('delete_update', ['as' => 'delete_update', 'uses' => 'Dashboard\UpdateController@destroy']);
        
        //Faq
        Route::get('edit_campaign/{id}/faqs', ['as'=>'edit_campaign_faqs', 'uses' => 'Dashboard\FaqController@index']);
        Route::post('edit_campaign/{id}/faqs', [ 'uses' => 'Dashboard\FaqController@store']);
        Route::get('edit_campaign/{id}/faqs/update/{faq_id}', ['as'=>'faq_update', 'uses' => 'Dashboard\FaqController@edit']);
        Route::post('edit_campaign/{id}/faqs/update/{faq_id}', [ 'uses' => 'Dashboard\FaqController@update']);
        Route::post('delete_faq', ['as' => 'delete_faq', 'uses' => 'Dashboard\FaqController@destroy']);
    });

    // Payments
    Route::group(['prefix'=>'payments'], function() {
        Route::get('/', ['as'=>'payments', 'uses' => 'Dashboard\PaymentController@index']);
        Route::get('pending', ['as'=>'payments_pending', 'uses' => 'Dashboard\PaymentController@paymentsPending']);
        Route::get('view/{id}', ['as'=>'payment_view', 'uses' => 'Dashboard\PaymentController@view']);
        Route::get('status-change/{id}/{status}', ['as'=>'status_change', 'uses' => 'Dashboard\PaymentController@markSuccess']);
        Route::get('delete/{id}', ['as'=>'payment_delete', 'uses' => 'Dashboard\PaymentController@delete']);
    });

    // Withdraw
    Route::group(['prefix'=>'withdraw'], function() {
        Route::get('/', ['as'=>'withdraw', 'uses' => 'Dashboard\PaymentController@withdraw']);
        Route::post('/', ['uses' => 'Dashboard\PaymentController@withdrawRequest']);

        Route::get('view/{id}', ['as'=> 'withdraw_request_view', 'uses' => 'Dashboard\PaymentController@withdrawRequestView']);
        Route::post('view/{id}', ['uses' => 'Dashboard\PaymentController@withdrawalRequestsStatusSwitch']);
    });

    // Profile
    Route::group(['prefix'=>'u'], function(){
        
        Route::get('profile', ['as'=>'profile', 'uses' => 'Dashboard\ProfileController@index']);
        Route::get('profile/edit', ['as'=>'profile_edit', 'uses' => 'Dashboard\ProfileController@edit']);
        Route::post('profile/edit', ['uses' => 'Dashboard\ProfileController@update']);

        // Change Avatar - not yet
        //Route::get('profile/change-avatar', ['as'=>'change_avatar', 'uses' => 'Dashboard\ProfileController@changeAvatar']);
        //Route::post('upload-avatar', ['as'=>'upload_avatar',  'uses' => 'Dashboard\ProfileController@uploadAvatar']);

        // Withdrawals
        Route::get('withdrawal-preference', ['as'=>'withdrawal_preference',  'uses' => 'Dashboard\ProfileController@withdrawalPreference']);
        Route::post('withdrawal-preference', ['uses' => 'Dashboard\ProfileController@withdrawalPreferenceUpdate']);

        // Change Password route
        Route::group(['prefix' => 'account'], function() {
            Route::get('change-password', ['as' => 'change_password', 'uses' => 'Auth\ChangePasswordController@index']);
            Route::post('change-password', 'Auth\ChangePasswordController@update');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix'=>'dashboard', 'middleware' => ['admin','auth']], function() {

    // Categories
    Route::group(['prefix'=>'categories'], function(){
        Route::get('/', ['as'=>'categories', 'uses' => 'Admin\CategoriesController@index']);
        Route::post('/', ['uses' => 'Admin\CategoriesController@store']);
        Route::get('edit/{id}', ['as'=>'edit_categories', 'uses' => 'Admin\CategoriesController@edit']);
        Route::post('edit/{id}', ['uses' => 'Admin\CategoriesController@update']);
        Route::post('delete-categories', ['as'=>'delete_categories', 'uses' => 'Admin\CategoriesController@destroy']);
    });

    // Campaigns
    Route::group(['prefix'=>'campaigns'], function() {
        Route::get('all_campaigns', ['as'=>'all_campaigns', 'uses' => 'Admin\CampaignsController@allCampaigns']);
        Route::get('funded', ['as'=>'funded', 'uses' => 'Admin\CampaignsController@fundedCampaigns']);
        Route::get('blocked_campaigns', ['as'=>'blocked_campaigns', 'uses' => 'Admin\CampaignsController@blockedCampaigns']);
        Route::get('pending_campaigns', ['as'=>'pending_campaigns', 'uses' => 'Admin\CampaignsController@pendingCampaigns']);

        Route::get('expired_campaigns', ['as'=>'expired_campaigns', 'uses' => 'Admin\CampaignsController@expiredCampaigns']);
        Route::get('campaign-search', ['as'=>'campaign_admin_search', 'uses' => 'Admin\CampaignsController@searchAdminCampaigns']);

        Route::get('campaign_status/{id}/{status}', ['as'=>'campaign_status', 'uses' => 'Admin\CampaignsController@statusChange']);

        Route::get('campaign_delete/{id}', ['as'=>'campaign_delete', 'uses' => 'Admin\CampaignsController@deleteCampaigns']);

    });

    // Settings
    Route::group(['prefix'=>'settings'], function(){
        Route::get('theme-settings', ['as'=>'theme_settings', 'uses' => 'Admin\SettingsController@ThemeSettings']);
        Route::get('general', ['as'=>'general_settings', 'uses' => 'Admin\SettingsController@GeneralSettings']);
        Route::get('payments', ['as'=>'payment_settings', 'uses' => 'Admin\SettingsController@PaymentSettings']);

        Route::get('social', ['as'=>'social_settings', 'uses' => 'Admin\SettingsController@SocialSettings']);
        Route::get('recaptcha', ['as'=>'re_captcha_settings', 'uses' => 'Admin\SettingsController@reCaptchaSettings']);

        //Save settings / options
        Route::post('save-settings', ['as'=>'save_settings', 'uses' => 'Admin\SettingsController@update']);

        Route::get('other', ['as'=>'other_settings', 'uses' => 'Admin\SettingsController@OtherSettings']);
        Route::post('other', ['as'=>'other_settings', 'uses' => 'Admin\SettingsController@OtherSettingsPost']);
    });

    // Pages
    Route::group(['prefix'=>'pages'], function(){
        Route::get('/', ['as'=>'pages', 'uses' => 'Admin\PostController@index']);

        Route::get('create', ['as'=>'create_new_page', 'uses' => 'Admin\PostController@create']);
        Route::post('create', ['uses' => 'Admin\PostController@store']);
        Route::post('delete', ['as'=>'delete_page','uses' => 'Admin\PostController@destroy']);

        Route::get('edit/{slug}', ['as'=>'edit_page', 'uses' => 'Admin\PostController@edit']);
        Route::post('edit/{slug}', ['uses' => 'Admin\PostController@update']);
    });

    // Users
    Route::group(['prefix'=>'users'], function(){
        Route::get('/', ['as'=>'users', 'uses' => 'Admin\UserController@index']);
        Route::get('view/{slug}', ['as'=>'users_view', 'uses' => 'Admin\UserController@show']);
        Route::get('user_status/{id}/{status}', ['as'=>'user_status', 'uses' => 'Admin\UserController@statusChange']);
        Route::get('edit/{id}', ['as'=>'users_edit', 'uses' => 'Admin\UserController@edit']);
        Route::post('edit/{id}', ['uses' => 'Admin\UserController@update']);

        // not yet
        //Route::get('profile/change-avatar/{id}', ['as'=>'change_avatar', 'uses' => 'UserController@changeAvatar']);
        //Route::post('upload-avatar/{id}', ['as'=>'upload_avatar',  'uses' => 'UserController@uploadAvatar']);
    });

    // Payments
    Route::group(['prefix'=>'withdrawal-requests'], function(){
        Route::get('/', ['as'=>'withdrawal_requests', 'uses' => 'Admin\PaymentController@withdrawalRequests']);
    });

});
