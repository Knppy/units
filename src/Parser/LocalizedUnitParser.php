<?php

namespace Knppy\Units\Parser;

use Knppy\Units\Contract\UnitNames;
use Knppy\Units\Contract\UnitParser;
use Knppy\Units\Exception\ParserException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

/**
 * Parses a whole amount followed by a localized unit name, symbol or alias, e.g. "2 theelepels" in "nl".
 */
final class LocalizedUnitParser implements UnitParser
{
    public function __construct(private readonly UnitNames $unitNames, private readonly string $locale) {}

    /**
     * {@inheritDoc}
     */
    public function parse(string $input, ?UnitOfMeasurement $fallbackUnitOfMeasurement = null): Unit
    {
        if (! preg_match('/^\s*([+-]?\d++)(?![.,])\s*(\S.*?)?\s*$/u', $input, $matches)) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, expected an amount and a unit name.');
        }

        try {
            $unitOfMeasurement = isset($matches[2])
                ? $this->unitNames->parse($matches[2], $this->locale)
                : $fallbackUnitOfMeasurement;
        } catch (UnknownUnitOfMeasurementException $exception) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, '.$exception->getMessage(), previous: $exception);
        }

        if ($unitOfMeasurement === null) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, it has no unit of measurement.');
        }

        return new Unit(ltrim($matches[1], '+'), $unitOfMeasurement);
    }
}
