<?php

namespace App\Providers;

use App\Models\Option;
use App\Models\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        try {
            DB::connection()->getPdo();

            $options = Option::all()->pluck('option_value', 'option_key')->toArray();

            $allOptions = [];
            $allOptions['options'] = $options;
            config($allOptions);

            /**
             * Set dynamic configuration for third party services
             */
            $facebookConfig = [
                'services.facebook' =>
                    [
                        'client_id' => get_option('fb_app_id'),
                        'client_secret' => get_option('fb_app_secret'),
                        'redirect' => url('login/facebook-callback'),
                    ]
            ];
            $googleConfig = [
                'services.google' =>
                    [
                        'client_id' => get_option('google_client_id'),
                        'client_secret' => get_option('google_client_secret'),
                        'redirect' => url('login/google-callback'),
                    ]
            ];
            config($facebookConfig);
            config($googleConfig);

            /**
             * Email from name
             */

            $emailConfig = [
                'mail.from' =>
                    [
                        'address' => get_option('email_address'),
                        'name' => get_option('site_name'),
                    ]
            ];
            config($emailConfig);
        }catch (\Exception $e){
            //
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}