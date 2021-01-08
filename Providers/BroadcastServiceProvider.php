<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Broadcast::routes();
    
    /*
     * Authenticate the user's personal channel...
     */
    require base_path('Modules/Icommerce/Http/frontendChannels.php');
  }
}
