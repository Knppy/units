<?php

namespace Knppy\Units\UnitNames;

use Knppy\Units\Contract\UnitOfMeasurements;
use Knppy\Units\UnitOfMeasurements\CookingUnitOfMeasurements;

/**
 * Localized names of cooking units.
 */
class CookingUnitNames extends ResourceUnitNames
{
    /**
     * {@inheritDoc}
     */
    protected function resource(): string
    {
        return 'cooking.php';
    }

    /**
     * {@inheritDoc}
     */
    protected function unitOfMeasurements(): UnitOfMeasurements
    {
        return new CookingUnitOfMeasurements;
    }
}
