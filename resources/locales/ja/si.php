<?php

/**
 * Japanese names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'メートル', 'other' => 'メートル'],
    'kg' => ['one' => 'キログラム', 'other' => 'キログラム'],
    's' => ['one' => '秒', 'other' => '秒'],
    'A' => ['one' => 'アンペア', 'other' => 'アンペア'],
    'K' => ['one' => 'ケルビン', 'other' => 'ケルビン'],
    'mol' => ['one' => 'モル', 'other' => 'モル'],
    'cd' => ['one' => 'カンデラ', 'other' => 'カンデラ'],
    'N' => ['one' => 'ニュートン', 'other' => 'ニュートン'],
    'Pa' => ['one' => 'パスカル', 'other' => 'パスカル'],
    'J' => ['one' => 'ジュール', 'other' => 'ジュール'],
    'W' => ['one' => 'ワット', 'other' => 'ワット'],
    'V' => ['one' => 'ボルト', 'other' => 'ボルト'],
    'Ω' => ['one' => 'オーム', 'other' => 'オーム'],
    '°C' => ['one' => '摂氏度', 'other' => '摂氏度', 'aliases' => ['度']],
];
