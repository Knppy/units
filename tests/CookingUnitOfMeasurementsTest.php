<?php

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Quantity;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\CookingUnitOfMeasurements;

it('knows cooking units', function () {
    $cooking = new CookingUnitOfMeasurements;

    expect($cooking->contains(new UnitOfMeasurement('tsp')))->toBeTrue()
        ->and($cooking->contains(new UnitOfMeasurement('pinch')))->toBeTrue()
        ->and($cooking->contains(new UnitOfMeasurement('m')))->toBeFalse();
});

it('provides name and quantity', function () {
    $cooking = new CookingUnitOfMeasurements;
    $pinch = new UnitOfMeasurement('pinch');
    $tbsp = new UnitOfMeasurement('tbsp');

    expect($cooking->nameFor($pinch))->toBe('pinch')
        ->and($cooking->quantityFor($pinch))->toBe(Quantity::ImpreciseAmount)
        ->and($cooking->nameFor($tbsp))->toBe('tablespoon')
        ->and($cooking->quantityFor($tbsp))->toBe(Quantity::Volume);
});

it('provides a ratio only for units with a fixed size', function () {
    $cooking = new CookingUnitOfMeasurements;

    expect($cooking->ratioFor(new UnitOfMeasurement('lb')))->toBe('453.59237')
        ->and($cooking->ratioFor(new UnitOfMeasurement('pinch')))->toBeNull();
});

it('throws for unknown units', function () {
    (new CookingUnitOfMeasurements)->nameFor(new UnitOfMeasurement('foo'));
})->throws(UnknownUnitOfMeasurementException::class);

it('iterates all 26 units', function () {
    expect(iterator_to_array(new CookingUnitOfMeasurements))->toHaveCount(26);
});
