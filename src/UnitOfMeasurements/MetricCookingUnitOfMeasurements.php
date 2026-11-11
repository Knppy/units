<?php

namespace Knppy\Units\UnitOfMeasurements;

use Knppy\Units\Converter\CookingUnitConverter;

/**
 * List of cooking units with metric spoons and cups: 5 ml for a teaspoon, 15 ml for a tablespoon, 250 ml for a cup.
 *
 * Pass it to the {@see CookingUnitConverter} to convert with these sizes.
 */
class MetricCookingUnitOfMeasurements extends CookingUnitOfMeasurements
{
    /**
     * {@inheritDoc}
     */
    protected function resource(): string
    {
        return 'cooking-metric.php';
    }
}
