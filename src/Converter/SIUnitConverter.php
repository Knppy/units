<?php

namespace Knppy\Units\Converter;

use Knppy\Units\Contract\UnitOfMeasurements;
use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Prefix;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\SIUnitOfMeasurements;

/**
 * Converts units between metric prefixes, e.g. kilometres to metres.
 */
final class SIUnitConverter extends AbstractUnitConverter
{
    /**
     * The kilogram is the SI base unit of mass, yet the gram is what gets prefixed.
     */
    private const string KILOGRAM = 'kg';

    private const string GRAM = 'g';

    /**
     * Units that cannot take a prefix.
     */
    public const array NOT_PREFIXABLE = ['°C', self::KILOGRAM];

    private readonly UnitOfMeasurements $unitOfMeasurements;

    public function __construct(?UnitOfMeasurements $unitOfMeasurements = null)
    {
        $this->unitOfMeasurements = $unitOfMeasurements ?? new SIUnitOfMeasurements;
    }

    /**
     * {@inheritDoc}
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
     * Multiplies a numeric string by 10^$exponent by moving the decimal point, so no precision is lost.
     */
    private function shift(string $amount, int $exponent): string
    {
        $negative = str_starts_with($amount, '-');
        [$whole, $fraction] = array_pad(explode('.', ltrim($amount, '-'), 2), 2, '');

        $digits = $whole.$fraction;
        $point = strlen($whole) + $exponent;

        if ($point <= 0) {
            $digits = str_repeat('0', 1 - $point).$digits;
            $point = 1;
        } elseif ($point > strlen($digits)) {
            $digits = str_pad($digits, $point, '0');
        }

        $integer = ltrim(substr($digits, 0, $point), '0');
        $decimals = rtrim(substr($digits, $point), '0');

        if ($integer === '' && $decimals === '') {
            return '0';
        }

        return ($negative ? '-' : '').($integer === '' ? '0' : $integer).($decimals === '' ? '' : '.'.$decimals);
    }
}
