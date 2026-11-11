<?php

namespace Knppy\Units;

use InvalidArgumentException;
use JsonSerializable;
use Knppy\Units\Calculator\BcMathCalculator;
use Knppy\Units\Contract\Calculator;
use Knppy\Units\Contract\UnitConverter;
use Knppy\Units\Converter\SIUnitConverter;
use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\InvalidAmountException;

/**
 * An amount of a unit of measurement, e.g. 5 metres.
 */
final class Unit implements JsonSerializable
{
    /**
     * Amount as a numeric string, to avoid integer overflow and float errors.
     */
    private readonly string $amount;

    /**
     * @var class-string<Calculator>
     */
    private static string $calculator = BcMathCalculator::class;

    private static function assertNumeric(int|string $number): string
    {
        $number = (string) $number;
        if (! is_numeric($number)) {
            throw new InvalidArgumentException('Operand must be numeric, got "'.$number.'".');
        }

        return $number;
    }

    /**
     * Returns the class name of the registered calculator.
     *
     * @return class-string<Calculator>
     */
    public static function getCalculator(): string
    {
        return self::$calculator;
    }

    /**
     * Registers the calculator used for all arithmetic, e.g. to swap bcmath for another implementation.
     *
     * @param  class-string<Calculator>  $calculator
     *
     * @throws InvalidArgumentException when the class does not implement {@see Calculator}.
     */
    public static function registerCalculator(string $calculator): void
    {
        if (! is_a($calculator, Calculator::class, true)) {
            throw new InvalidArgumentException('Calculator must implement '.Calculator::class.'.');
        }

        self::$calculator = $calculator;
    }

    /**
     * @param  int|string  $amount  Number with at most $scale decimals, optionally negative.
     * @param  UnitOfMeasurement  $unitOfMeasurement  The unit the amount is expressed in.
     * @param  int  $scale  Number of decimals the amount can have, 0 for whole numbers. Arithmetic rounds to it.
     *
     * @throws InvalidAmountException
     */
    public function __construct(int|string $amount, private readonly UnitOfMeasurement $unitOfMeasurement, private readonly int $scale = 0)
    {
        $amount = (string) $amount;

        if ($scale < 0) {
            throw new InvalidAmountException('Scale cannot be negative, got '.$scale.'.');
        }

        if ($scale === 0 && ! preg_match('/^-?\d+$/', $amount)) {
            throw new InvalidAmountException('Amount must be an integer, got "'.$amount.'".');
        }

        if ($scale > 0 && ! preg_match('/^-?\d+(\.\d{1,'.$scale.'})?$/', $amount)) {
            throw new InvalidAmountException('Amount must be a number with at most '.$scale.' decimals, got "'.$amount.'".');
        }

        $this->amount = $amount;
    }

    /**
     * Returns the absolute value.
     */
    public function absolute(): self
    {
        return new self(self::$calculator::absolute($this->amount), $this->unitOfMeasurement, $this->scale);
    }

    /**
     * Adds the given units, which must share this unit of measurement.
     *
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function add(self ...$addends): self
    {
        $amount = $this->amount;
        $scale = $this->scale;

        foreach ($addends as $addend) {
            $this->assertSameUnitOfMeasurement($addend);
            $amount = self::$calculator::add($amount, $addend->amount);
            $scale = max($scale, $addend->scale);
        }

        return new self($amount, $this->unitOfMeasurement, $scale);
    }

    /**
     * @throws IncompatibleUnitOfMeasurementException
     */
    private function assertSameUnitOfMeasurement(self $other): void
    {
        if (! $this->unitOfMeasurement->equals($other->unitOfMeasurement)) {
            throw new IncompatibleUnitOfMeasurementException(
                'Units of measurement must match, got "'.$this->unitOfMeasurement.'" and "'.$other->unitOfMeasurement.'".'
            );
        }
    }

    /**
     * Returns a negative, zero or positive integer when this amount is less than, equal to or greater than the other.
     *
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function compare(self $other): int
    {
        $this->assertSameUnitOfMeasurement($other);

        return self::$calculator::compare($this->amount, $other->amount);
    }

    /**
     * Converts to another unit of measurement, e.g. kilometres to metres.
     *
     * @param  UnitConverter|null  $converter  Defaults to {@see SIUnitConverter}.
     *
     * @throws IncompatibleUnitOfMeasurementException
     * @throws Exception\InexactConversionException
     * @throws Exception\UnknownUnitOfMeasurementException
     */
    public function convertTo(UnitOfMeasurement $to, ?UnitConverter $converter = null): self
    {
        return ($converter ?? new SIUnitConverter)->convert($this, $to);
    }

