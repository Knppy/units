<?php

namespace Knppy\Units\UnitNames;

/**
 * Locale and text helpers shared by the name lookups.
 *
 * @internal
 */
final class LocaleHelper
{
    /**
     * The CLDR plural categories a name can have a form for. "other" is required, and the fallback for the rest.
     */
    public const array CATEGORIES = ['zero', 'one', 'two', 'few', 'many', 'other'];

    /**
     * Returns the locales to try, most specific first, e.g. "nl-NL", "nl" and the fallback locale.
     *
     * Anything that does not look like a locale tag is ignored, so a locale can never point outside the resources.
     *
     * @return list<string>
     */
    public static function candidates(string $locale, string $fallbackLocale): array
    {
        $locale = strtolower(str_replace('_', '-', trim($locale)));
        $candidates = [];

        if (preg_match('/^[a-z]{2,3}(-[a-z0-9]{2,8})*$/', $locale) === 1) {
            $candidates[] = $locale;
            $candidates[] = explode('-', $locale)[0];
        }

        $candidates[] = $fallbackLocale;

        return array_values(array_unique($candidates));
    }

    /**
     * Normalizes a name for matching: lowercase, trimmed, without trailing dot and with single spaces.
     */
    public static function normalize(string $name): string
    {
        $name = mb_strtolower(trim($name));
        $name = (string) preg_replace('/\s+/u', ' ', $name);

        return rtrim($name, '.');
    }

    /**
     * Normalizes a name and strips common Latin diacritics, so "kilometro" matches "kilómetro".
     */
    public static function fold(string $name): string
    {
        static $map = null;

        $map ??= array_combine(
            mb_str_split('àáâãäåçèéêëìíîïñòóôõöùúûüýÿ'),
            mb_str_split('aaaaaaceeeeiiiinooooouuuuyy')
        );

        return strtr(self::normalize($name), $map);
    }

    /**
     * Returns the CLDR plural category of a count in a locale, e.g. "few" for 22 in Russian.
     *
     * Counts are whole numbers, possibly beyond the integer range, so only the digits plural rules depend on are kept.
     */
    public static function pluralCategory(int|string $count, string $locale): string
    {
        static $formatters = [];

        $formatters[$locale] ??= \MessageFormatter::create(
            $locale,
            '{0, plural, zero{zero} one{one} two{two} few{few} many{many} other{other}}'
        ) ?? false;

        if ($formatters[$locale] === false) {
            return 'other';
        }

        $category = $formatters[$locale]->format([self::pluralNumber($count)]);

        return in_array($category, self::CATEGORIES, true) ? $category : 'other';
    }

    /**
     * Returns every name, plural form and alias in a names entry.
     *
     * @param  array<string, mixed>  $names
     * @return list<string>
     */
    public static function forms(array $names): array
    {
        $forms = [];

        foreach (self::CATEGORIES as $category) {
            if (isset($names[$category])) {
                $forms[] = $names[$category];
            }
        }

        return array_values(array_unique([...$forms, ...($names['aliases'] ?? [])]));
    }

    private static function pluralNumber(int|string $count): int|float
    {
        if (is_int($count)) {
            return abs($count);
        }

        if (preg_match('/^-?\d+$/', $count) !== 1) {
            return abs((float) $count);
        }

        $digits = ltrim(ltrim($count, '-'), '0');

        if (strlen($digits) <= 15) {
            return (int) $digits;
        }

        // Plural rules only look at the last digits, and at whether a million divides the number.
        return (int) substr($digits, -6) ?: 1000000;
    }
}
