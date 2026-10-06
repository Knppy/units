<?php

use Knppy\Units\Exception\FormatterException;
use Knppy\Units\Formatter\AggregateUnitFormatter;
use Knppy\Units\Formatter\DecimalUnitFormatter;
use Knppy\Units\Formatter\LocalizedUnitFormatter;
use Knppy\Units\Formatter\SymbolUnitFormatter;
use Knppy\Units\Parser\LocalizedUnitParser;
use Knppy\Units\Parser\SymbolUnitParser;
use Knppy\Units\Unit;
use Knppy\Units\UnitNames\CookingUnitNames;
use Knppy\Units\UnitNames\SIUnitNames;
use Knppy\Units\UnitOfMeasurement;

it('formats only the amount', function () {
    expect((new DecimalUnitFormatter)->format(new Unit(-1500, new UnitOfMeasurement('m'))))->toBe('-1500');
});

it('formats an amount and a symbol', function () {
    $unit = new Unit(5, new UnitOfMeasurement('kg'));

    expect((new SymbolUnitFormatter)->format($unit))->toBe('5 kg')
        ->and((new SymbolUnitFormatter("\u{00A0}"))->format($unit))->toBe("5\u{00A0}kg")
        ->and((new SymbolUnitFormatter)->format(new Unit(20, new UnitOfMeasurement('°C'))))->toBe('20 °C');
});

it('round trips with the symbol parser', function () {
    $unit = (new SymbolUnitParser)->parse('-3 m');

    expect((new SymbolUnitFormatter)->format($unit))->toBe('-3 m');
});

it('formats localized names with the plural form of the amount', function (int|string $amount, string $locale, string $expected) {
    $formatter = new LocalizedUnitFormatter(new CookingUnitNames, $locale);

    expect($formatter->format(new Unit($amount, new UnitOfMeasurement('tsp'))))->toBe($expected);
})->with([
    [1, 'nl', '1 theelepel'],
    [2, 'nl', '2 theelepels'],
    [1500, 'nl', '1.500 theelepels'],
    [1500, 'en', '1,500 teaspoons'],
]);

it('formats localized SI names', function () {
    $formatter = new LocalizedUnitFormatter(new SIUnitNames, 'de');

    expect($formatter->format(new Unit(2, new UnitOfMeasurement('km'))))->toBe('2 Kilometer');
});

it('can skip grouping and use symbols', function () {
    $unit = new Unit(1500, new UnitOfMeasurement('tsp'));

    expect((new LocalizedUnitFormatter(new CookingUnitNames, 'nl', grouping: false))->format($unit))->toBe('1500 theelepels')
        ->and((new LocalizedUnitFormatter(new CookingUnitNames, 'nl', useName: false))->format($unit))->toBe('1.500 tsp');
});

it('keeps every digit of amounts beyond the integer range', function () {
    $unit = new Unit('-123456789012345678901234567890', new UnitOfMeasurement('m'));

    expect((new LocalizedUnitFormatter(new SIUnitNames, 'en', useName: false))->format($unit))
        ->toBe('-123,456,789,012,345,678,901,234,567,890 m');
});

it('round trips with the localized parser', function () {
    $parser = new LocalizedUnitParser(new CookingUnitNames, 'nl');
    $formatter = new LocalizedUnitFormatter(new CookingUnitNames, 'nl', grouping: false);

    expect($formatter->format($parser->parse('2 theelepels')))->toBe('2 theelepels');
});

it('formats with the formatter registered for the symbol', function () {
    $formatter = new AggregateUnitFormatter(
        ['tsp' => new LocalizedUnitFormatter(new CookingUnitNames, 'nl')],
        new SymbolUnitFormatter,
    );

    expect($formatter->format(new Unit(2, new UnitOfMeasurement('tsp'))))->toBe('2 theelepels')
        ->and($formatter->format(new Unit(2, new UnitOfMeasurement('kg'))))->toBe('2 kg');
});

it('throws when no formatter is registered for the symbol', function () {
    (new AggregateUnitFormatter(['tsp' => new DecimalUnitFormatter]))->format(new Unit(2, new UnitOfMeasurement('kg')));
})->throws(FormatterException::class);
