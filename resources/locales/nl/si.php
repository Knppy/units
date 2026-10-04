<?php

/**
 * Dutch names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'meter', 'other' => 'meters'],
    'kg' => ['one' => 'kilogram', 'other' => 'kilogrammen', 'aliases' => ['kilo', 'kilo\'s']],
    's' => ['one' => 'seconde', 'other' => 'seconden'],
    'mol' => ['one' => 'mol', 'other' => 'mol'],
    '°C' => ['one' => 'graad Celsius', 'other' => 'graden Celsius', 'aliases' => ['celsius']],
];
