<?php

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
