<?php

/**
 * Dutch names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'milliliter', 'other' => 'milliliters'],
    'l' => ['one' => 'liter', 'other' => 'liters'],
    'tsp' => ['one' => 'theelepel', 'other' => 'theelepels', 'aliases' => ['tl']],
    'tbsp' => ['one' => 'eetlepel', 'other' => 'eetlepels', 'aliases' => ['el']],
    'fl oz' => ['one' => 'vloeibare ounce', 'other' => 'vloeibare ounces'],
    'cup' => ['one' => 'kopje', 'other' => 'kopjes', 'aliases' => ['kop', 'koppen']],
    'pt' => ['one' => 'pint', 'other' => 'pints'],
    'qt' => ['one' => 'quart', 'other' => 'quarts'],
    'gal' => ['one' => 'gallon', 'other' => 'gallons'],

    // Mass
    'g' => ['one' => 'gram', 'other' => 'grammen', 'aliases' => ['gr']],
    'oz' => ['one' => 'ounce', 'other' => 'ounces'],
    'lb' => ['one' => 'pond', 'other' => 'ponden'],

    // Imprecise amounts
    'pinch' => ['one' => 'snufje', 'other' => 'snufjes', 'aliases' => ['mespuntje', 'mespuntjes']],
    'dash' => ['one' => 'scheutje', 'other' => 'scheutjes'],
    'smidgen' => ['one' => 'klein snufje', 'other' => 'kleine snufjes'],
    'drop' => ['one' => 'druppel', 'other' => 'druppels'],
    'splash' => ['one' => 'plens', 'other' => 'plensjes', 'aliases' => ['scheut', 'scheuten']],
    'handful' => ['one' => 'handvol', 'other' => 'handvollen'],

    // Counts
    'clove' => ['one' => 'teentje', 'other' => 'teentjes', 'aliases' => ['teen', 'tenen']],
    'slice' => ['one' => 'plak', 'other' => 'plakken', 'aliases' => ['plakje', 'plakjes', 'snee', 'sneden']],
    'piece' => ['one' => 'stuk', 'other' => 'stuks', 'aliases' => ['stukken', 'stukje', 'stukjes']],
    'stick' => ['one' => 'stokje', 'other' => 'stokjes', 'aliases' => ['staaf', 'staven']],
    'can' => ['one' => 'blik', 'other' => 'blikken', 'aliases' => ['blikje', 'blikjes']],
    'package' => ['one' => 'pakje', 'other' => 'pakjes', 'aliases' => ['pak', 'pakken', 'verpakking']],
    'bunch' => ['one' => 'bos', 'other' => 'bossen', 'aliases' => ['bosje', 'bosjes']],
    'sprig' => ['one' => 'takje', 'other' => 'takjes', 'aliases' => ['tak', 'takken']],
];
