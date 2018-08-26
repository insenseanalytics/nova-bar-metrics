<?php

namespace Insenseanalytics\NovaBarMetrics;

class MySqlFrequencyDistributionExpression extends FrequencyDistributionExpression
{
    /**
     * Get the value of the expression.
     *
     * @return array
     */
    public function getValue()
    {
        return [
            'range' => "concat({$this->stepSize} * floor({$this->column}/{$this->stepSize}), ' - ', 
				{$this->stepSize} * floor({$this->column}/{$this->stepSize}) + {$this->stepSize} - 1)",
            'minVal' => "{$this->stepSize} * floor({$this->column}/{$this->stepSize})",
        ];
    }
}
