<?php

namespace App\Providers;

use App\Models\Setting;

use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    // public function boot(): void
    // {
    //    Setting::firstOr(function ( ) {
    //         return Setting::create([
    //             'site_name'=> 'News App',
    //             'favicon'=> 'default',
    //             'logo' =>'default',
    //             'facebook' =>'default',
    //             'youtube'  =>'default',
    //             'x'=>'default',
    //             'instegram'=>'default',
    //             'street'   =>'default',
    //             'city' =>'default',
    //             'country'  =>'default',
    //             'email' => 'abood@abood',
    //             'phone' => '0963997742378'
    //         ]);
    //    });
    // }

    public function boot(): void
{
    $getSetting = Setting::firstOrCreate(

        [
            'site_name' => 'News App',
            'favicon' => 'default',
            'logo' => '/img/logo.png',
            'facebook' => 'https://facebook.com',
            'youtube' => 'https://youtube.com',
            'x' => 'https://x.com/',
            'instegram' => 'https://instagram.com',
            'street' => 'Al-Naaman',
            'city' => 'Homs',
            'country' => 'Syria',
            'email' => 'abood@abood',
            'phone' => '0963997742378'
        ]
    );

    view()->share([
        'getSetting'=> $getSetting,
    ]);
}

}
