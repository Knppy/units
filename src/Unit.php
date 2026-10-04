<?php

namespace Knppy\Units;

use JsonSerializable;
use Knppy\Units\Exception\InvalidAmountException;

/**
 * An amount of a unit of measurement, e.g. 5 metres.
 */
final class Unit implements JsonSerializable
{
    /**
     * Amount as an integer string, to avoid integer overflow.
     */
    private readonly string $amount;

    /**
     * @param  int|string  $amount  Whole number, optionally negative.
     * @param  UnitOfMeasurement  $unitOfMeasurement  The unit the amount is expressed in.
     *
     * @throws InvalidAmountException
     */
    public function __construct(int|string $amount, private readonly UnitOfMeasurement $unitOfMeasurement)
    {
        $amount = (string) $amount;

        if (! preg_match('/^-?\d+$/', $amount)) {
            throw new InvalidAmountException('Amount must be an integer, got "'.$amount.'".');
        }

        $this->amount = $amount;
    }

    /**
     * Returns the amount as an integer string.
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Returns the unit of measurement the amount is expressed in.
     */
    public function getUnitOfMeasurement(): UnitOfMeasurement
    {
        return $this->unitOfMeasurement;
    }

    /**
     * Converts to another prefix of the same base unit, e.g. kilometres to metres.
     *
     * @throws Exception\IncompatibleUnitOfMeasurementException
     * @throws Exception\InexactConversionException
     * @throws Exception\UnknownUnitOfMeasurementException
     */
    public function convertTo(UnitOfMeasurement $to): self
    {
        return (new UnitConverter)->convert($this, $to);
    }

    /**
     * Serializes to an array holding the amount and the unit symbol.
     *
     * @return array{amount: string, unit: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'unit' => $this->unitOfMeasurement->jsonSerialize(),
        ];
    }
}
