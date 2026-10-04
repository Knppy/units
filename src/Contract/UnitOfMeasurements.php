<?php

namespace Knppy\Units\Contract;

use IteratorAggregate;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Quantity;
use Knppy\Units\UnitOfMeasurement;
use Traversable;

/**
 * Implement this to provide a list of unit of measurements.
 *
 * @extends IteratorAggregate<int|string, UnitOfMeasurement>
 */
interface UnitOfMeasurements extends IteratorAggregate
{
    /**
     * Determine whether a unit of measurement is available in the current context.
     */
    public function contains(UnitOfMeasurement $unitOfMeasurement): bool;

    /**
     * Returns the full name of a unit of measurement, e.g. "kilogram".
     *
     * @throws UnknownUnitOfMeasurementException
     */
    public function nameFor(UnitOfMeasurement $unitOfMeasurement): string;

    /**
     * Returns the physical quantity a unit of measurement measures, e.g. {@see Quantity::Mass}.
     *
     * @throws UnknownUnitOfMeasurementException
     */
    public function quantityFor(UnitOfMeasurement $unitOfMeasurement): Quantity;

    /**
     * @return Traversable<int|string, UnitOfMeasurement>
     */
    public function getIterator(): Traversable;
}
