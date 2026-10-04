<?php

namespace Knppy\Units\Contract;

use InvalidArgumentException;

interface Calculator
{
    /**
     * Compare a to b.
     *
     * Retrieves a negative value if $a < $b.
     * Retrieves a positive value if $a > $b.
     * Retrieves zero if $a == $b.
     */
    public static function compare(string $a, string $b): int;

    /**
     * Add added to amount.
     */
    public static function add(string $amount, string $addend): string;

    /**
     * Subtract subtrahend from amount.
     */
    public static function subtract(string $amount, string $subtrahend): string;

    /**
     * Multiply amount with multiplier.
     */
    public static function multiply(string $amount, string $multiplier): string;

    /**
     * Divide amount with divisor.
     *
     * @throws InvalidArgumentException when $divisor is zero.
     */
    public static function divide(string $amount, string $divisor): string;

    /**
     * Round number to following integer.
     */
    public static function ceil(string $number): string;

    /**
     * Round number to preceding integer.
     */
    public static function floor(string $number): string;

    /**
     * Returns the absolute value of the number.
     */
    public static function absolute(string $number): string;

    /**
     * Round number, use rounding mode for tie-breaker.
     */
    public static function round(string $number, int $roundingMode): string;

    /**
     * Share amount among ratio / total portions.
     */
    public static function share(string $amount, string $ratio, string $total): string;

    /**
     * Get the modulus of an amount.
     *
     * @throws InvalidArgumentException when $divisor is zero.
     */
    public static function mod(string $amount, string $divisor): string;
}
