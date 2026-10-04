<?php

namespace Knppy\Units\UnitOfMeasurements;

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\UnitOfMeasurement;

/**
 * List of cooking units: volumes and masses (US customary), counts, and imprecise amounts such as a pinch.
 */
class CookingUnitOfMeasurements extends ResourceUnitOfMeasurements
{
    /**
     * Returns how many millilitres (volumes) or grams (masses) one of the unit is, as an exact decimal string.
     *
     * Null for units that have no fixed size, such as a pinch or a clove.
     *
     * @throws UnknownUnitOfMeasurementException
     */
    public function ratioFor(UnitOfMeasurement $unitOfMeasurement): ?string
    {
        return $this->definitionFor($unitOfMeasurement)['ratio'] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    protected function resource(): string
    {
        return 'cooking.php';
    }
}
