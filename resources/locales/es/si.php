<?php

/**
 * Spanish names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'metro', 'other' => 'metros'],
    'kg' => ['one' => 'kilogramo', 'other' => 'kilogramos', 'aliases' => ['kilo', 'kilos']],
    's' => ['one' => 'segundo', 'other' => 'segundos'],
    'A' => ['one' => 'amperio', 'other' => 'amperios', 'aliases' => ['ampere', 'amperes']],
    'mol' => ['one' => 'mol', 'other' => 'moles'],
    'J' => ['one' => 'julio', 'other' => 'julios'],
    'W' => ['one' => 'vatio', 'other' => 'vatios'],
    'C' => ['one' => 'culombio', 'other' => 'culombios'],
    'V' => ['one' => 'voltio', 'other' => 'voltios'],
    'F' => ['one' => 'faradio', 'other' => 'faradios'],
    'Ω' => ['one' => 'ohmio', 'other' => 'ohmios', 'aliases' => ['ohm']],
    'H' => ['one' => 'henrio', 'other' => 'henrios'],
    '°C' => ['one' => 'grado Celsius', 'other' => 'grados Celsius', 'aliases' => ['celsius']],
];
