<?php

namespace Knppy\Units\Formatter;

use Knppy\Units\Contract\UnitFormatter;
use Knppy\Units\Unit;

/**
 * Formats only the amount, e.g. "-1500", without a unit of measurement.
 */
final class DecimalUnitFormatter implements UnitFormatter
{
    /**
     * {@inheritDoc}
     */
    public function format(Unit $unit): string
    {
        return $unit->getAmount();
    }
}
