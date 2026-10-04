<?php

/**
 * French names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'mètre', 'other' => 'mètres', 'aliases' => ['metre', 'metres']],
    'kg' => ['one' => 'kilogramme', 'other' => 'kilogrammes', 'aliases' => ['kilo', 'kilos']],
    's' => ['one' => 'seconde', 'other' => 'secondes'],
    'mol' => ['one' => 'mole', 'other' => 'moles'],
    '°C' => ['one' => 'degré Celsius', 'other' => 'degrés Celsius', 'aliases' => ['celsius']],
];
