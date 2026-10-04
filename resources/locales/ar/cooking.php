<?php

/**
 * Arabic names of cooking units, keyed by symbol.
 *
 * "few" is the plural (3-10), "many" and "other" the singular that follows 11 and more, and "two" the dual. The dual is
 * only given for regular single-word nouns.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'مليلتر', 'zero' => 'مليلترات', 'two' => 'مليلتران', 'few' => 'مليلترات', 'many' => 'مليلتر', 'other' => 'مليلتر'],
    'l' => ['one' => 'لتر', 'zero' => 'لترات', 'two' => 'لتران', 'few' => 'لترات', 'many' => 'لتر', 'other' => 'لتر'],
    'tsp' => ['one' => 'ملعقة صغيرة', 'zero' => 'ملاعق صغيرة', 'few' => 'ملاعق صغيرة', 'many' => 'ملعقة صغيرة', 'other' => 'ملعقة صغيرة', 'aliases' => ['ملعقة شاي', 'ملاعق شاي']],
    'tbsp' => ['one' => 'ملعقة كبيرة', 'zero' => 'ملاعق كبيرة', 'few' => 'ملاعق كبيرة', 'many' => 'ملعقة كبيرة', 'other' => 'ملعقة كبيرة', 'aliases' => ['ملعقة طعام', 'ملاعق طعام']],
    'fl oz' => ['one' => 'أونصة سائلة', 'zero' => 'أونصات سائلة', 'few' => 'أونصات سائلة', 'many' => 'أونصة سائلة', 'other' => 'أونصة سائلة'],
    'cup' => ['one' => 'كوب', 'zero' => 'أكواب', 'two' => 'كوبان', 'few' => 'أكواب', 'many' => 'كوب', 'other' => 'كوب', 'aliases' => ['فنجان', 'فناجين']],
    'pt' => ['one' => 'باينت', 'zero' => 'باينتات', 'two' => 'باينتان', 'few' => 'باينتات', 'many' => 'باينت', 'other' => 'باينت'],
    'qt' => ['one' => 'كوارت', 'zero' => 'كوارتات', 'two' => 'كوارتان', 'few' => 'كوارتات', 'many' => 'كوارت', 'other' => 'كوارت'],
    'gal' => ['one' => 'غالون', 'zero' => 'غالونات', 'two' => 'غالونان', 'few' => 'غالونات', 'many' => 'غالون', 'other' => 'غالون'],

    // Mass
    'g' => ['one' => 'غرام', 'zero' => 'غرامات', 'two' => 'غرامان', 'few' => 'غرامات', 'many' => 'غرام', 'other' => 'غرام', 'aliases' => ['جرام', 'جرامات']],
    'oz' => ['one' => 'أونصة', 'zero' => 'أونصات', 'two' => 'أونصتان', 'few' => 'أونصات', 'many' => 'أونصة', 'other' => 'أونصة'],
    'lb' => ['one' => 'رطل', 'zero' => 'أرطال', 'two' => 'رطلان', 'few' => 'أرطال', 'many' => 'رطل', 'other' => 'رطل', 'aliases' => ['باوند']],

    // Imprecise amounts
    'pinch' => ['one' => 'رشة', 'zero' => 'رشات', 'two' => 'رشتان', 'few' => 'رشات', 'many' => 'رشة', 'other' => 'رشة', 'aliases' => ['قرصة']],
    'dash' => ['one' => 'لمسة', 'zero' => 'لمسات', 'two' => 'لمستان', 'few' => 'لمسات', 'many' => 'لمسة', 'other' => 'لمسة'],
    'smidgen' => ['one' => 'قليل', 'other' => 'قليل', 'aliases' => ['شيء قليل']],
    'drop' => ['one' => 'قطرة', 'zero' => 'قطرات', 'two' => 'قطرتان', 'few' => 'قطرات', 'many' => 'قطرة', 'other' => 'قطرة'],
    'splash' => ['one' => 'سكبة', 'zero' => 'سكبات', 'two' => 'سكبتان', 'few' => 'سكبات', 'many' => 'سكبة', 'other' => 'سكبة'],
    'handful' => ['one' => 'حفنة', 'zero' => 'حفنات', 'two' => 'حفنتان', 'few' => 'حفنات', 'many' => 'حفنة', 'other' => 'حفنة'],

    // Counts
    'clove' => ['one' => 'فص', 'zero' => 'فصوص', 'two' => 'فصان', 'few' => 'فصوص', 'many' => 'فص', 'other' => 'فص'],
    'slice' => ['one' => 'شريحة', 'zero' => 'شرائح', 'two' => 'شريحتان', 'few' => 'شرائح', 'many' => 'شريحة', 'other' => 'شريحة'],
    'piece' => ['one' => 'قطعة', 'zero' => 'قطع', 'two' => 'قطعتان', 'few' => 'قطع', 'many' => 'قطعة', 'other' => 'قطعة'],
    'stick' => ['one' => 'عود', 'zero' => 'أعواد', 'two' => 'عودان', 'few' => 'أعواد', 'many' => 'عود', 'other' => 'عود'],
    'can' => ['one' => 'علبة', 'zero' => 'علب', 'two' => 'علبتان', 'few' => 'علب', 'many' => 'علبة', 'other' => 'علبة'],
    'package' => ['one' => 'عبوة', 'zero' => 'عبوات', 'two' => 'عبوتان', 'few' => 'عبوات', 'many' => 'عبوة', 'other' => 'عبوة', 'aliases' => ['كيس', 'أكياس']],
    'bunch' => ['one' => 'حزمة', 'zero' => 'حزم', 'two' => 'حزمتان', 'few' => 'حزم', 'many' => 'حزمة', 'other' => 'حزمة', 'aliases' => ['باقة', 'باقات']],
    'sprig' => ['one' => 'غصن', 'zero' => 'أغصان', 'two' => 'غصنان', 'few' => 'أغصان', 'many' => 'غصن', 'other' => 'غصن'],
];
