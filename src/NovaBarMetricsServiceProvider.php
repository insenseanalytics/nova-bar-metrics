<?php

namespace Insenseanalytics\NovaBarMetrics;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;
use Insenseanalytics\NovaBarMetrics\Console\BarMetricCommand;

class NovaBarMetricsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 */
	public function boot()
	{
		Nova::serving(function (ServingNova $event) {
			Nova::script('nova-bar-metrics', __DIR__ . '/../dist/js/nova-bar-metrics.js');
			// Nova::style('nova-bar-metrics', __DIR__ . '/../dist/css/nova-bar-metrics.css');
		});

    $this->bootCommands();
	}

	/**
	 * Register any application services.
	 */
	public function register()
	{
	}

  /**
   * Boot the custom commands
   *
   * @return void
   */
  private function bootCommands()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        BarMetricCommand::class,
      ]);
    }
  }
}
