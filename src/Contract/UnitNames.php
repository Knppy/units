<?php

namespace Knppy\Units\Contract;

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\UnitOfMeasurement;

/**
 * Implement this to provide localized names for unit of measurements, and to resolve localized input back to a unit.
 */
interface UnitNames
{
    /**
     * Returns the localized name of a unit of measurement for a count, e.g. "theelepels" for 2 "tsp" in "nl".
     *
     * The count selects the plural form by the CLDR rules of the locale, so Russian and Arabic get their extra forms.
     * Falls back to the fallback locale, and finally to the name of the unit of measurement itself.
     *
     * @param  int|string  $count  A whole number, e.g. {@see Unit::getAmount()}
     *
     * @throws UnknownUnitOfMeasurementException
     */
    public function nameFor(UnitOfMeasurement $unitOfMeasurement, string $locale, int|string $count = 1): string;

    /**
     * Resolves a symbol, localized name or alias to a unit of measurement, e.g. "theelepel" to "tsp" in "nl".
     *
     * Symbols are matched exactly (case-sensitive) before names and aliases (case-insensitive).
     *
     * @throws UnknownUnitOfMeasurementException
     */
    public function parse(string $input, string $locale): UnitOfMeasurement;
}
