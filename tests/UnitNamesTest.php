<?php

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Prefix;
use Knppy\Units\Unit;
use Knppy\Units\UnitNames\CookingUnitNames;
use Knppy\Units\UnitNames\LocaleHelper;
use Knppy\Units\UnitNames\PrefixNames;
use Knppy\Units\UnitNames\SIUnitNames;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\CookingUnitOfMeasurements;
use Knppy\Units\UnitOfMeasurements\SIUnitOfMeasurements;

const LOCALES = ['en', 'nl', 'de', 'fr', 'es', 'pt', 'zh', 'ja', 'ru', 'hi', 'ar'];

it('provides localized names', function (string $locale, string $symbol, string $one, string $other) {
    $names = new CookingUnitNames;
    $unit = new UnitOfMeasurement($symbol);

    expect($names->nameFor($unit, $locale))->toBe($one)
        ->and($names->nameFor($unit, $locale, 2))->toBe($other);
})->with([
    ['en', 'tsp', 'teaspoon', 'teaspoons'],
    ['nl', 'tsp', 'theelepel', 'theelepels'],
    ['de', 'tbsp', 'Esslöffel', 'Esslöffel'],
    ['fr', 'clove', 'gousse', 'gousses'],
    ['es', 'tsp', 'cucharadita', 'cucharaditas'],
    ['zh', 'tsp', '茶匙', '茶匙'],
]);

it('parses localized names, plurals, aliases and symbols', function (string $locale, string $input, string $symbol) {
    expect((new CookingUnitNames)->parse($input, $locale)->getSymbol())->toBe($symbol);
})->with([
    ['nl', 'theelepel', 'tsp'],
    ['nl', 'Theelepels', 'tsp'],
    ['nl', 'tl', 'tsp'],
    ['nl', 'TL.', 'tsp'],
    ['nl', '  snufje ', 'pinch'],
    ['de', 'EL', 'tbsp'],
    ['fr', 'cuillère  à soupe', 'tbsp'],
    ['es', 'cucharadita', 'tsp'],
    ['zh', '茶匙', 'tsp'],
    ['en', 'liters', 'l'],
    ['nl', 'tsp', 'tsp'],
    ['nl', 'g', 'g'],
]);

it('matches symbols case-sensitively before names', function () {
    $si = new SIUnitNames;

    expect($si->parse('Pa', 'en')->getSymbol())->toBe('Pa')
        ->and($si->parse('pascal', 'en')->getSymbol())->toBe('Pa')
        ->and($si->parse('°C', 'nl')->getSymbol())->toBe('°C')
        ->and($si->parse('graad Celsius', 'nl')->getSymbol())->toBe('°C');
});

it('accepts region tags and underscores', function () {
    $names = new CookingUnitNames;

    expect($names->nameFor(new UnitOfMeasurement('tsp'), 'nl_NL'))->toBe('theelepel')
        ->and($names->parse('theelepel', 'nl-BE')->getSymbol())->toBe('tsp');
});

it('falls back to English for unsupported locales and missing units', function () {
    $names = new CookingUnitNames;
    $si = new SIUnitNames;

    expect($names->nameFor(new UnitOfMeasurement('tsp'), 'xx'))->toBe('teaspoon')
        ->and($names->nameFor(new UnitOfMeasurement('tsp'), '../etc'))->toBe('teaspoon')
        ->and($si->nameFor(new UnitOfMeasurement('Bq'), 'nl'))->toBe('becquerel')
        ->and($si->parse('becquerels', 'nl')->getSymbol())->toBe('Bq');
});

it('throws for unknown units and input', function () {
    expect(fn () => (new CookingUnitNames)->nameFor(new UnitOfMeasurement('m'), 'en'))
        ->toThrow(UnknownUnitOfMeasurementException::class)
        ->and(fn () => (new CookingUnitNames)->parse('foo', 'nl'))
        ->toThrow(UnknownUnitOfMeasurementException::class);
});

