<?php

namespace Knppy\Units\Formatter;

use Knppy\Units\Contract\UnitFormatter;
use Knppy\Units\Contract\UnitNames;
use Knppy\Units\Parser\LocalizedUnitParser;
use Knppy\Units\Unit;
use NumberFormatter;

/**
 * Formats a unit in a locale, e.g. "1.500 theelepels" in "nl", with the plural form selected by the amount.
 *
 * The inverse of {@see LocalizedUnitParser} when grouping is off.
 */
final class LocalizedUnitFormatter implements UnitFormatter
{
    private readonly NumberFormatter $numberFormatter;

    /**
     * @param  bool  $grouping  Whether to group digits as the locale does, e.g. "1.500" in "nl".
     * @param  bool  $useName  Use the localized name of the unit, or its symbol when false.
     */
    public function __construct(
        private readonly UnitNames $unitNames,
        private readonly string $locale,
        private readonly bool $grouping = true,
        private readonly bool $useName = true,
        private readonly string $separator = ' ',
    ) {
        $this->numberFormatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $this->numberFormatter->setAttribute(NumberFormatter::GROUPING_USED, $grouping ? 1 : 0);
    }

    /**
     * {@inheritDoc}
     */
    public function format(Unit $unit): string
    {
        $amount = $unit->getAmount();
        $unitOfMeasurement = $unit->getUnitOfMeasurement();

        $label = $this->useName
            ? $this->unitNames->nameFor($unitOfMeasurement, $this->locale, $amount)
            : $unitOfMeasurement->getSymbol();

        return $this->formatAmount($amount).$this->separator.$label;
    }

    private function formatAmount(string $amount): string
    {
        if ($amount === (string) (int) $amount) {
            return (string) $this->numberFormatter->format((int) $amount);
        }

        // Beyond the integer range, group by thousands rather than lose digits to a float.
        $negative = str_starts_with($amount, '-');
        $digits = ltrim($amount, '-');

        if ($this->grouping) {
            $groupingSeparator = $this->numberFormatter->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL);
            $digits = strrev(implode($groupingSeparator, str_split(strrev($digits), 3)));
        }

        return ($negative ? $this->numberFormatter->getSymbol(NumberFormatter::MINUS_SIGN_SYMBOL) : '').$digits;
    }
}
