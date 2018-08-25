# A Laravel Nova tool for bar chart metrics and frequency distributions

This [Nova](https://nova.laravel.com) tool lets you:
- create bar charts
- create frequency distribution charts (using pie charts and/or bar charts)

## Bar Chart Metric Screenshot
<img alt="screenshot of the backup tool" src="https://insenseanalytics.github.io/public-assets/nova-bar-metrics/nova-bar-metrics-bar1.png" height="150" />

## Frequency Distribution Metric Screenshot (Bar Chart)
<img alt="screenshot of the backup tool" src="https://insenseanalytics.github.io/public-assets/nova-bar-metrics/nova-bar-metrics-freq-bar.png" height="150" />

## Frequency Distribution Metric Screenshot (Pie Chart)
<img alt="screenshot of the backup tool" src="https://insenseanalytics.github.io/public-assets/nova-bar-metrics/nova-bar-metrics-freq-pie.png" height="150" />

## Quick Introduction (Bar Chart Metrics)

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

## Quick Introduction (Frequency Distributions in Bar Chart Metrics and Partition Metrics)

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

## Contributing

Contributions are welcome and will be fully credited as long as you use PSR-4, explain the issue/feature that you want to solve/add and back your code up with tests. Happy coding!

## License

The MIT License (MIT). Please see [License File](LICENSE.txt) for more information.
