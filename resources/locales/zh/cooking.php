<?php

/**
 * Chinese (Simplified) names of cooking units, keyed by symbol. Chinese has no plural forms.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => '毫升', 'other' => '毫升'],
    'l' => ['one' => '升', 'other' => '升'],
    'tsp' => ['one' => '茶匙', 'other' => '茶匙', 'aliases' => ['小匙']],
    'tbsp' => ['one' => '汤匙', 'other' => '汤匙', 'aliases' => ['大匙']],
    'fl oz' => ['one' => '液体盎司', 'other' => '液体盎司'],
    'cup' => ['one' => '杯', 'other' => '杯'],
    'pt' => ['one' => '品脱', 'other' => '品脱'],
    'qt' => ['one' => '夸脱', 'other' => '夸脱'],
    'gal' => ['one' => '加仑', 'other' => '加仑'],

    // Mass
    'g' => ['one' => '克', 'other' => '克'],
    'oz' => ['one' => '盎司', 'other' => '盎司'],
    'lb' => ['one' => '磅', 'other' => '磅'],

    // Imprecise amounts
    'pinch' => ['one' => '一撮', 'other' => '一撮', 'aliases' => ['撮']],
    'dash' => ['one' => '少许', 'other' => '少许'],
    'smidgen' => ['one' => '一点点', 'other' => '一点点'],
    'drop' => ['one' => '滴', 'other' => '滴'],
    'splash' => ['one' => '一股', 'other' => '一股', 'aliases' => ['适量']],
    'handful' => ['one' => '一把', 'other' => '一把', 'aliases' => ['把']],

    // Counts
    'clove' => ['one' => '瓣', 'other' => '瓣'],
    'slice' => ['one' => '片', 'other' => '片'],
    'piece' => ['one' => '块', 'other' => '块', 'aliases' => ['个']],
    'stick' => ['one' => '根', 'other' => '根', 'aliases' => ['条']],
    'can' => ['one' => '罐', 'other' => '罐'],
    'package' => ['one' => '包', 'other' => '包', 'aliases' => ['袋']],
    'bunch' => ['one' => '束', 'other' => '束'],
    'sprig' => ['one' => '枝', 'other' => '枝', 'aliases' => ['小枝']],
];
