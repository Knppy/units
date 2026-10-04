<?php

namespace Knppy\Units;

use Knppy\Units\Contract\UnitOfMeasurements;
use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\InexactConversionException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\UnitOfMeasurements\SIUnitOfMeasurements;

/**
 * Converts units between metric prefixes, e.g. kilometres to metres.
 */
final class UnitConverter
{
    /**
     * The kilogram is the SI base unit of mass, yet the gram is what gets prefixed.
     */
    private const string KILOGRAM = 'kg';

    private const string GRAM = 'g';

    /**
     * Units that cannot take a prefix.
     */
    private const array NOT_PREFIXABLE = ['°C', self::KILOGRAM];

    private readonly UnitOfMeasurements $unitOfMeasurements;

    public function __construct(?UnitOfMeasurements $unitOfMeasurements = null)
    {
        $this->unitOfMeasurements = $unitOfMeasurements ?? new SIUnitOfMeasurements;
    }

    /**
     * Converts a unit to another prefix of the same base unit.
     *
     * @throws IncompatibleUnitOfMeasurementException
     * @throws UnknownUnitOfMeasurementException
     * @throws InexactConversionException When the result is not a whole number, see convertToDecimal().
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

    /**
     * Converts the amount of a unit to another prefix of the same base unit, as an exact decimal string.
     *
     * @throws IncompatibleUnitOfMeasurementException
     * @throws UnknownUnitOfMeasurementException
     */
    public function convertToDecimal(Unit $unit, UnitOfMeasurement $to): string
    {
        $from = $this->resolve($unit->getUnitOfMeasurement());
        $target = $this->resolve($to);

        if (! $from['base']->equals($target['base'])) {
            throw new IncompatibleUnitOfMeasurementException(
                'Cannot convert '.$unit->getUnitOfMeasurement().' to '.$to.'.'
            );
        }

        return $this->shift($unit->getAmount(), $from['exponent'] - $target['exponent']);
    }

    /**
     * Splits a unit of measurement into its base unit and the power of ten relative to it.
     *
     * @return array{base: UnitOfMeasurement, exponent: int}
     *
     * @throws UnknownUnitOfMeasurementException
     */
    private function resolve(UnitOfMeasurement $unitOfMeasurement): array
    {
        if ($this->unitOfMeasurements->contains($unitOfMeasurement)) {
            return ['base' => $unitOfMeasurement, 'exponent' => 0];
        }

        $symbol = $unitOfMeasurement->getSymbol();

        if ($symbol === self::GRAM) {
            return ['base' => new UnitOfMeasurement(self::KILOGRAM), 'exponent' => -3];
        }

        $prefixes = Prefix::cases();
        usort($prefixes, fn (Prefix $a, Prefix $b) => strlen($b->getSymbol()) <=> strlen($a->getSymbol()));

        foreach ($prefixes as $prefix) {
            if (! str_starts_with($symbol, $prefix->getSymbol())) {
                continue;
            }

            $rest = substr($symbol, strlen($prefix->getSymbol()));

            if ($rest === self::GRAM) {
                return ['base' => new UnitOfMeasurement(self::KILOGRAM), 'exponent' => $prefix->getExponent() - 3];
            }

            $base = $rest === '' ? null : new UnitOfMeasurement($rest);

            if ($base !== null && ! in_array($rest, self::NOT_PREFIXABLE, true) && $this->unitOfMeasurements->contains($base)) {
                return ['base' => $base, 'exponent' => $prefix->getExponent()];
            }
        }

        throw new UnknownUnitOfMeasurementException('Unknown unit of measurement "'.$symbol.'".');
    }

    /**
     * Multiplies an integer string by 10^$exponent by moving the decimal point, so no precision is lost.
     */
    private function shift(string $amount, int $exponent): string
    {
        $negative = str_starts_with($amount, '-');
        $digits = ltrim($negative ? substr($amount, 1) : $amount, '0');

        if ($digits === '') {
            return '0';
        }

        if ($exponent >= 0) {
            $result = $digits.str_repeat('0', $exponent);
        } else {
            $places = -$exponent;
            $digits = str_pad($digits, $places + 1, '0', STR_PAD_LEFT);
            $fraction = rtrim(substr($digits, -$places), '0');
            $result = substr($digits, 0, -$places).($fraction === '' ? '' : '.'.$fraction);
        }

        return ($negative ? '-' : '').$result;
    }
}
