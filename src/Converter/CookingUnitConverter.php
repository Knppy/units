<?php

namespace Knppy\Units\Converter;

use Knppy\Units\Calculator\BcMathCalculator;
use Knppy\Units\Contract\Calculator;
use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\CookingUnitOfMeasurements;

/**
 * Converts cooking units of the same quantity, e.g. tablespoons to teaspoons or pounds to ounces.
 *
 * Units without a fixed size, such as a pinch or a clove, can only be "converted" to themselves.
 */
final class CookingUnitConverter extends AbstractUnitConverter
{
    /**
     * @param  class-string<Calculator>  $calculator
     */
    public function __construct(
        private readonly CookingUnitOfMeasurements $unitOfMeasurements = new CookingUnitOfMeasurements,
        private readonly string $calculator = BcMathCalculator::class,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function convertToDecimal(Unit $unit, UnitOfMeasurement $to): string
    {
        $from = $unit->getUnitOfMeasurement();

        $fromQuantity = $this->unitOfMeasurements->quantityFor($from);
        $toQuantity = $this->unitOfMeasurements->quantityFor($to);

        if ($from->equals($to)) {
            return $unit->getAmount();
        }

        $fromRatio = $this->unitOfMeasurements->ratioFor($from);
        $toRatio = $this->unitOfMeasurements->ratioFor($to);

        if ($fromRatio === null || $toRatio === null || $fromQuantity !== $toQuantity) {
            throw new IncompatibleUnitOfMeasurementException('Cannot convert '.$from.' to '.$to.'.');
        }

        return $this->calculator::divide(
            $this->calculator::multiply($unit->getAmount(), $fromRatio),
            $toRatio,
        );
    }
}
