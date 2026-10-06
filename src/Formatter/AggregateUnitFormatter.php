<?php

namespace Knppy\Units\Formatter;

use Knppy\Units\Contract\UnitFormatter;
use Knppy\Units\Exception\FormatterException;
use Knppy\Units\Unit;

/**
 * Formats a unit with the formatter registered for its symbol, e.g. a different one for "kg" than for "tsp".
 */
final class AggregateUnitFormatter implements UnitFormatter
{
    /**
     * @param  array<string, UnitFormatter>  $formatters  Formatters keyed by symbol.
     * @param  UnitFormatter|null  $default  Used for symbols without a formatter, which would otherwise throw.
     */
    public function __construct(private readonly array $formatters, private readonly ?UnitFormatter $default = null) {}

    /**
     * {@inheritDoc}
     */
    public function format(Unit $unit): string
    {
        $symbol = $unit->getUnitOfMeasurement()->getSymbol();
        $formatter = $this->formatters[$symbol] ?? $this->default;

        if ($formatter === null) {
            throw new FormatterException('No formatter is registered for the unit of measurement "'.$symbol.'".');
        }

        return $formatter->format($unit);
    }
}
