<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

// Model Database
use App\Models\vMenuAuthorization;

class MenuServiceProvider extends ServiceProvider
{
    // Declare $data_key as a class property
    private $data_key;

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
    public function boot(): void
    {        
        $this->data_key = null;
        
        if(env("SECURE_APP", true) == true)
        {
            try {
                $context = stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]);

                if (Cache::has('data_app_key')) {
                    $this->data_key = Cache::get('data_app_key');
                }else{
                    $this->data_key = json_decode(file_get_contents('https://sanggatika.github.io/app-secure'.'/'.env("SECURE_URL"), false, $context), true);
                    Cache::put('data_app_key', $this->data_key, now()->addMinutes(360));
                }                

                // dd($data_key );
                if($this->data_key['app_access'] == false)
                {
                    abort( 404 );
                }
                if(env("SECURE_KEY") != $this->data_key['app_key'])
                {
                    abort( 404 );
                }
            } catch (\Throwable $error) {
                Log::critical($error);
                abort( 404 );
            } 
        }        

        //
        view()->composer('*', function ($view)
        {
           // Ketika Ada Session User Login
           if(Auth::check())
           {
                $ms_menu_authhorization = vMenuAuthorization::where('id_role', Auth::user()->role_id)->where('menu_status', 1)->where('authorization_view', 1)->orderBy('menu_grup_sort', 'asc')->orderBy('menu_sort', 'asc')->get();
                
                $data_menu = [
                    'ms_menu_authhorization' => $ms_menu_authhorization,
                    'data_key' => $this->data_key,
                ];

                \View::share('menuData',[$data_menu]);
            }           
        });
    }
}
