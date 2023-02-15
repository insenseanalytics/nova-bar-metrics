# Updated for newest Laravel Nova!

# A Laravel Nova tool for bar chart metrics and frequency distributions

[![License](https://poser.pugx.org/insenseanalytics/nova-bar-metrics/license)](https://packagist.org/packages/insenseanalytics/nova-bar-metrics)
[![Latest Stable Version](https://poser.pugx.org/insenseanalytics/nova-bar-metrics/v/stable)](https://packagist.org/packages/insenseanalytics/nova-bar-metrics)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/insenseanalytics/nova-bar-metrics/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/insenseanalytics/nova-bar-metrics/?branch=master)
[![Total Downloads](https://poser.pugx.org/insenseanalytics/nova-bar-metrics/downloads)](https://packagist.org/packages/insenseanalytics/nova-bar-metrics)
[![Monthly Downloads](https://poser.pugx.org/insenseanalytics/nova-bar-metrics/d/monthly)](https://packagist.org/packages/insenseanalytics/nova-bar-metrics)

This [Nova](https://nova.laravel.com) tool lets you:
- create bar charts
- create frequency distribution charts (using pie charts and/or bar charts)

## Bar Chart Metric Screenshot
<img alt="screenshot of the backup tool" src="https://insenseanalytics.github.io/public-assets/nova-bar-metrics/nova-bar-metrics-bar1.png" height="150" />

## Frequency Distribution Metric Screenshot (Bar Chart)
<img alt="screenshot of the backup tool" src="https://insenseanalytics.github.io/public-assets/nova-bar-metrics/nova-bar-metrics-freq-bar2.png" height="150" />

## Frequency Distribution Metric Screenshot (Pie Chart)
<img alt="screenshot of the backup tool" src="https://insenseanalytics.github.io/public-assets/nova-bar-metrics/nova-bar-metrics-freq-pie.png" height="150" />

## Bar Chart Metrics

For a bar chart metric, just create a metric class like you normally would for a `Partition` metric. All the available methods in a `Partition` metric are also available for `BarChartMetric`! Instead of extending `Partition` you would just need to extend `BarChartMetric` like so:
```php
use Insenseanalytics\NovaBarMetrics\BarChartMetric;

class BrandsPerCategory extends BarChartMetric
{
  public function calculate(Request $request)
  {
    return $this->count($request, BrandCategory::class, 'category_name');
  }
}
```
You can also use the `suffix`, `prefix`, `dollars` and `euros` methods like in a `TrendMetric` in Laravel Nova. Besides this, we also have a `precision` method to set the precision of the `avg` metric shown in the top right corner of the bar chart.

## Frequency Distributions for Bar Chart Metrics and Partition Metrics

To create a frequency distributions chart, either extend the `BarChartMetric` class or extend the `Partition` class and use the trait `HasFrequencyDistributions`. You can use the `distributions` helper method to create the frequency distribution chart like so:

***Example for BarChartMetric***
```php
use Insenseanalytics\NovaBarMetrics\BarChartMetric;

class BrandFacebookFollowers extends BarChartMetric
{
  public function calculate(Request $request)
  {
    return $this->distributions($request, Brand::class, 'facebook_followers', 100000);
  }
}
``` 
In the example above, 100000 is the `step size` to use for the ranges in the frequency distribution and facebook_followers is the `column to distribute` by ranges.

Instead of providing the `step size`, you may provide the max number of steps instead using the `distributionsWithSteps` method and the package would automatically calculate the step size like so:

```php
use Insenseanalytics\NovaBarMetrics\BarChartMetric;

class BrandFacebookFollowers extends BarChartMetric
{
  public function calculate(Request $request)
  {
    return $this->distributionsWithSteps($request, Brand::class, 'facebook_followers', 15);
  }
}
``` 

For friendly formatted ranges (K for thousands, M for millions, B for billions), you can use the `withFormattedRangeLabels` method like so:

```php
public function calculate(Request $request)
{
  return $this->distributions($request, Brand::class, 'facebook_followers', 100000)
              ->withFormattedRangeLabels();
}
```

***Example for Partition Metric***
```php
use Laravel\Nova\Metrics\Partition;
use Insenseanalytics\NovaBarMetrics\HasFrequencyDistributions;

class BrandFacebookFollowers extends Partition
{
  use HasFrequencyDistributions;
  
  public function calculate(Request $request)
  {
    return $this->distributions($request, Brand::class, 'facebook_followers', 100000);
  }
}
``` 

## Requirements & Dependencies
There are no PHP dependencies except the Laravel Nova package. On the frontend JS, this package uses `vue`, `chartist`, `chartist-plugin-tooltips` and `laravel-nova`, all of which are also used by Nova itself.

## Installation

You can install this tool into a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require insenseanalytics/nova-bar-metrics
```

Next, if you do not have package discovery enabled, you need to register the provider in the `config/app.php` file.
```php
'providers' => [
    ...,
    Insenseanalytics\NovaBarMetrics\NovaBarMetricsServiceProvider::class,
]
```
## Usage

You can use the console command `php artisan nova:barmetric <classname>` to create new BarMetric classes

## Contributing

Contributions are welcome and will be fully credited as long as you use PSR-2, explain the issue/feature that you want to solve/add and back your code up with tests. Happy coding!

## License

The MIT License (MIT). Please see [License File](LICENSE.txt) for more information.
