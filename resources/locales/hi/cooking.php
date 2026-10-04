<?php

/**
 * Hindi names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'मिलीलीटर', 'other' => 'मिलीलीटर'],
    'l' => ['one' => 'लीटर', 'other' => 'लीटर'],
    'tsp' => ['one' => 'छोटा चम्मच', 'other' => 'छोटे चम्मच', 'aliases' => ['चाय का चम्मच']],
    'tbsp' => ['one' => 'बड़ा चम्मच', 'other' => 'बड़े चम्मच'],
    'fl oz' => ['one' => 'तरल औंस', 'other' => 'तरल औंस'],
    'cup' => ['one' => 'कप', 'other' => 'कप'],
    'pt' => ['one' => 'पिंट', 'other' => 'पिंट'],
    'qt' => ['one' => 'क्वार्ट', 'other' => 'क्वार्ट'],
    'gal' => ['one' => 'गैलन', 'other' => 'गैलन'],

    // Mass
    'g' => ['one' => 'ग्राम', 'other' => 'ग्राम'],
    'oz' => ['one' => 'औंस', 'other' => 'औंस'],
    'lb' => ['one' => 'पाउंड', 'other' => 'पाउंड'],

    // Imprecise amounts
    'pinch' => ['one' => 'चुटकी', 'other' => 'चुटकियाँ'],
    'dash' => ['one' => 'छींटा', 'other' => 'छींटे'],
    'smidgen' => ['one' => 'ज़रा सा', 'other' => 'ज़रा सा'],
    'drop' => ['one' => 'बूँद', 'other' => 'बूँदें'],
    'splash' => ['one' => 'धार', 'other' => 'धारें'],
    'handful' => ['one' => 'मुट्ठी', 'other' => 'मुट्ठियाँ', 'aliases' => ['मुट्ठी भर']],

    // Counts
    'clove' => ['one' => 'कली', 'other' => 'कलियाँ'],
    'slice' => ['one' => 'टुकड़ा', 'other' => 'टुकड़े', 'aliases' => ['स्लाइस']],
    'piece' => ['one' => 'नग', 'other' => 'नग', 'aliases' => ['पीस']],
    'stick' => ['one' => 'डंडी', 'other' => 'डंडियाँ'],
    'can' => ['one' => 'डिब्बा', 'other' => 'डिब्बे'],
    'package' => ['one' => 'पैकेट', 'other' => 'पैकेट'],
    'bunch' => ['one' => 'गुच्छा', 'other' => 'गुच्छे'],
    'sprig' => ['one' => 'टहनी', 'other' => 'टहनियाँ'],
];
