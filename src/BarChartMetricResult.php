<?php

namespace Insenseanalytics\NovaBarMetrics;

use Laravel\Nova\Metrics\PartitionResult;

class BarChartMetricResult extends PartitionResult
{
	/**
	 * The metric value prefix.
	 *
	 * @var string
	 */
	public $prefix;

	/**
	 * The metric value suffix.
	 *
	 * @var string
	 */
	public $suffix;

	/**
	 * The precision of the average metric.
	 *
	 * @var int
	 */
	public $precision = 2;

	/**
	 * Set the metric value prefix.
	 *
	 * @param string $prefix
	 *
	 * @return $this
	 */
	public function prefix($prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}

	/**
	 * Set the metric value suffix.
	 *
	 * @param string $suffix
	 *
	 * @return $this
	 */
	public function suffix($suffix)
	{
		$this->suffix = $suffix;

		return $this;
	}

	/**
	 * Set the precision of the average metric.
	 *
	 * @param int $precision
	 *
	 * @return $this
	 */
	public function precision($precision)
	{
		$this->precision = $precision;

		return $this;
	}

	/**
	 * Indicate that the metric represents a dollar value.
	 *
	 * @param string $symbol
	 *
	 * @return $this
	 */
	public function dollars($symbol = '$')
	{
		return $this->prefix($symbol);
	}

	/**
	 * Indicate that the metric represents a euro value.
	 *
	 * @param string $symbol
	 *
	 * @return $this
	 */
	public function euros($symbol = '€')
	{
		return $this->prefix($symbol);
	}

	/**
	 * Indicate that the metric represents a rupee value.
	 *
	 * @param string $symbol
	 *
	 * @return $this
	 */
	public function rupees($symbol = '₹')
	{
		return $this->prefix($symbol);
	}

	/**
	 * Prepare the metric result for JSON serialization.
	 *
	 * @return array
	 */
	public function jsonSerialize()
	{
		return [
			'value' => collect($this->value ?? [])->map(function ($value, $label) {
				return ['label' => $label, 'value' => $value];
			})->values()->all(),
			'prefix' => $this->prefix,
			'suffix' => $this->suffix,
			'precision' => $this->precision,
		];
	}
}
