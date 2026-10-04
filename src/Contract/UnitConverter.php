<?php

namespace Knppy\Units\Contract;

use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\InexactConversionException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

/**
 * Implement this to convert units within a system of units, e.g. SI or cooking.
 */
interface UnitConverter
{
    /**
     * Converts a unit to another unit of measurement.
     *
     * @throws IncompatibleUnitOfMeasurementException
     * @throws UnknownUnitOfMeasurementException
     * @throws InexactConversionException When the result is not a whole number, see convertToDecimal().
     */
    public function convert(Unit $unit, UnitOfMeasurement $to): Unit;

    /**
     * Converts the amount of a unit to another unit of measurement, as an exact decimal string.
     *
     * @throws IncompatibleUnitOfMeasurementException
     * @throws UnknownUnitOfMeasurementException
     */
    public function convertToDecimal(Unit $unit, UnitOfMeasurement $to): string;
}
