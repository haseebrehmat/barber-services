<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {

            // Limits
            $limits = DB::table('message_limits')->first();

            $smsLimit = isset($limits) ? $limits->sms : 0;
            $whatsappLimit = isset($limits) ? $limits->whatsapp : 0;

            $view->with('smsLimit', $smsLimit);
            $view->with('whatsappLimit', $whatsappLimit);

            // Sent
            $sent = DB::table('sent_messages')->where('month', now()->month)->first();

            $smsSent = isset($sent) ? $sent->sms : 0;
            $whatsappSent = isset($sent) ? $sent->whatsapp : 0;

            $view->with('smsSent', $smsSent);
            $view->with('whatsappSent', $whatsappSent);

            // Flags
            $view->with('smsFlag' , $smsSent < $smsLimit);
            $view->with('whatsappFlag' , $whatsappSent < $whatsappLimit);

            //admin logo
            $general_settings_global = DB::table('general_settings')->where('id', 1)->first();
            $view->with('general_settings_global', $general_settings_global);

            //enabled tools
            $record = DB::table('admin_tools')->where('user_id', 0)->first();
            $enabled_tools = isset($record) ? explode(',', $record->codes) : [];
            $view->with('enabled_tools', $enabled_tools);
        });
    }
}
