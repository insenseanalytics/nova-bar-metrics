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
     * @param int                                          $stepSize
     *
     * @return \Laravel\Nova\Metrics\PartitionResult
     */
    public function distributions($request, $model, $column, $stepSize)
    {
        $subQuery = $model instanceof Builder ? $model : (new $model())->newQuery();

        $expression = FrequencyDistributionExpressionFactory::make(
            $subQuery,
            $column,
            $stepSize
        )->getValue();

        $subQuery = $subQuery
            ->select(DB::raw("{$expression['range']} as rng, 
                {$expression['minVal']} as minval, count(*) as aggregate"))
            ->groupBy(DB::raw('1'), DB::raw('2'));

        $query = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery->getQuery());

        $results = $query
            ->select('rng', 'aggregate', 'minval')
            ->orderBy('minval', 'asc')
            ->get();

        return $this->result($results->mapWithKeys(function ($result) use ($column) {
            return $this->formatAggregateResult($result, 'rng');
        })->all());
    }

    /**
     * Return a partition/derived result showing the segments of a frequency range.
     *
     * @param \Illuminate\Http\Request                     $request
     * @param \Illuminate\Database\Eloquent\Builder|string $model
     * @param string                                       $column
     * @param int                                          $maxSteps
     *
     * @return \Laravel\Nova\Metrics\PartitionResult
     */
    public function distributionsWithSteps($request, $model, $column, $maxSteps = 15)
    {
        $query = $model instanceof Builder ? $model : (new $model())->newQuery();

        $difference = $query->max($column) - $query->min($column);

        if (!$difference) {
            $stepSize = 1;
        } else {
            $stepSize = round($difference / $maxSteps, 0);
        }

        return $this->distributions($request, $query, $column, $stepSize);
    }
}
