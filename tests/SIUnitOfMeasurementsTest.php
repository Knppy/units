<?php

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Quantity;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\SIUnitOfMeasurements;

it('knows SI units', function () {
    $si = new SIUnitOfMeasurements;

    expect($si->contains(new UnitOfMeasurement('m')))->toBeTrue()
        ->and($si->contains(new UnitOfMeasurement('Pa')))->toBeTrue()
        ->and($si->contains(new UnitOfMeasurement('foo')))->toBeFalse();
});

it('provides name and quantity', function () {
    $si = new SIUnitOfMeasurements;
    $kg = new UnitOfMeasurement('kg');

    expect($si->nameFor($kg))->toBe('kilogram')
        ->and($si->quantityFor($kg))->toBe(Quantity::Mass);
});

it('throws for unknown units', function () {
    (new SIUnitOfMeasurements)->nameFor(new UnitOfMeasurement('foo'));
})->throws(UnknownUnitOfMeasurementException::class);

it('iterates all 29 units', function () {
    $units = iterator_to_array(new SIUnitOfMeasurements);

    expect($units)->toHaveCount(29)
        ->and($units[0])->toBeInstanceOf(UnitOfMeasurement::class);
});
