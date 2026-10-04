<?php

/**
 * Japanese names of cooking units, keyed by symbol. Japanese has no plural forms.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'ミリリットル', 'other' => 'ミリリットル', 'aliases' => ['cc']],
    'l' => ['one' => 'リットル', 'other' => 'リットル'],
    'tsp' => ['one' => '小さじ', 'other' => '小さじ'],
    'tbsp' => ['one' => '大さじ', 'other' => '大さじ'],
    'fl oz' => ['one' => '液量オンス', 'other' => '液量オンス'],
    'cup' => ['one' => 'カップ', 'other' => 'カップ'],
    'pt' => ['one' => 'パイント', 'other' => 'パイント'],
    'qt' => ['one' => 'クォート', 'other' => 'クォート'],
    'gal' => ['one' => 'ガロン', 'other' => 'ガロン'],

    // Mass
    'g' => ['one' => 'グラム', 'other' => 'グラム'],
    'oz' => ['one' => 'オンス', 'other' => 'オンス'],
    'lb' => ['one' => 'ポンド', 'other' => 'ポンド'],

    // Imprecise amounts
    'pinch' => ['one' => 'ひとつまみ', 'other' => 'ひとつまみ', 'aliases' => ['つまみ']],
    'dash' => ['one' => '少々', 'other' => '少々'],
    'smidgen' => ['one' => 'ごく少量', 'other' => 'ごく少量', 'aliases' => ['少量']],
    'drop' => ['one' => '滴', 'other' => '滴', 'aliases' => ['しずく']],
    'splash' => ['one' => 'ひと回し', 'other' => 'ひと回し'],
    'handful' => ['one' => 'ひとつかみ', 'other' => 'ひとつかみ', 'aliases' => ['一握り']],

    // Counts
    'clove' => ['one' => 'かけ', 'other' => 'かけ', 'aliases' => ['片']],
    'slice' => ['one' => '枚', 'other' => '枚', 'aliases' => ['スライス']],
    'piece' => ['one' => '個', 'other' => '個', 'aliases' => ['切れ']],
    'stick' => ['one' => '本', 'other' => '本', 'aliases' => ['スティック']],
    'can' => ['one' => '缶', 'other' => '缶'],
    'package' => ['one' => 'パック', 'other' => 'パック', 'aliases' => ['袋']],
    'bunch' => ['one' => '束', 'other' => '束'],
    'sprig' => ['one' => '枝', 'other' => '枝'],
];
