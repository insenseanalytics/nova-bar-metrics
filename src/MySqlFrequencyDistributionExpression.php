<?php

namespace Insenseanalytics\NovaBarMetrics;

class MySqlFrequencyDistributionExpression extends FrequencyDistributionExpression
{
	/**
	 * Get the value of the expression.
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return "concat({$this->stepSize} * floor({$this->column}/{$this->stepSize}), ' - ', 
            {$this->stepSize} * floor({$this->column}/{$this->stepSize}) + {$this->stepSize} - 1)";
	}
}
