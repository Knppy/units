<?php

namespace Knppy\Units\Calculator;

use InvalidArgumentException;
use Knppy\Units\Contract\Calculator;
use RoundingMode;

class BcMathCalculator implements Calculator
{
    private const int SCALE = 14;

    /**
     * {@inheritDoc}
     */
    public static function compare(string $a, string $b): int
    {
        return bccomp($a, $b, self::SCALE);
    }

    /**
     * {@inheritDoc}
     */
    public static function add(string $amount, string $addend): string
    {
        return self::trim(bcadd($amount, $addend, self::SCALE));
    }

    /**
     * {@inheritDoc}
     */
    public static function subtract(string $amount, string $subtrahend): string
    {
        return self::trim(bcsub($amount, $subtrahend, self::SCALE));
    }

    /**
     * {@inheritDoc}
     */
    public static function multiply(string $amount, string $multiplier): string
    {
        return self::trim(bcmul($amount, $multiplier, self::SCALE));
    }

    /**
     * {@inheritDoc}
     */
    public static function divide(string $amount, string $divisor): string
    {
        if (self::isZero($divisor)) {
            throw new InvalidArgumentException('Division by zero');
        }

        return self::trim(bcdiv($amount, $divisor, self::SCALE));
    }

    /**
     * {@inheritDoc}
     */
    public static function ceil(string $number): string
    {
        return self::trim(bcceil($number));
    }

    /**
     * {@inheritDoc}
     */
    public static function floor(string $number): string
    {
        return self::trim(bcfloor($number));
    }

    /**
     * {@inheritDoc}
     */
    public static function absolute(string $number): string
    {
        return self::trim(ltrim(bcadd($number, '0', self::SCALE), '-'));
    }

    /**
     * {@inheritDoc}
     */
    public static function round(string $number, int $roundingMode): string
    {
        $mode = match ($roundingMode) {
            PHP_ROUND_HALF_UP => RoundingMode::HalfAwayFromZero,
            PHP_ROUND_HALF_DOWN => RoundingMode::HalfTowardsZero,
            PHP_ROUND_HALF_EVEN => RoundingMode::HalfEven,
            PHP_ROUND_HALF_ODD => RoundingMode::HalfOdd,
            default => throw new InvalidArgumentException("Unknown rounding mode: $roundingMode"),
        };

        return self::trim(bcround($number, 0, $mode));
    }

    /**
     * {@inheritDoc}
     */
    public static function share(string $amount, string $ratio, string $total): string
    {
        return self::divide(self::multiply($amount, $ratio), $total);
    }

    /**
     * {@inheritDoc}
     */
    public static function mod(string $amount, string $divisor): string
    {
        if (self::isZero($divisor)) {
            throw new InvalidArgumentException('Division by zero');
        }

        return self::trim(bcmod($amount, $divisor, self::SCALE));
    }

    private static function isZero(string $number): bool
    {
        return bccomp($number, '0', self::SCALE) === 0;
    }

    /**
     * Strip trailing zeros (and a dangling decimal point) from a bcmath result.
     */
    private static function trim(string $number): string
    {
        if (str_contains($number, '.')) {
            $number = rtrim(rtrim($number, '0'), '.');
        }

        return $number === '-0' || $number === '' ? '0' : $number;
    }
}
