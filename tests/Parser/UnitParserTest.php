<?php

use Knppy\Units\Exception\ParserException;
use Knppy\Units\Parser\AggregateUnitParser;
use Knppy\Units\Parser\LocalizedUnitParser;
use Knppy\Units\Parser\SymbolUnitParser;
use Knppy\Units\UnitNames\CookingUnitNames;
use Knppy\Units\UnitNames\SIUnitNames;
use Knppy\Units\UnitOfMeasurement;

it('parses an amount and a symbol', function (string $input, string $amount, string $symbol) {
    $unit = (new SymbolUnitParser)->parse($input);

    expect($unit->getAmount())->toBe($amount)
        ->and($unit->getUnitOfMeasurement()->getSymbol())->toBe($symbol);
})->with([
    ['5 kg', '5', 'kg'],
    ['5kg', '5', 'kg'],
    ['  -3  m ', '-3', 'm'],
    ['+7 Pa', '7', 'Pa'],
    ['20 °C', '20', '°C'],
]);

it('uses the fallback unit of measurement when there is none', function () {
    $unit = (new SymbolUnitParser)->parse('5', new UnitOfMeasurement('m'));

    expect($unit->getUnitOfMeasurement()->getSymbol())->toBe('m');
});

it('rejects input without a unit of measurement or amount', function (string $input) {
    (new SymbolUnitParser)->parse($input);
})->with(['5', '', 'kg', '1.5 kg'])->throws(ParserException::class);

it('parses localized names', function () {
    $parser = new LocalizedUnitParser(new CookingUnitNames, 'nl');

    expect($parser->parse('2 theelepels')->getUnitOfMeasurement()->getSymbol())->toBe('tsp')
        ->and($parser->parse('3 tl')->getAmount())->toBe('3');
});

it('rejects unknown localized names', function () {
    (new LocalizedUnitParser(new CookingUnitNames, 'nl'))->parse('2 bananen');
})->throws(ParserException::class);

it('parses prefixed localized names', function () {
    $unit = (new LocalizedUnitParser(new SIUnitNames, 'de'))->parse('4 Zentimeter');

    expect($unit->getUnitOfMeasurement()->getSymbol())->toBe('cm');
});

it('falls through the aggregated parsers', function () {
    $parser = new AggregateUnitParser([
        new LocalizedUnitParser(new CookingUnitNames, 'nl'),
        new SymbolUnitParser,
    ]);

    expect($parser->parse('2 theelepels')->getUnitOfMeasurement()->getSymbol())->toBe('tsp')
        ->and($parser->parse('5 widgets')->getUnitOfMeasurement()->getSymbol())->toBe('widgets');
});

it('throws when no aggregated parser matches', function () {
    (new AggregateUnitParser([new SymbolUnitParser]))->parse('nope');
})->throws(ParserException::class);
