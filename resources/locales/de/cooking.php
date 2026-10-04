<?php

/**
 * German names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'Milliliter', 'other' => 'Milliliter'],
    'l' => ['one' => 'Liter', 'other' => 'Liter'],
    'tsp' => ['one' => 'Teelöffel', 'other' => 'Teelöffel', 'aliases' => ['TL']],
    'tbsp' => ['one' => 'Esslöffel', 'other' => 'Esslöffel', 'aliases' => ['EL']],
    'fl oz' => ['one' => 'Flüssigunze', 'other' => 'Flüssigunzen'],
    'cup' => ['one' => 'Tasse', 'other' => 'Tassen'],
    'pt' => ['one' => 'Pint', 'other' => 'Pints'],
    'qt' => ['one' => 'Quart', 'other' => 'Quarts'],
    'gal' => ['one' => 'Gallone', 'other' => 'Gallonen'],

    // Mass
    'g' => ['one' => 'Gramm', 'other' => 'Gramm'],
    'oz' => ['one' => 'Unze', 'other' => 'Unzen'],
    'lb' => ['one' => 'Pfund', 'other' => 'Pfund'],

    // Imprecise amounts
    'pinch' => ['one' => 'Prise', 'other' => 'Prisen'],
    'dash' => ['one' => 'Spritzer', 'other' => 'Spritzer'],
    'smidgen' => ['one' => 'Msp', 'other' => 'Msp', 'aliases' => ['Messerspitze', 'Messerspitzen']],
    'drop' => ['one' => 'Tropfen', 'other' => 'Tropfen'],
    'splash' => ['one' => 'Schuss', 'other' => 'Schüsse'],
    'handful' => ['one' => 'Handvoll', 'other' => 'Handvoll'],

    // Counts
    'clove' => ['one' => 'Zehe', 'other' => 'Zehen'],
    'slice' => ['one' => 'Scheibe', 'other' => 'Scheiben'],
    'piece' => ['one' => 'Stück', 'other' => 'Stücke', 'aliases' => ['Stk']],
    'stick' => ['one' => 'Stange', 'other' => 'Stangen'],
    'can' => ['one' => 'Dose', 'other' => 'Dosen'],
    'package' => ['one' => 'Packung', 'other' => 'Packungen', 'aliases' => ['Päckchen', 'Pckg']],
    'bunch' => ['one' => 'Bund', 'other' => 'Bunde'],
    'sprig' => ['one' => 'Zweig', 'other' => 'Zweige'],
];
