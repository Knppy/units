<?php

use Knppy\Units\Exception\IncompatibleUnitOfMeasurementException;
use Knppy\Units\Exception\InexactConversionException;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Unit;
use Knppy\Units\UnitConverter;
use Knppy\Units\UnitOfMeasurement;

function convertTo(string $amount, string $from, string $to): string
{
    return (new UnitConverter)->convert(new Unit($amount, new UnitOfMeasurement($from)), new UnitOfMeasurement($to))->getAmount();
}

it('converts to a whole number', function (string $amount, string $from, string $to, string $expected) {
    expect(convertTo($amount, $from, $to))->toBe($expected);
})->with([
    ['1', 'km', 'm', '1000'],
    ['5000', 'mm', 'm', '5'],
    ['-5000', 'mm', 'm', '-5'],
    ['0', 'km', 'mm', '0'],
    ['7', 'm', 'm', '7'],
    ['1', 'dam', 'm', '10'],
    ['2', 'kg', 'g', '2000'],
    ['2000', 'g', 'kg', '2'],
    ['1', 'mg', 'ng', '1000000'],
    ['1', 'kg', 'mg', '1000000'],
    ['1', 'Qm', 'qm', '1'.str_repeat('0', 60)],
    ['1'.str_repeat('0', 60), 'qm', 'Qm', '1'],
    ['3', 'µs', 'ns', '3000'],
    ['2', 'kPa', 'Pa', '2000'],
    ['2', 'T', 'mT', '2000'],
]);

it('converts to an exact decimal', function (string $amount, string $from, string $to, string $expected) {
    $unit = new Unit($amount, new UnitOfMeasurement($from));

    expect((new UnitConverter)->convertToDecimal($unit, new UnitOfMeasurement($to)))->toBe($expected);
})->with([
    ['1', 'm', 'km', '0.001'],
    ['1', 'g', 'kg', '0.001'],
    ['-1500', 'm', 'km', '-1.5'],
    ['1500', 'm', 'km', '1.5'],
    ['1', 'qm', 'Qm', '0.'.str_repeat('0', 59).'1'],
    ['1', 'km', 'm', '1000'],
]);

it('throws when the result is not a whole number', function () {
    convertTo('1', 'm', 'km');
})->throws(InexactConversionException::class);

it('throws for different base units', function () {
    convertTo('1', 'm', 's');
})->throws(IncompatibleUnitOfMeasurementException::class);

it('throws for unknown units', function (string $symbol) {
    convertTo('1', $symbol, 'm');
})->with(['foo', 'k', 'm°C', 'mkg', 'x'])->throws(UnknownUnitOfMeasurementException::class);

it('does not read the metre as milli', function () {
    expect(convertTo('1', 'm', 'm'))->toBe('1');
});

it('converts through the unit', function () {
    $unit = new Unit(5, new UnitOfMeasurement('km'))->convertTo(new UnitOfMeasurement('m'));

    expect($unit->getAmount())->toBe('5000')
        ->and($unit->getUnitOfMeasurement()->getSymbol())->toBe('m');
});
