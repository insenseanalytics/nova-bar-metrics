<?php

namespace Insenseanalytics\NovaBarMetrics;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

/**
 * Use only with partition metrics or metrics derived from the Partition class
 * like BarChartMetric.
 */
trait HasFrequencyDistributions
{
	/**
	 * Return a partition/derived result showing the segments of a frequency range.
	 *
	 * @param \Illuminate\Http\Request                     $request
	 * @param \Illuminate\Database\Eloquent\Builder|string $model
	 * @param string                                       $column
	 * @param int|null                                     $min
	 * @param int|null                                     $max
	 *
	 * @return \Laravel\Nova\Metrics\PartitionResult
	 */
	public function distributionsByStepSize($request, $model, $column, $stepSize)
	{
		$subQuery = $model instanceof Builder ? $model : (new $model())->newQuery();

		$expression = (string) FrequencyDistributionExpressionFactory::make(
			$subQuery, $column, $stepSize
		);

		$subQuery->orderBy($column, 'asc');

		$query = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
			->mergeBindings($subQuery->getQuery());

		$results = $query
			->select(DB::raw("{$expression} as rng, count(*) as aggregate"))
			->groupBy(DB::raw('1'))
			->get();

		return $this->result($results->mapWithKeys(function ($result) use ($column) {
			return $this->formatAggregateResult($result, 'rng');
		})->all());
	}
}
