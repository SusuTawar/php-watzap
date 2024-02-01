<?php

namespace PhpWatzap;

use Illuminate\Support\ServiceProvider;

class WatzapServiceProvider extends ServiceProvider
{
  /**
   * Publishes configuration file.
   *
   * @return  void
   */
  public function boot()
  {
    $this->publishes([
      __DIR__ . '/config/watzap.php' => config_path('watzap.php'),
    ], ['watzap', 'watzap:config']);
    if ($this->app->runningInConsole()) {
      $this->commands([
        \PhpWatzap\Commands\WatzapKeys::class,
      ]);
    }
  }
  /**
   * Make config publishment optional by merging the config from the package.
   *
   * @return  void
   */
  public function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/config/watzap.php',
      'watzap'
    );
    $this->app->bind('watzap', function () {
      return new WatZap(config('watzap.api-key'), config('watzap.base-url'), true);
    });
  }
}
