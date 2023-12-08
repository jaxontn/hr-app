<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProviderNew extends ServiceProvider
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
  public function boot(): void
  {
    $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuNew.json'));
    $verticalMenuData = json_decode($verticalMenuJson);

    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData]);
  }
}
