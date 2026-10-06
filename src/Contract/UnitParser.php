<?php

namespace Knppy\Units\Contract;

use Knppy\Units\Exception\ParserException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

/**
 * Implement this to turn a string such as "5 kg" into a unit.
 */
interface UnitParser
{
    /**
     * Parses the input into a unit.
     *
     * @param  UnitOfMeasurement|null  $fallbackUnitOfMeasurement  Used when the input holds an amount without a unit of measurement.
     *
     * @throws ParserException
     */
    public function parse(string $input, ?UnitOfMeasurement $fallbackUnitOfMeasurement = null): Unit;
}
