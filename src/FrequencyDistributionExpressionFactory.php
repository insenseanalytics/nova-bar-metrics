<?php

namespace Insenseanalytics\NovaBarMetrics;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;

class FrequencyDistributionExpressionFactory
{
	/**
	 * Create a new trend expression instance.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string                                $column
	 * @param int                                   $stepSize
	 *
	 * @return \Laravel\Nova\Metrics\FrequencyDistributionExpression
	 */
	public static function make(Builder $query, $column, $stepSize)
	{
		switch ($query->getConnection()->getDriverName()) {
			case 'sqlite':
				return new SqliteFrequencyDistributionExpression($query, $column, $stepSize);
			case 'mysql':
				return new MySqlFrequencyDistributionExpression($query, $column, $stepSize);
			case 'pgsql':
				return new PostgresFrequencyDistributionExpression($query, $column, $stepSize);
			default:
				throw new InvalidArgumentException('Bar chart metric helpers are not supported for this database.');
		}
	}
}
