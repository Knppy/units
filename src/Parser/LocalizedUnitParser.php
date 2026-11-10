<?php

namespace Knppy\Units\Parser;

use Knppy\Units\Contract\UnitNames;
use Knppy\Units\Contract\UnitParser;
use Knppy\Units\Exception\ParserException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;
use NumberFormatter;

/**
 * Parses an amount followed by a localized unit name, symbol or alias, e.g. "2 theelepels" or "1,5 el" in "nl".
 *
 * The decimal separator is the one of the locale and the scale of the unit is the number of decimals written.
 */
final class LocalizedUnitParser implements UnitParser
{
    private readonly string $decimalSeparator;

    public function __construct(private readonly UnitNames $unitNames, private readonly string $locale)
    {
        $symbol = (new NumberFormatter($locale, NumberFormatter::DECIMAL))->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);

        $this->decimalSeparator = $symbol === ',' ? ',' : '.';
    }

    /**
     * {@inheritDoc}
     */
    public function parse(string $input, ?UnitOfMeasurement $fallbackUnitOfMeasurement = null): Unit
    {
        $separator = preg_quote($this->decimalSeparator, '/');

        if (! preg_match('/^\s*([+-]?\d++(?:'.$separator.'(\d++))?)(?![.,])\s*(\S.*?)?\s*$/u', $input, $matches)) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, expected an amount and a unit name.');
        }

        try {
            $unitOfMeasurement = isset($matches[3])
                ? $this->unitNames->parse($matches[3], $this->locale)
                : $fallbackUnitOfMeasurement;
        } catch (UnknownUnitOfMeasurementException $exception) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, '.$exception->getMessage(), previous: $exception);
        }

        if ($unitOfMeasurement === null) {
            throw new ParserException('Cannot parse "'.$input.'" as a unit, it has no unit of measurement.');
        }

        return new Unit(str_replace(',', '.', ltrim($matches[1], '+')), $unitOfMeasurement, strlen($matches[2] ?? ''));
    }
}
