<?php

/**
 * Portuguese names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'metro', 'other' => 'metros'],
    'kg' => ['one' => 'quilograma', 'other' => 'quilogramas', 'aliases' => ['quilo', 'quilos', 'kilograma', 'kilogramas']],
    's' => ['one' => 'segundo', 'other' => 'segundos'],
    'A' => ['one' => 'ampere', 'other' => 'amperes', 'aliases' => ['ampère', 'ampères']],
    'mol' => ['one' => 'mol', 'other' => 'mols'],
    'W' => ['one' => 'watt', 'other' => 'watts'],
    '°C' => ['one' => 'grau Celsius', 'other' => 'graus Celsius', 'aliases' => ['celsius']],
];
