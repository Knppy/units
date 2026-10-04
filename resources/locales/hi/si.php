<?php

/**
 * Hindi names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'मीटर', 'other' => 'मीटर'],
    'kg' => ['one' => 'किलोग्राम', 'other' => 'किलोग्राम', 'aliases' => ['किलो']],
    's' => ['one' => 'सेकंड', 'other' => 'सेकंड'],
    'A' => ['one' => 'एम्पियर', 'other' => 'एम्पियर'],
    'K' => ['one' => 'केल्विन', 'other' => 'केल्विन'],
    'mol' => ['one' => 'मोल', 'other' => 'मोल'],
    'cd' => ['one' => 'कैंडेला', 'other' => 'कैंडेला'],
    'N' => ['one' => 'न्यूटन', 'other' => 'न्यूटन'],
    'Pa' => ['one' => 'पास्कल', 'other' => 'पास्कल'],
    'J' => ['one' => 'जूल', 'other' => 'जूल'],
    'W' => ['one' => 'वाट', 'other' => 'वाट'],
    'V' => ['one' => 'वोल्ट', 'other' => 'वोल्ट'],
    'Ω' => ['one' => 'ओम', 'other' => 'ओम'],
    '°C' => ['one' => 'डिग्री सेल्सियस', 'other' => 'डिग्री सेल्सियस'],
];
