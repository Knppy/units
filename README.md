<div align="center">
    <h1>Units</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/knppy/units"><img src="https://img.shields.io/packagist/v/knppy/units.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/knppy/units"><img src="https://img.shields.io/packagist/php-v/knppy/units.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/knppy/units"><img src="https://badge.laravel.cloud/badge/knppy/units?style=flat" alt="Laravel versions"></a>
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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to Ui! Please review our [contributing guide](.github/CONTRIBUTING.md) to get
started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Michael Beers](https://github.com/knppy)
- [All Contributors](../../contributors)

## License

Ui is open-sourced software licensed under the [MIT license](LICENSE.md).
