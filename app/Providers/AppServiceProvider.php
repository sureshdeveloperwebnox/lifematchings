<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
      Paginator::useBootstrap();
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
      if (!isset($_SERVER['SERVER_NAME'])) {
          $_SERVER['SERVER_NAME'] = 'localhost';
      }
      if (!isset($_SERVER['HTTP_HOST'])) {
          $_SERVER['HTTP_HOST'] = 'localhost';
      }
  }
}
