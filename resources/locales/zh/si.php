<?php

/**
 * Chinese names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => '米', 'other' => '米'],
    'kg' => ['one' => '千克', 'other' => '千克', 'aliases' => ['公斤']],
    's' => ['one' => '秒', 'other' => '秒'],
    'A' => ['one' => '安培', 'other' => '安培', 'aliases' => ['安']],
    'K' => ['one' => '开尔文', 'other' => '开尔文'],
    'mol' => ['one' => '摩尔', 'other' => '摩尔'],
    'cd' => ['one' => '坎德拉', 'other' => '坎德拉'],
    'N' => ['one' => '牛顿', 'other' => '牛顿', 'aliases' => ['牛']],
    'Pa' => ['one' => '帕斯卡', 'other' => '帕斯卡', 'aliases' => ['帕']],
    'J' => ['one' => '焦耳', 'other' => '焦耳', 'aliases' => ['焦']],
    'W' => ['one' => '瓦特', 'other' => '瓦特', 'aliases' => ['瓦']],
    'V' => ['one' => '伏特', 'other' => '伏特', 'aliases' => ['伏']],
    'Ω' => ['one' => '欧姆', 'other' => '欧姆', 'aliases' => ['欧']],
    '°C' => ['one' => '摄氏度', 'other' => '摄氏度'],
];
