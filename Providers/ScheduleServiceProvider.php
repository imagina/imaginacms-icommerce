<?php


namespace Modules\Icommerce\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {

            $schedule = $this->app->make(Schedule::class);

            //================================= Cada minuto | Revisa las subs proximas a cobrar (Pasan a Pending Payment , Crear Orden, Ejecuta Cobro)
            $schedule->call(function () {
                \Modules\Icommerce\Jobs\CheckSubscriptions::dispatch();
            })->everyMinute();

            //================================= 1 vez al dia | 11pm
            $schedule->call(function () {
                \Modules\Icommerce\Jobs\SubscriptionsToSuspend::dispatch();
            })->dailyAt('23:00');

            //================================= 1 vez al dia | 9pm
            $schedule->call(function () {
                \Modules\Icommerce\Jobs\OrdersToPaymentRetry::dispatch();
            })->dailyAt('21:00');
            
        });

    }
}
