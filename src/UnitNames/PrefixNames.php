<?php

namespace Knppy\Units\UnitNames;

use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Prefix;

/**
 * Localized names of the metric prefixes, defined in resource files keyed by prefix symbol.
 *
 * @phpstan-type Names array{name: string, aliases?: list<string>}
 */
class PrefixNames
{
    /**
     * Loaded names, per locale.
     *
     * @var array<string, array<string, Names>>
     */
    private static array $loaded = [];

    public function __construct(private readonly string $fallbackLocale = 'en') {}

    /**
     * Returns the localized name of a prefix, e.g. "Kilo" for "k" in "de", in lowercase.
     *
     * Falls back to the fallback locale, and finally to {@see Prefix::getName()}.
     */
    public function nameFor(Prefix $prefix, string $locale): string
    {
        foreach (LocaleHelper::candidates($locale, $this->fallbackLocale) as $candidate) {
            $names = $this->names($candidate)[$prefix->getSymbol()] ?? null;

            if ($names !== null) {
                return $names['name'];
            }
        }

        return $prefix->getName();
    }

    /**
     * Resolves a symbol, localized name or alias to a prefix, e.g. "zenti" to {@see Prefix::Centi} in "de".
     *
     * @throws UnknownUnitOfMeasurementException
     */
    public function parse(string $input, string $locale): Prefix
    {
        $prefix = Prefix::tryFrom($input);

        if ($prefix !== null) {
            return $prefix;
        }

        $key = LocaleHelper::fold($input);

        foreach (LocaleHelper::candidates($locale, $this->fallbackLocale) as $candidate) {
            foreach (Prefix::cases() as $case) {
                foreach ($this->forms($case, $candidate) as $form) {
                    if (LocaleHelper::fold($form) === $key) {
                        return $case;
                    }
                }
            }
        }

        throw new UnknownUnitOfMeasurementException('Cannot find prefix '.$input.' for locale '.$locale);
    }

    /**
     * Returns the name and aliases of a prefix in exactly this locale, without fallback.
     *
     * @return list<string>
     */
    public function forms(Prefix $prefix, string $locale): array
    {
        $names = $this->names($locale)[$prefix->getSymbol()] ?? null;

        return $names === null ? [] : [$names['name'], ...($names['aliases'] ?? [])];
    }

    /**
     * @return array<string, Names>
     */
    private function names(string $locale): array
    {
        return self::$loaded[$locale] ??= $this->load($locale);
    }

    /**
     * @return array<string, Names>
     */
    private function load(string $locale): array
    {
        $file = __DIR__.'/../../resources/locales/'.$locale.'/prefixes.php';

        return is_file($file) ? require $file : [];
    }
}
