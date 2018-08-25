<?php

namespace Insenseanalytics\NovaBarMetrics;

class SqliteFrequencyDistributionExpression extends FrequencyDistributionExpression
{
	/**
	 * Get the value of the expression.
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return "(cast({$this->stepSize} * cast({$this->column}/{$this->stepSize} as int) as string) || ' - ' || 
            cast({$this->stepSize} * cast({$this->column}/{$this->stepSize} as int) + {$this->stepSize} - 1 as string))";
	}
}
