<?php

/**
 * German names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'Meter', 'other' => 'Meter'],
    'kg' => ['one' => 'Kilogramm', 'other' => 'Kilogramm', 'aliases' => ['Kilo']],
    's' => ['one' => 'Sekunde', 'other' => 'Sekunden'],
    'mol' => ['one' => 'Mol', 'other' => 'Mol'],
    '°C' => ['one' => 'Grad Celsius', 'other' => 'Grad Celsius', 'aliases' => ['Celsius']],
];
