<div align="center">
    <h1>Units</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/knppy/units"><img src="https://img.shields.io/packagist/v/knppy/units.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/knppy/units"><img src="https://img.shields.io/packagist/php-v/knppy/units.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://github.com/knppy/units/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/actions/workflow/status/knppy/units/tests.yml?branch=master&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/knppy/units"><img src="https://img.shields.io/packagist/dt/knppy/units.svg?style=flat-square" alt="Total Downloads"></a>
</p>

Knppy units is a PHP library to make working with units safer, easier, and fun!

## Installation

You can install the package via Composer:

```bash
composer require knppy/units
```

## Usage

```php
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\SIUnitOfMeasurements;

$kilogram = new UnitOfMeasurement('kg');
$weight = new Unit(100, $kilogram);

$si = new SIUnitOfMeasurements();
$si->contains($kilogram);    // true
$si->nameFor($kilogram);     // "kilogram"
$si->quantityFor($kilogram); // "mass"
```

Lists implement `Knppy\Units\Contract\UnitOfMeasurements`, so other lists can be added alongside the International
System of Units. `CookingUnitOfMeasurements` covers cooking: volumes (`tsp`, `tbsp`, `cup`, ...), masses (`oz`, `lb`),
counts (`clove`, `slice`, ...) and imprecise amounts (`pinch`, `dash`, `handful`, ...).

```php
use Knppy\Units\UnitOfMeasurements\CookingUnitOfMeasurements;

$cooking = new CookingUnitOfMeasurements();
$cooking->nameFor(new UnitOfMeasurement('pinch'));    // "pinch"
$cooking->quantityFor(new UnitOfMeasurement('tsp'));  // "volume"
```

## Conversion

Each system of units has its own converter implementing `Knppy\Units\Contract\UnitConverter`. `convertTo()` uses the
`SIUnitConverter` by default; pass another converter as the second argument.

All 24 SI prefixes (quecto to quetta) are supported through the `Prefix` enum and the `SIUnitConverter`:

```php
use Knppy\Units\Converter\SIUnitConverter;

$km = new Unit(5, new UnitOfMeasurement('km'));

$km->convertTo(new UnitOfMeasurement('m'));   // 5000 m
$km->convertTo(new UnitOfMeasurement('mm'));  // 5000000 mm

$m = new Unit(1, new UnitOfMeasurement('m'));
$m->convertTo(new UnitOfMeasurement('km'));   // throws InexactConversionException, 0.001 is not a whole number
(new SIUnitConverter)->convertToDecimal($m, new UnitOfMeasurement('km')); // "0.001"
```

Amounts are whole numbers, so `convert()` throws when the result would have decimals. Use `convertToDecimal()` for an
exact decimal string instead. Masses can be prefixed grams (`mg`) even though the SI base unit is the kilogram.

### Cooking

The `CookingUnitConverter` converts volumes and masses using exact US customary ratios:

```php
use Knppy\Units\Converter\CookingUnitConverter;

$cooking = new CookingUnitConverter();

(new Unit(1, new UnitOfMeasurement('tbsp')))->convertTo(new UnitOfMeasurement('tsp'), $cooking); // 3 tsp
(new Unit(1, new UnitOfMeasurement('lb')))->convertTo(new UnitOfMeasurement('oz'), $cooking);    // 16 oz
$cooking->convertToDecimal(new Unit(1, new UnitOfMeasurement('oz')), new UnitOfMeasurement('g')); // "28.349523125"
```

Units without a fixed size, such as a `pinch` or a `clove`, cannot be converted to another unit and throw an
`IncompatibleUnitOfMeasurementException`.

## Languages

Unit names can be localized and localized input can be parsed back to a unit. The symbol stays the canonical identifier, so conversion and `equals` are unaffected.

```php
use Knppy\Units\UnitNames\CookingUnitNames;
use Knppy\Units\UnitOfMeasurement;

$names = new CookingUnitNames;

$names->nameFor(new UnitOfMeasurement('tsp'), 'nl');              // theelepel
$names->nameFor(new UnitOfMeasurement('tsp'), 'nl', 2);            // theelepels
$names->parse('Theelepels', 'nl');                                // UnitOfMeasurement('tsp')
$names->parse('tl', 'nl');                                        // UnitOfMeasurement('tsp')
```

The count picks the plural form by the CLDR rules of the locale (via `ext-intl`), so languages with more than two forms work. Pass a unit's amount directly:

```php
$names->nameFor(new UnitOfMeasurement('tsp'), 'ru', 1);   // чайная ложка
$names->nameFor(new UnitOfMeasurement('tsp'), 'ru', 22);  // чайные ложки
$names->nameFor(new UnitOfMeasurement('tsp'), 'ru', 5);   // чайных ложек
$names->nameFor($unit->getUnitOfMeasurement(), 'ar', $unit->getAmount());
```

