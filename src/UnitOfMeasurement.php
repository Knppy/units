<?php

namespace Knppy\Units;

use JsonSerializable;
use Knppy\Units\Exception\InvalidUnitOfMeasurementException;

/**
 * A unit of measurement identified by its case-sensitive symbol, e.g. "m" or "kg".
 */
final class UnitOfMeasurement implements JsonSerializable
{
    /**
     * Symbol of the unit, case is preserved.
     */
    private readonly string $symbol;

    /**
     * @param  string  $symbol  Non-empty symbol, e.g. "Pa".
     *
     * @throws InvalidUnitOfMeasurementException
     */
    public function __construct(string $symbol)
    {
        if ($symbol === '') {
            throw new InvalidUnitOfMeasurementException('The symbol of a unit of measurement cannot be empty.');
        }

        $this->symbol = $symbol;
    }

    /**
     * Returns the symbol.
     */
    public function __toString(): string
    {
        return $this->symbol;
    }

    /**
     * Determine whether both units of measurement have the same symbol.
     */
    public function equals(UnitOfMeasurement $other): bool
    {
        return $this->symbol === $other->symbol;
    }

    /**
     * Returns the symbol.
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * Serializes to the symbol.
     */
    public function jsonSerialize(): string
    {
        return $this->symbol;
    }

    /**
     * Creates a unit with an amount of zero in this unit of measurement.
     */
    public function zero(): Unit
    {
        return new Unit(0, $this);
    }
}