describe('locale data', function () {
    $systems = [
        'si' => [new SIUnitOfMeasurements, 'si.php'],
        'cooking' => [new CookingUnitOfMeasurements, 'cooking.php'],
    ];

    foreach ($systems as $system => [$unitOfMeasurements, $file]) {
        foreach (LOCALES as $locale) {
            $path = __DIR__.'/../resources/locales/'.$locale.'/'.$file;

            it("is valid for $system/$locale", function () use ($unitOfMeasurements, $locale, $path) {
                $data = require $path;
                $symbols = array_map(fn ($unit) => $unit->getSymbol(), iterator_to_array($unitOfMeasurements));

                expect(array_diff(array_map('strval', array_keys($data)), $symbols))->toBe([]);

                $seen = [];
                foreach ($data as $symbol => $names) {
                    expect($names['one'])->toBeString()->not->toBeEmpty()
                        ->and($names['other'])->toBeString()->not->toBeEmpty()
                        ->and(array_diff(array_keys($names), [...LocaleHelper::CATEGORIES, 'aliases', 'prefixed']))->toBe([]);

                    foreach (LocaleHelper::forms($names) as $name) {
                        $key = rtrim(mb_strtolower($name), '.');
                        expect($seen[$key] ?? $symbol)->toBe($symbol, "$key is ambiguous in $locale");
                        $seen[$key] = $symbol;
                    }
                }
            });
        }
    }

    foreach (LOCALES as $locale) {
        it("names every cooking unit in $locale", function () use ($locale) {
            $data = require __DIR__.'/../resources/locales/'.$locale.'/cooking.php';
            $symbols = array_map(fn ($unit) => $unit->getSymbol(), iterator_to_array(new CookingUnitOfMeasurements));

            expect(array_diff($symbols, array_map('strval', array_keys($data))))->toBe([]);
        });
    }
});

describe('prefix names', function () {
    it('provides localized prefix names', function (string $locale, Prefix $prefix, string $name) {
        expect((new PrefixNames)->nameFor($prefix, $locale))->toBe($name);
    })->with([
        ['en', Prefix::Kilo, 'kilo'],
        ['de', Prefix::Centi, 'zenti'],
        ['fr', Prefix::Mega, 'méga'],
        ['es', Prefix::Milli, 'mili'],
        ['zh', Prefix::Kilo, '千'],
        ['ru', Prefix::Micro, 'микро'],
        ['xx', Prefix::Nano, 'nano'],
    ]);

    it('parses localized prefix names, aliases and symbols', function (string $locale, string $input, Prefix $prefix) {
        expect((new PrefixNames)->parse($input, $locale))->toBe($prefix);
    })->with([
        ['de', 'Zenti', Prefix::Centi],
        ['de', 'centi', Prefix::Centi],
        ['fr', 'mega', Prefix::Mega],
        ['nl', 'deka', Prefix::Deca],
        ['en', 'µ', Prefix::Micro],
        ['en', 'da', Prefix::Deca],
    ]);

    it('throws for unknown prefixes', function () {
        (new PrefixNames)->parse('foo', 'en');
    })->throws(UnknownUnitOfMeasurementException::class);

    foreach (LOCALES as $locale) {
        it("names every prefix once in $locale", function () use ($locale) {
            $data = require __DIR__.'/../resources/locales/'.$locale.'/prefixes.php';
            $names = array_merge(...array_values(array_map(fn ($entry) => [$entry['name'], ...($entry['aliases'] ?? [])], $data)));

            expect(array_keys($data))->toBe(array_map(fn (Prefix $p) => $p->getSymbol(), Prefix::cases()))
                ->and($names)->toBe(array_values(array_unique($names)));
        });
    }
});

describe('prefixed units', function () {
    it('names prefixed units', function (string $locale, string $symbol, int $count, string $name) {
        expect((new SIUnitNames)->nameFor(new UnitOfMeasurement($symbol), $locale, $count))->toBe($name);
    })->with([
        ['en', 'km', 1, 'kilometre'],
        ['en', 'mg', 5, 'milligrams'],
        ['en', 'µs', 1, 'microsecond'],
        ['nl', 'km', 1, 'kilometer'],
        ['de', 'cm', 1, 'Zentimeter'],
        ['de', 'mg', 1, 'Milligramm'],
        ['fr', 'mm', 5, 'millimètres'],
        ['es', 'km', 1, 'kilómetro'],
        ['es', 'mA', 5, 'miliamperios'],
        ['pt', 'cm', 1, 'centímetro'],
        ['ru', 'km', 1, 'километр'],
        ['zh', 'km', 1, '千米'],
        ['ja', 'mm', 1, 'ミリメートル'],
        ['ar', 'km', 5, 'كيلومترات'],
    ]);

    it('parses prefixed names and symbols', function (string $locale, string $input, string $symbol) {
        expect((new SIUnitNames)->parse($input, $locale)->getSymbol())->toBe($symbol);
    })->with([
        ['en', 'kilometers', 'km'],
        ['en', 'Millimetre', 'mm'],
        ['en', 'milligram', 'mg'],
        ['en', 'kilogram', 'kg'],
        ['en', 'km', 'km'],
        ['en', 'µs', 'µs'],
        ['de', 'Zentimeter', 'cm'],
        ['de', 'Kilometer', 'km'],
        ['es', 'kilómetro', 'km'],
        ['es', 'kilometro', 'km'],
        ['pt', 'quilômetros', 'km'],
        ['fr', 'kilomètre', 'km'],
        ['ru', 'миллиграмм', 'mg'],
        ['zh', '毫克', 'mg'],
        ['zh', '千米', 'km'],
        ['nl', 'milliseconde', 'ms'],
        ['en', 'nanosecond', 'ns'],
    ]);

    it('does not prefix units that cannot take a prefix', function (string $input) {
        (new SIUnitNames)->parse($input, 'en');
    })->with(['millidegree Celsius', 'millikilogram', 'mkg', 'm°C'])
        ->throws(UnknownUnitOfMeasurementException::class);

    it('throws for unknown prefixed symbols', function () {
        (new SIUnitNames)->nameFor(new UnitOfMeasurement('kfoo'), 'en');
    })->throws(UnknownUnitOfMeasurementException::class);

    it('lists prefixed names only for known prefixed symbols', function () {
        foreach (['es', 'pt', 'pt-pt'] as $locale) {
            $data = require __DIR__.'/../resources/locales/'.$locale.'/si-prefixed.php';
            $names = new SIUnitNames;

            foreach (array_keys($data) as $symbol) {
                expect($names->parse((string) $symbol, $locale)->getSymbol())->toBe($symbol);
            }
        }
    });
});

