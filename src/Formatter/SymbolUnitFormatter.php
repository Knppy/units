<?php

namespace Knppy\Units\Formatter;

use Knppy\Units\Contract\UnitFormatter;
use Knppy\Units\Parser\SymbolUnitParser;
use Knppy\Units\Unit;

/**
 * Formats the amount followed by the symbol, e.g. "5 kg" or "20 °C". The inverse of {@see SymbolUnitParser}.
 */
final class SymbolUnitFormatter implements UnitFormatter
{
    /**
     * @param  string  $separator  Placed between the amount and the symbol, e.g. a no-break space.
     */
    public function __construct(private readonly string $separator = ' ') {}

    /**
     * {@inheritDoc}
     */
    public function format(Unit $unit): string
    {
        return $unit->getAmount().$this->separator.$unit->getUnitOfMeasurement()->getSymbol();
    }
}
