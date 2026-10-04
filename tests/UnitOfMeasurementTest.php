<?php

use Knppy\Units\Exception\InvalidUnitOfMeasurementException;
use Knppy\Units\UnitOfMeasurement;

it('keeps the case of the symbol', function () {
    expect((new UnitOfMeasurement('Pa'))->getSymbol())->toBe('Pa')
        ->and((string) new UnitOfMeasurement('mol'))->toBe('mol');
});

it('compares by symbol', function () {
    expect((new UnitOfMeasurement('m'))->equals(new UnitOfMeasurement('m')))->toBeTrue()
        ->and((new UnitOfMeasurement('m'))->equals(new UnitOfMeasurement('M')))->toBeFalse();
});

it('serializes to json', function () {
    expect(json_encode(new UnitOfMeasurement('kg')))->toBe('"kg"');
});

it('rejects an empty symbol', function () {
    new UnitOfMeasurement('');
})->throws(InvalidUnitOfMeasurementException::class);

it('creates a zero unit', function () {
    $zero = (new UnitOfMeasurement('s'))->zero();

    expect($zero->getAmount())->toBe('0')
        ->and($zero->getUnitOfMeasurement()->getSymbol())->toBe('s');
});
