<?php

/**
 * Russian names of cooking units, keyed by symbol.
 *
 * "one" is the nominative singular (1, 21), "other" the genitive singular (2-4, fractions) and "many" the genitive
 * plural (5-20).
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'миллилитр', 'many' => 'миллилитров', 'other' => 'миллилитра', 'aliases' => ['мл']],
    'l' => ['one' => 'литр', 'many' => 'литров', 'other' => 'литра', 'aliases' => ['л']],
    'tsp' => ['one' => 'чайная ложка', 'many' => 'чайных ложек', 'other' => 'чайные ложки', 'aliases' => ['ч. л.', 'чл']],
    'tbsp' => ['one' => 'столовая ложка', 'many' => 'столовых ложек', 'other' => 'столовые ложки', 'aliases' => ['ст. л.', 'стл']],
    'fl oz' => ['one' => 'жидкая унция', 'many' => 'жидких унций', 'other' => 'жидкие унции'],
    'cup' => ['one' => 'стакан', 'many' => 'стаканов', 'other' => 'стакана', 'aliases' => ['чашка', 'чашек']],
    'pt' => ['one' => 'пинта', 'many' => 'пинт', 'other' => 'пинты'],
    'qt' => ['one' => 'кварта', 'many' => 'кварт', 'other' => 'кварты'],
    'gal' => ['one' => 'галлон', 'many' => 'галлонов', 'other' => 'галлона'],

    // Mass
    'g' => ['one' => 'грамм', 'many' => 'граммов', 'other' => 'грамма', 'aliases' => ['гр', 'г']],
    'oz' => ['one' => 'унция', 'many' => 'унций', 'other' => 'унции'],
    'lb' => ['one' => 'фунт', 'many' => 'фунтов', 'other' => 'фунта'],

    // Imprecise amounts
    'pinch' => ['one' => 'щепотка', 'many' => 'щепоток', 'other' => 'щепотки'],
    'dash' => ['one' => 'капелька', 'many' => 'капелек', 'other' => 'капельки'],
    'smidgen' => ['one' => 'чуть-чуть', 'many' => 'чуть-чуть', 'other' => 'чуть-чуть'],
    'drop' => ['one' => 'капля', 'many' => 'капель', 'other' => 'капли'],
    'splash' => ['one' => 'плеск', 'many' => 'плесков', 'other' => 'плеска', 'aliases' => ['глоток', 'глотков']],
    'handful' => ['one' => 'горсть', 'many' => 'горстей', 'other' => 'горсти'],

    // Counts
    'clove' => ['one' => 'зубчик', 'many' => 'зубчиков', 'other' => 'зубчика'],
    'slice' => ['one' => 'ломтик', 'many' => 'ломтиков', 'other' => 'ломтика', 'aliases' => ['кусочек', 'кусочков']],
    'piece' => ['one' => 'штука', 'many' => 'штук', 'other' => 'штуки', 'aliases' => ['шт']],
    'stick' => ['one' => 'палочка', 'many' => 'палочек', 'other' => 'палочки'],
    'can' => ['one' => 'банка', 'many' => 'банок', 'other' => 'банки'],
    'package' => ['one' => 'упаковка', 'many' => 'упаковок', 'other' => 'упаковки', 'aliases' => ['пачка', 'пачек']],
    'bunch' => ['one' => 'пучок', 'many' => 'пучков', 'other' => 'пучка'],
    'sprig' => ['one' => 'веточка', 'many' => 'веточек', 'other' => 'веточки'],
];
