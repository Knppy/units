<?php

namespace Knppy\Units\Parser;

use Knppy\Units\Contract\UnitParser;
use Knppy\Units\Exception\ParserException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

/**
 * Parses a whole amount followed by a unit symbol, e.g. "5 kg", "-3m" or "20 °C".
 *
 * The symbol is not checked against a list of unit of measurements, so any symbol is accepted.
 */
final class SymbolUnitParser implements UnitParser
{
    /**
     * {@inheritDoc}
     */
    public function parse(string $input, ?UnitOfMeasurement $fallbackUnitOfMeasurement = null): Unit
    {
        if (! preg_match('/^\s*([+-]?\d++)(?![.,])\s*(\S.*?)?\s*$/u', $input, $matches)) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, expected an amount and a symbol.');
        }

        $unitOfMeasurement = isset($matches[2])
            ? new UnitOfMeasurement($matches[2])
            : $fallbackUnitOfMeasurement;

        if ($unitOfMeasurement === null) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, it has no unit of measurement.');
        }

        return new Unit(ltrim($matches[1], '+'), $unitOfMeasurement);
    }
}
