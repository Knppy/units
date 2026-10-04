<?php

namespace Knppy\Units\UnitNames;

use Knppy\Units\Contract\UnitOfMeasurements;
use Knppy\Units\Converter\SIUnitConverter;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Prefix;
use Knppy\Units\UnitOfMeasurement;
use Knppy\Units\UnitOfMeasurements\SIUnitOfMeasurements;

/**
 * Localized names of the International System of Units, including prefixed units such as "Kilometer" for "km".
 *
 * Prefixed names are composed from the prefix name and the unit name. Locales whose spelling cannot be composed this
 * way list the prefixed names in si-prefixed.php, which take precedence.
 */
class SIUnitNames extends ResourceUnitNames
{
    private const string PREFIXED = 'si-prefixed.php';

    private const string GRAM = 'g';

    private readonly PrefixNames $prefixNames;

    /**
     * Composed names per locale, as an index from folded name to prefixed symbol.
     *
     * @var array<string, array<string, string>>
     */
    private array $composites = [];

    public function __construct(string $fallbackLocale = 'en', ?PrefixNames $prefixNames = null)
    {
        parent::__construct($fallbackLocale);

        $this->prefixNames = $prefixNames ?? new PrefixNames($fallbackLocale);
    }

    /**
     * {@inheritDoc}
     */
    public function nameFor(UnitOfMeasurement $unitOfMeasurement, string $locale, int|string $count = 1): string
    {
        $split = $this->split($unitOfMeasurement);

        if ($split === null) {
            return parent::nameFor($unitOfMeasurement, $locale, $count);
        }

        [$prefix, $base] = $split;
        $candidates = LocaleHelper::candidates($locale, $this->fallbackLocale);

        foreach ($candidates as $candidate) {
            $names = $this->namesOf(self::PREFIXED, $candidate)[$unitOfMeasurement->getSymbol()] ?? null;

            if ($names !== null) {
                return $names[LocaleHelper::pluralCategory($count, $this->pluralLocale($candidates))] ?? $names['other'];
            }
        }

        [$name, $separator] = $this->baseNames($base)->resolve(new UnitOfMeasurement($base), $locale, $count, prefixed: true);

        return $this->compose($this->prefixNames->nameFor($prefix, $locale), $name, $separator);
    }

    /**
     * {@inheritDoc}
     */
    public function parse(string $input, string $locale): UnitOfMeasurement
    {
        try {
            return parent::parse($input, $locale);
        } catch (UnknownUnitOfMeasurementException) {
            // Not a plain unit, so it may be a prefixed one.
        }

        $symbol = new UnitOfMeasurement($input);

        if ($this->split($symbol) !== null) {
            return $symbol;
        }

        $key = LocaleHelper::fold($input);

        foreach (LocaleHelper::candidates($locale, $this->fallbackLocale) as $candidate) {
            $composites = $this->composites[$candidate] ??= $this->composites($candidate);

            if (isset($composites[$key])) {
                return new UnitOfMeasurement($composites[$key]);
            }
        }

        throw new UnknownUnitOfMeasurementException('Cannot find unit of measurement '.$input.' for locale '.$locale);
    }

    /**
     * {@inheritDoc}
     */
    protected function resource(): string
    {
        return 'si.php';
    }

    /**
     * {@inheritDoc}
     */
    protected function unitOfMeasurements(): UnitOfMeasurements
    {
        return new SIUnitOfMeasurements;
    }

    /**
     * Splits a prefixed symbol such as "km" into its prefix and base symbol, or null if it is not a prefixed unit.
     *
     * The gram is what gets prefixed, not the kilogram, so "mg" is a milligram.
     *
     * @return array{Prefix, string}|null
     */
    private function split(UnitOfMeasurement $unitOfMeasurement): ?array
    {
        if ($this->unitOfMeasurements()->contains($unitOfMeasurement)) {
            return null;
        }

        $symbol = $unitOfMeasurement->getSymbol();
        $prefixes = Prefix::cases();
        usort($prefixes, fn (Prefix $a, Prefix $b) => strlen($b->getSymbol()) <=> strlen($a->getSymbol()));

        foreach ($prefixes as $prefix) {
            if (! str_starts_with($symbol, $prefix->getSymbol())) {
                continue;
            }

            $rest = substr($symbol, strlen($prefix->getSymbol()));

            if ($rest === self::GRAM || $this->isPrefixable($rest)) {
                return [$prefix, $rest];
            }
        }

        return null;
    }

    private function isPrefixable(string $symbol): bool
    {
        return $symbol !== ''
            && ! in_array($symbol, SIUnitConverter::NOT_PREFIXABLE, true)
            && $this->unitOfMeasurements()->contains(new UnitOfMeasurement($symbol));
    }

    /**
     * Returns the names that hold a base symbol: the gram is not an SI unit, so its names come from the cooking units.
     */
    private function baseNames(string $base): ResourceUnitNames
    {
        return $base === self::GRAM ? new CookingUnitNames($this->fallbackLocale) : $this;
    }

    /**
     * Joins a prefix and a unit name, keeping the capital of languages that capitalize nouns: "Kilo" and "meter".
     */
    private function compose(string $prefix, string $name, string $separator = ''): string
    {
        $first = mb_substr($name, 0, 1);
        $composed = $prefix.$separator.mb_strtolower($first).mb_substr($name, 1);

        return $first === mb_strtolower($first)
            ? $composed
            : mb_strtoupper(mb_substr($composed, 0, 1)).mb_substr($composed, 1);
    }

    /**
     * Builds the index of every composed and listed prefixed name of a locale.
     *
     * @return array<string, string>
     */
    private function composites(string $locale): array
    {
        $index = [];

        foreach ($this->namesOf(self::PREFIXED, $locale) as $symbol => $names) {
            foreach (LocaleHelper::forms($names) as $name) {
                $index[LocaleHelper::fold($name)] ??= (string) $symbol;
            }
        }

        $bases = [self::GRAM];

        foreach ($this->unitOfMeasurements() as $unit) {
            if ($this->isPrefixable($unit->getSymbol())) {
                $bases[] = $unit->getSymbol();
            }
        }

        foreach (Prefix::cases() as $prefix) {
            foreach ($this->prefixNames->forms($prefix, $locale) as $prefixForm) {
                foreach ($bases as $base) {
                    [$baseForms, $separator] = $this->baseNames($base)->formsOf(new UnitOfMeasurement($base), $locale, prefixed: true);

                    foreach ($baseForms as $baseForm) {
                        $index[LocaleHelper::fold($this->compose($prefixForm, $baseForm, $separator))] ??= $prefix->getSymbol().$base;
                        $index[LocaleHelper::fold($this->compose($prefixForm, $baseForm))] ??= $prefix->getSymbol().$base;
                    }
                }
            }
        }

        return $index;
    }
}
