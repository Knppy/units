<?php

namespace Knppy\Units\Converter;

use Knppy\Units\Contract\UnitConverter;
use Knppy\Units\Exception\InexactConversionException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

/**
 * Shares the whole-number conversion between unit converters.
 */
abstract class AbstractUnitConverter implements UnitConverter
{
    /**
     * {@inheritDoc}
     */
    public function convert(Unit $unit, UnitOfMeasurement $to): Unit
    {
        $amount = $this->convertToDecimal($unit, $to);

        if (str_contains($amount, '.')) {
            throw new InexactConversionException(
                'Converting '.$unit->getAmount().' '.$unit->getUnitOfMeasurement().' to '.$to.' gives '.$amount.', which is not a whole number.'
            );
        }

        return new Unit($amount, $to);
    }
}
