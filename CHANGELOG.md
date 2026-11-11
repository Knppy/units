# Changelog

All notable changes to `units` will be documented in this file.

## 0.2.0 - 2026-11-11

<!-- Release notes generated using configuration in .github/release.yml at master -->
### What's Changed

#### Other Changes

* Decimal amounts, metric cooking units, kg/dl/cm/to taste by @michaelbeers in https://github.com/Knppy/units/pull/3

### New Contributors

* @michaelbeers made their first contribution in https://github.com/Knppy/units/pull/3

**Full Changelog**: https://github.com/Knppy/units/compare/v0.1.0...0.2.0

## Unreleased

- `Unit` takes a `scale` (default 0, whole numbers as before): amounts can have decimals, arithmetic rounds to the scale and `getScale()` returns it.
- `Calculator::round()` takes a `$precision`.
- `SymbolUnitParser` and `LocalizedUnitParser` read decimals (with the decimal separator of the locale) and set the scale; `LocalizedUnitFormatter` formats them.
- Converters keep the scale and only throw an `InexactConversionException` when the result has more decimals than the scale.
- Cooking: added `kg`, `dl`, `cm` and `to taste`, with names in every locale.
- Added `MetricCookingUnitOfMeasurements` with metric spoons and cups (5 ml, 15 ml, 250 ml).