    /**
     * Divides the amount, rounding the result to the scale of this unit.
     *
     * @param  int|string  $divisor  Numeric, may be fractional.
     * @param  int  $roundingMode  One of the PHP_ROUND_HALF_* constants.
     *
     * @throws InvalidArgumentException when the divisor is not numeric or is zero.
     */
    public function divide(int|string $divisor, int $roundingMode = PHP_ROUND_HALF_UP): self
    {
        $divisor = self::assertNumeric($divisor);

        return new self(
            self::$calculator::round(self::$calculator::divide($this->amount, $divisor), $roundingMode, $this->scale),
            $this->unitOfMeasurement,
            $this->scale,
        );
    }

    /**
     * Determine whether both amounts and units of measurement are equal.
     */
    public function equals(self $other): bool
    {
        return $this->unitOfMeasurement->equals($other->unitOfMeasurement)
            && self::$calculator::compare($this->amount, $other->amount) === 0;
    }

    /**
     * Returns the amount as a numeric string.
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Returns the number of decimals the amount can have.
     */
    public function getScale(): int
    {
        return $this->scale;
    }

    /**
     * Returns the unit of measurement the amount is expressed in.
     */
    public function getUnitOfMeasurement(): UnitOfMeasurement
    {
        return $this->unitOfMeasurement;
    }

    /**
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function greaterThan(self $other): bool
    {
        return $this->compare($other) > 0;
    }

    /**
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function greaterThanOrEqual(self $other): bool
    {
        return $this->compare($other) >= 0;
    }

    /**
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function lessThan(self $other): bool
    {
        return $this->compare($other) < 0;
    }

    /**
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function lessThanOrEqual(self $other): bool
    {
        return $this->compare($other) <= 0;
    }

    public function isNegative(): bool
    {
        return self::$calculator::compare($this->amount, '0') < 0;
    }

    public function isPositive(): bool
    {
        return self::$calculator::compare($this->amount, '0') > 0;
    }

    public function isZero(): bool
    {
        return self::$calculator::compare($this->amount, '0') === 0;
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

    /**
     * Returns the remainder after dividing by the given unit, which must share this unit of measurement.
     *
     * @throws IncompatibleUnitOfMeasurementException
     * @throws InvalidArgumentException when the divisor is zero.
     */
    public function mod(self $divisor): self
    {
        $this->assertSameUnitOfMeasurement($divisor);

        return new self(self::$calculator::mod($this->amount, $divisor->amount), $this->unitOfMeasurement, max($this->scale, $divisor->scale));
    }

    /**
     * Multiplies the amount, rounding the result to the scale of this unit.
     *
     * @param  int|string  $multiplier  Numeric, may be fractional.
     * @param  int  $roundingMode  One of the PHP_ROUND_HALF_* constants.
     *
     * @throws InvalidArgumentException when the multiplier is not numeric.
     */
    public function multiply(int|string $multiplier, int $roundingMode = PHP_ROUND_HALF_UP): self
    {
        $multiplier = self::assertNumeric($multiplier);

        return new self(
            self::$calculator::round(self::$calculator::multiply($this->amount, $multiplier), $roundingMode, $this->scale),
            $this->unitOfMeasurement,
            $this->scale,
        );
    }

    /**
     * Returns the amount with its sign flipped.
     */
    public function negative(): self
    {
        return new self(self::$calculator::subtract('0', $this->amount), $this->unitOfMeasurement, $this->scale);
    }

    /**
     * Subtracts the given units, which must share this unit of measurement.
     *
     * @throws IncompatibleUnitOfMeasurementException
     */
    public function subtract(self ...$subtrahends): self
    {
        $amount = $this->amount;
        $scale = $this->scale;

        foreach ($subtrahends as $subtrahend) {
            $this->assertSameUnitOfMeasurement($subtrahend);
            $amount = self::$calculator::subtract($amount, $subtrahend->amount);
            $scale = max($scale, $subtrahend->scale);
        }

        return new self($amount, $this->unitOfMeasurement, $scale);
    }
}
