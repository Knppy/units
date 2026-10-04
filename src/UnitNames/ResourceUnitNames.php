<?php

namespace Knppy\Units\UnitNames;

use Knppy\Units\Contract\UnitNames;
use Knppy\Units\Contract\UnitOfMeasurements;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\UnitOfMeasurement;

/**
 * Localized unit names defined in resource files, keyed by symbol.
 *
 * An entry needs the "one" and "other" forms, and may add the other CLDR plural categories ("zero", "two", "few",
 * "many"), aliases, and a "prefixed" entry of its own forms (and a "separator") for use after a metric prefix.
 *
 * @phpstan-type Names array{one: string, other: string, zero?: string, two?: string, few?: string, many?: string, aliases?: list<string>, prefixed?: array<string, mixed>}
 */
abstract class ResourceUnitNames implements UnitNames
{
    /**
     * Loaded names, per locale and resource file.
     *
     * @var array<string, array<string, Names>>
     */
    private static array $loaded = [];

    /**
     * Reverse indexes (normalized name or alias to symbol), per locale and resource file.
     *
     * @var array<string, array<string, string>>
     */
    private static array $indexes = [];

    public function __construct(protected readonly string $fallbackLocale = 'en') {}

    /**
     * Returns the file name of the resource inside the locale directory, e.g. "si.php".
     */
    abstract protected function resource(): string;

    /**
     * Returns the unit of measurements the names belong to.
     */
    abstract protected function unitOfMeasurements(): UnitOfMeasurements;

    /**
     * {@inheritDoc}
     */
    public function nameFor(UnitOfMeasurement $unitOfMeasurement, string $locale, int|string $count = 1): string
    {
        return $this->resolve($unitOfMeasurement, $locale, $count)[0];
    }

    /**
     * {@inheritDoc}
     */
    public function parse(string $input, string $locale): UnitOfMeasurement
    {
        $symbol = new UnitOfMeasurement($input);

        if ($this->unitOfMeasurements()->contains($symbol)) {
            return $symbol;
        }

        $normalized = LocaleHelper::normalize($input);

        foreach (LocaleHelper::candidates($locale, $this->fallbackLocale) as $candidate) {
            $index = $this->index($candidate);

            if (isset($index[$normalized])) {
                return new UnitOfMeasurement($index[$normalized]);
            }
        }

        throw new UnknownUnitOfMeasurementException('Cannot find unit of measurement '.$input.' for locale '.$locale);
    }

    /**
     * Returns the name of a unit of measurement for a count, and the separator that goes between a prefix and the name.
     *
     * With $prefixed the forms meant for use after a metric prefix are used where a locale lists them.
     *
     * @return array{string, string}
     *
     * @throws UnknownUnitOfMeasurementException
     */
    protected function resolve(UnitOfMeasurement $unitOfMeasurement, string $locale, int|string $count, bool $prefixed = false): array
    {
        $unitOfMeasurements = $this->unitOfMeasurements();

        if (! $unitOfMeasurements->contains($unitOfMeasurement)) {
            throw new UnknownUnitOfMeasurementException('Cannot find unit of measurement '.$unitOfMeasurement->getSymbol());
        }

        $candidates = LocaleHelper::candidates($locale, $this->fallbackLocale);

        foreach ($candidates as $candidate) {
            $names = $this->namesOf($this->resource(), $candidate)[$unitOfMeasurement->getSymbol()] ?? null;

            if ($names !== null) {
                $names = $prefixed ? ($names['prefixed'] ?? $names) : $names;
                $category = LocaleHelper::pluralCategory($count, $this->pluralLocale($candidates));

                return [$names[$category] ?? $names['other'], $names['separator'] ?? ''];
            }
        }

        return [$unitOfMeasurements->nameFor($unitOfMeasurement), ''];
    }

    /**
     * Returns the locale whose plural rules apply: the first with names of its own, so an unsupported locale that
     * falls back to English counts like English instead of by the rules ICU guesses for it.
     *
     * @param  list<string>  $candidates
     */
    protected function pluralLocale(array $candidates): string
    {
        foreach ($candidates as $candidate) {
            if ($this->namesOf($this->resource(), $candidate) !== []) {
                return $candidate;
            }
        }

        return $this->fallbackLocale;
    }

    /**
     * Returns every name, plural form and alias of a unit of measurement in exactly this locale, without fallback,
     * and the separator that goes between a prefix and the name.
     *
     * @return array{list<string>, string}
     */
    protected function formsOf(UnitOfMeasurement $unitOfMeasurement, string $locale, bool $prefixed = false): array
    {
        $names = $this->namesOf($this->resource(), $locale)[$unitOfMeasurement->getSymbol()] ?? null;

        if ($names === null) {
            return [[], ''];
        }

        $names = $prefixed ? ($names['prefixed'] ?? $names) : $names;

        return [LocaleHelper::forms($names), $names['separator'] ?? ''];
    }

    /**
     * Returns the names of a locale from a resource file, loading them on first use. Unsupported locales have no names.
     *
     * @return array<string, Names>
     */
    protected function namesOf(string $resource, string $locale): array
    {
        return self::$loaded[$locale.'/'.$resource] ??= $this->load($resource, $locale);
    }

    /**
     * Returns the reverse index of a locale, building it on first use.
     *
     * @return array<string, string>
     */
    private function index(string $locale): array
    {
        return self::$indexes[$locale.'/'.$this->resource()] ??= $this->buildIndex($locale);
    }

    /**
     * @return array<string, string>
     */
    private function buildIndex(string $locale): array
    {
        $index = [];

        foreach ($this->namesOf($this->resource(), $locale) as $symbol => $names) {
            foreach (LocaleHelper::forms($names) as $name) {
                $index[LocaleHelper::normalize($name)] ??= (string) $symbol;
            }
        }

        return $index;
    }

    /**
     * @return array<string, Names>
     */
    private function load(string $resource, string $locale): array
    {
        $file = __DIR__.'/../../resources/locales/'.$locale.'/'.$resource;

        return is_file($file) ? require $file : [];
    }
}
