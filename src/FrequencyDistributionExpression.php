<?php

namespace Insenseanalytics\NovaBarMetrics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

abstract class FrequencyDistributionExpression
{
    /**
     * The query builder being used to build the trend.
     *
     * @var \Illuminate\Database\Query\Builder
     */
    public $query;

    /**
     * The column being measured.
     *
     * @var string
     */
    public $column;

    /**
     * The step size for the frequency distribution.
     *
     * @var int
     */
    public $stepSize;

    /**
     * Create a new raw query expression.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $column
     * @param int                                   $stepSize
     */
    public function __construct(Builder $query, $column, $stepSize)
    {
        $this->query = $query;
        $this->column = $column;
        $this->stepSize = $stepSize;
    }

    /**
     * Get the value of the expression.
     *
     * @return array
     */
    abstract public function getValue();
}