describe('plural forms', function () {
    it('selects the plural form by count', function (string $locale, string $symbol, int|string $count, string $name) {
        expect((new CookingUnitNames)->nameFor(new UnitOfMeasurement($symbol), $locale, $count))->toBe($name);
    })->with([
        ['en', 'cup', 1, 'cup'],
        ['en', 'cup', 0, 'cups'],
        ['en', 'cup', '2', 'cups'],
        ['fr', 'cup', 0, 'tasse'],
        ['ru', 'tsp', 1, 'чайная ложка'],
        ['ru', 'tsp', 2, 'чайные ложки'],
        ['ru', 'tsp', 5, 'чайных ложек'],
        ['ru', 'tsp', 11, 'чайных ложек'],
        ['ru', 'tsp', 21, 'чайная ложка'],
        ['ru', 'tsp', 22, 'чайные ложки'],
        ['ru', 'tsp', '1000000000000000000000021', 'чайная ложка'],
        ['ar', 'cup', 0, 'أكواب'],
        ['ar', 'cup', 1, 'كوب'],
        ['ar', 'cup', 2, 'كوبان'],
        ['ar', 'cup', 5, 'أكواب'],
        ['ar', 'cup', 11, 'كوب'],
        ['ar', 'cup', 100, 'كوب'],
        ['zh', 'cup', 5, '杯'],
    ]);

    it('uses the unit amount as count', function () {
        $unit = new Unit(22, new UnitOfMeasurement('tsp'));

        expect((new CookingUnitNames)->nameFor($unit->getUnitOfMeasurement(), 'ru', $unit->getAmount()))
            ->toBe('чайные ложки');
    });

    it('uses the plural rules of the requested locale, not the fallback', function () {
        // "Bq" has no Russian entry, so the English name is used; Russian "few" falls back to English "other".
        expect((new SIUnitNames)->nameFor(new UnitOfMeasurement('Bq'), 'ru', 3))->toBe('becquerels');
    });
});

describe('prefixed forms', function () {
    it('uses the forms meant for use after a prefix', function () {
        $si = new SIUnitNames;

        expect($si->nameFor(new UnitOfMeasurement('m'), 'ar', 5))->toBe('أمتار')
            ->and($si->nameFor(new UnitOfMeasurement('km'), 'ar', 5))->toBe('كيلومترات')
            ->and($si->nameFor(new UnitOfMeasurement('km'), 'ar', 2))->toBe('كيلومتران')
            ->and($si->nameFor(new UnitOfMeasurement('ms'), 'ar', 5))->toBe('ميلي ثانية');
    });

    it('parses prefixed names with and without the separator', function () {
        $si = new SIUnitNames;

        expect($si->parse('ميلي ثانية', 'ar')->getSymbol())->toBe('ms')
            ->and($si->parse('ميليثانية', 'ar')->getSymbol())->toBe('ms')
            ->and($si->parse('كيلومترات', 'ar')->getSymbol())->toBe('km');
    });

    it('prefers the European Portuguese spelling for pt-PT', function () {
        $si = new SIUnitNames;

        expect($si->nameFor(new UnitOfMeasurement('km'), 'pt'))->toBe('quilômetro')
            ->and($si->nameFor(new UnitOfMeasurement('km'), 'pt-PT'))->toBe('quilómetro')
            ->and($si->nameFor(new UnitOfMeasurement('km'), 'pt_BR'))->toBe('quilômetro')
            ->and($si->parse('quilómetros', 'pt-PT')->getSymbol())->toBe('km')
            ->and($si->parse('quilômetros', 'pt-PT')->getSymbol())->toBe('km');
    });
});