Symbols are matched first (case-sensitive), then names, plurals and aliases (case-insensitive). Unsupported locales and missing units fall back to English. `SIUnitNames` does the same for SI units.

Available locales: `en`, `nl`, `de`, `fr`, `es`, `pt`, `zh`, `ja`, `ru`, `hi`, `ar`. Quantity labels are not localized yet. Requires `ext-intl` and `ext-mbstring`.

### Prefixes

`SIUnitNames` also names and parses prefixed units, composing them from the prefix and the unit name:

```php
use Knppy\Units\Prefix;
use Knppy\Units\UnitNames\PrefixNames;
use Knppy\Units\UnitNames\SIUnitNames;

$si = new SIUnitNames;

$si->nameFor(new UnitOfMeasurement('cm'), 'de');  // Zentimeter
$si->nameFor(new UnitOfMeasurement('km'), 'es');  // kilómetro
$si->parse('milligramm', 'de');                   // UnitOfMeasurement('mg')
$si->parse('千米', 'zh');                          // UnitOfMeasurement('km')

(new PrefixNames)->nameFor(Prefix::Centi, 'de');  // zenti
(new PrefixNames)->parse('Zenti', 'de');          // Prefix::Centi
```

Parsing ignores case and common Latin accents (`kilometro` matches `kilómetro`). Units that cannot take a prefix (`kg`, `°C`) are rejected, as in `SIUnitConverter`.

Spelling that cannot be composed is data, not code. A locale can list prefixed names in `si-prefixed.php` (Spanish and Portuguese do this for the stress shift in `kilómetro`), or give a unit a `prefixed` entry with its own forms and a `separator` (Arabic does this for `ميلي ثانية`). Region tags work too: `pt` is Brazilian (`quilômetro`) and `pt-PT` is European (`quilómetro`).

## Parsing

Parsers turn a string into a `Unit` and implement `Knppy\Units\Contract\UnitParser`. They throw a `ParserException`
when the input is not a whole amount with a unit of measurement.

```php
use Knppy\Units\Parser\AggregateUnitParser;
use Knppy\Units\Parser\LocalizedUnitParser;
use Knppy\Units\Parser\SymbolUnitParser;
use Knppy\Units\UnitNames\CookingUnitNames;

(new SymbolUnitParser)->parse('5 kg');                                      // Unit(5, kg)
(new SymbolUnitParser)->parse('5', new UnitOfMeasurement('m'));             // Unit(5, m), the fallback fills a missing unit
(new LocalizedUnitParser(new CookingUnitNames, 'nl'))->parse('2 theelepels'); // Unit(2, tsp)

$parser = new AggregateUnitParser([
    new LocalizedUnitParser(new CookingUnitNames, 'nl'),
    new SymbolUnitParser,
]);
$parser->parse('2 theelepels'); // the first parser that succeeds wins
```

`SymbolUnitParser` accepts any symbol, so put it last in an `AggregateUnitParser`.

## Formatting

Formatters turn a `Unit` into a string and implement `Knppy\Units\Contract\UnitFormatter`, the counterpart of the parsers.

```php
use Knppy\Units\Formatter\AggregateUnitFormatter;
use Knppy\Units\Formatter\DecimalUnitFormatter;
use Knppy\Units\Formatter\LocalizedUnitFormatter;
use Knppy\Units\Formatter\SymbolUnitFormatter;

$unit = new Unit(1500, new UnitOfMeasurement('tsp'));

(new DecimalUnitFormatter)->format($unit);                                   // "1500"
(new SymbolUnitFormatter)->format($unit);                                    // "1500 tsp"
(new LocalizedUnitFormatter(new CookingUnitNames, 'nl'))->format($unit);     // "1.500 theelepels"
(new LocalizedUnitFormatter(new CookingUnitNames, 'nl', useName: false))->format($unit); // "1.500 tsp"

$formatter = new AggregateUnitFormatter(
    ['tsp' => new LocalizedUnitFormatter(new CookingUnitNames, 'nl')],
    new SymbolUnitFormatter, // default for other symbols, otherwise a FormatterException is thrown
);
```

`LocalizedUnitFormatter` picks the plural form from the amount and groups digits as the locale does (pass `grouping: false` to
get output `LocalizedUnitParser` can read back). Amounts beyond the integer range keep every digit.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to Units! Please review our [contributing guide](.github/CONTRIBUTING.md) to get
started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Michael Beers](https://github.com/knppy)
- [All Contributors](../../contributors)

## License

Units is open-sourced software licensed under the [MIT license](LICENSE.md).
