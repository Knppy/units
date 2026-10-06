<?php

use Knppy\Units\Calculator\BcMathCalculator;
use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\InvalidAmountException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

it('can be created from an int or string', function () {
    $m = new UnitOfMeasurement('m');

    expect((new Unit(5, $m))->getAmount())->toBe('5')
        ->and((new Unit('-12', $m))->getAmount())->toBe('-12')
        ->and((new Unit(5, $m))->getUnitOfMeasurement())->toBe($m);
});

it('rejects non-integer amounts', function (string $amount) {
    new Unit($amount, new UnitOfMeasurement('m'));
})->with(['1.5', 'abc', '', '1e3'])->throws(InvalidAmountException::class);

it('serializes to json', function () {
    expect(json_encode(new Unit(100, new UnitOfMeasurement('kg'))))->toBe('{"amount":"100","unit":"kg"}');
});

it('adds and subtracts units of the same measurement', function () {
    $m = new UnitOfMeasurement('m');

    expect((new Unit(5, $m))->add(new Unit(7, $m), new Unit(1, $m))->getAmount())->toBe('13')
        ->and((new Unit(5, $m))->subtract(new Unit(7, $m))->getAmount())->toBe('-2');
});

it('rejects arithmetic across units of measurement', function () {
    (new Unit(5, new UnitOfMeasurement('m')))->add(new Unit(5, new UnitOfMeasurement('kg')));
})->throws(IncompatibleUnitOfMeasurementException::class);

it('multiplies and divides with rounding', function () {
    $m = new UnitOfMeasurement('m');

    expect((new Unit(5, $m))->multiply('1.5')->getAmount())->toBe('8')
        ->and((new Unit(5, $m))->multiply('1.5', PHP_ROUND_HALF_DOWN)->getAmount())->toBe('7')
        ->and((new Unit(10, $m))->divide(4)->getAmount())->toBe('3')
        ->and((new Unit(10, $m))->divide(4, PHP_ROUND_HALF_EVEN)->getAmount())->toBe('2');
});

it('rejects division by zero and non-numeric operands', function (string $operand) {
    (new Unit(5, new UnitOfMeasurement('m')))->divide($operand);
})->with(['0', 'abc'])->throws(InvalidArgumentException::class);

it('compares units', function () {
    $m = new UnitOfMeasurement('m');
    $five = new Unit(5, $m);

    expect($five->equals(new Unit(5, $m)))->toBeTrue()
        ->and($five->equals(new Unit(5, new UnitOfMeasurement('kg'))))->toBeFalse()
        ->and($five->lessThan(new Unit(6, $m)))->toBeTrue()
        ->and($five->greaterThanOrEqual(new Unit(6, $m)))->toBeFalse()
        ->and($m->zero()->isZero())->toBeTrue()
        ->and((new Unit(-1, $m))->isNegative())->toBeTrue()
        ->and($five->isPositive())->toBeTrue();
});

it('computes mod, absolute and negative', function () {
    $m = new UnitOfMeasurement('m');

    expect((new Unit(10, $m))->mod(new Unit(3, $m))->getAmount())->toBe('1')
        ->and((new Unit(-4, $m))->absolute()->getAmount())->toBe('4')
        ->and((new Unit(4, $m))->negative()->getAmount())->toBe('-4')
        ->and($m->zero()->negative()->getAmount())->toBe('0');
});

it('uses the registered calculator', function () {
    Unit::registerCalculator(BcMathCalculator::class);

    expect(Unit::getCalculator())->toBe(BcMathCalculator::class);
});

it('rejects calculators that do not implement the contract', function () {
    Unit::registerCalculator(stdClass::class);
})->throws(InvalidArgumentException::class);
