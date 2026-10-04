<?php

use Knppy\Units\Converter\CookingUnitConverter;
use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\InexactConversionException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

function convertCooking(string $amount, string $from, string $to): string
{
    return (new CookingUnitConverter)->convert(new Unit($amount, new UnitOfMeasurement($from)), new UnitOfMeasurement($to))->getAmount();
}

it('converts to a whole number', function (string $amount, string $from, string $to, string $expected) {
    expect(convertCooking($amount, $from, $to))->toBe($expected);
})->with([
    ['1', 'tbsp', 'tsp', '3'],
    ['2', 'cup', 'fl oz', '16'],
    ['1', 'gal', 'qt', '4'],
    ['1', 'gal', 'pt', '8'],
    ['1', 'qt', 'pt', '2'],
    ['2', 'l', 'ml', '2000'],
    ['1', 'lb', 'oz', '16'],
    ['1', 'tbsp', 'tbsp', '1'],
    ['0', 'cup', 'ml', '0'],
    ['-3', 'tsp', 'tbsp', '-1'],
    ['3', 'pinch', 'pinch', '3'],
]);

it('converts to an exact decimal', function (string $amount, string $from, string $to, string $expected) {
    $unit = new Unit($amount, new UnitOfMeasurement($from));

    expect((new CookingUnitConverter)->convertToDecimal($unit, new UnitOfMeasurement($to)))->toBe($expected);
})->with([
    ['1', 'tsp', 'ml', '4.92892159375'],
    ['1', 'oz', 'g', '28.349523125'],
    ['1', 'lb', 'g', '453.59237'],
    ['1', 'cup', 'ml', '236.5882365'],
    ['1', 'oz', 'lb', '0.0625'],
]);

it('throws when the result is not a whole number', function () {
    convertCooking('1', 'tsp', 'ml');
})->throws(InexactConversionException::class);

it('throws for different quantities', function () {
    convertCooking('1', 'cup', 'oz');
})->throws(IncompatibleUnitOfMeasurementException::class);

it('throws for units without a fixed size', function (string $from, string $to) {
    convertCooking('1', $from, $to);
})->with([['pinch', 'tsp'], ['tsp', 'pinch'], ['pinch', 'dash'], ['clove', 'piece']])->throws(IncompatibleUnitOfMeasurementException::class);

it('throws for unknown units', function () {
    convertCooking('1', 'foo', 'tsp');
})->throws(UnknownUnitOfMeasurementException::class);

it('converts through the unit with the cooking converter', function () {
    $unit = (new Unit(1, new UnitOfMeasurement('tbsp')))->convertTo(new UnitOfMeasurement('tsp'), new CookingUnitConverter);

    expect($unit->getAmount())->toBe('3')
        ->and($unit->getUnitOfMeasurement()->getSymbol())->toBe('tsp');
});
