<?php

namespace Insenseanalytics\NovaBarMetrics;

use Laravel\Nova\Metrics\Partition;

abstract class BarChartMetric extends Partition
{
	use HasFrequencyDistributions;

	/**
	 * The element's component.
	 *
	 * @var string
	 */
	public $component = 'bar-chart-metric';

	/**
	 * Create a new partition metric result.
	 *
	 * @param array $value
	 *
	 * @return \Insenseanalytics\NovaBarMetrics\BarChartMetricResult
	 */
	public function result(array $value)
	{
		return new BarChartMetricResult($value);
	}
}
