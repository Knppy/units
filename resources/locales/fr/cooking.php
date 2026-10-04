<?php

/**
 * French names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'millilitre', 'other' => 'millilitres'],
    'l' => ['one' => 'litre', 'other' => 'litres'],
    'tsp' => ['one' => 'cuillère à café', 'other' => 'cuillères à café', 'aliases' => ['c. à c.', 'cc', 'càc']],
    'tbsp' => ['one' => 'cuillère à soupe', 'other' => 'cuillères à soupe', 'aliases' => ['c. à s.', 'cs', 'càs']],
    'fl oz' => ['one' => 'once liquide', 'other' => 'onces liquides'],
    'cup' => ['one' => 'tasse', 'other' => 'tasses'],
    'pt' => ['one' => 'pinte', 'other' => 'pintes'],
    'qt' => ['one' => 'quart', 'other' => 'quarts'],
    'gal' => ['one' => 'gallon', 'other' => 'gallons'],

    // Mass
    'g' => ['one' => 'gramme', 'other' => 'grammes'],
    'oz' => ['one' => 'once', 'other' => 'onces'],
    'lb' => ['one' => 'livre', 'other' => 'livres'],

    // Imprecise amounts
    'pinch' => ['one' => 'pincée', 'other' => 'pincées'],
    'dash' => ['one' => 'trait', 'other' => 'traits'],
    'smidgen' => ['one' => 'soupçon', 'other' => 'soupçons'],
    'drop' => ['one' => 'goutte', 'other' => 'gouttes'],
    'splash' => ['one' => 'filet', 'other' => 'filets'],
    'handful' => ['one' => 'poignée', 'other' => 'poignées'],

    // Counts
    'clove' => ['one' => 'gousse', 'other' => 'gousses'],
    'slice' => ['one' => 'tranche', 'other' => 'tranches'],
    'piece' => ['one' => 'morceau', 'other' => 'morceaux', 'aliases' => ['pièce', 'pièces']],
    'stick' => ['one' => 'bâton', 'other' => 'bâtons', 'aliases' => ['bâtonnet', 'bâtonnets']],
    'can' => ['one' => 'boîte', 'other' => 'boîtes', 'aliases' => ['conserve', 'conserves']],
    'package' => ['one' => 'paquet', 'other' => 'paquets', 'aliases' => ['sachet', 'sachets']],
    'bunch' => ['one' => 'botte', 'other' => 'bottes', 'aliases' => ['bouquet', 'bouquets']],
    'sprig' => ['one' => 'brin', 'other' => 'brins', 'aliases' => ['branche', 'branches']],
];
