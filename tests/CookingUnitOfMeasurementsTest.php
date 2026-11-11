<?php

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Quantity;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\CookingUnitOfMeasurements;
use Knppy\Units\UnitOfMeasurements\MetricCookingUnitOfMeasurements;

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

it('iterates all 30 units', function () {
    expect(iterator_to_array(new CookingUnitOfMeasurements))->toHaveCount(30);
});

it('has metric spoons and cups in the metric list only', function () {
    $us = new CookingUnitOfMeasurements;
    $metric = new MetricCookingUnitOfMeasurements;

    expect($us->ratioFor(new UnitOfMeasurement('tbsp')))->toBe('14.78676478125')
        ->and($metric->ratioFor(new UnitOfMeasurement('tbsp')))->toBe('15')
        ->and($metric->ratioFor(new UnitOfMeasurement('tsp')))->toBe('5')
        ->and($metric->ratioFor(new UnitOfMeasurement('cup')))->toBe('250')
        ->and($metric->ratioFor(new UnitOfMeasurement('lb')))->toBe($us->ratioFor(new UnitOfMeasurement('lb')))
        ->and(iterator_to_array($metric))->toHaveCount(30);
});

it('knows the kitchen units of the metric system', function () {
    $cooking = new CookingUnitOfMeasurements;

    expect($cooking->ratioFor(new UnitOfMeasurement('kg')))->toBe('1000')
        ->and($cooking->ratioFor(new UnitOfMeasurement('dl')))->toBe('100')
        ->and($cooking->quantityFor(new UnitOfMeasurement('cm')))->toBe(Quantity::Length)
        ->and($cooking->quantityFor(new UnitOfMeasurement('to taste')))->toBe(Quantity::ImpreciseAmount);
});
