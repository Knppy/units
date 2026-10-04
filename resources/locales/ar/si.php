<?php

/**
 * Arabic names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'متر', 'zero' => 'أمتار', 'two' => 'متران', 'few' => 'أمتار', 'many' => 'متر', 'other' => 'متر', 'prefixed' => ['one' => 'متر', 'two' => 'متران', 'zero' => 'مترات', 'few' => 'مترات', 'many' => 'متر', 'other' => 'متر']],
    'kg' => ['one' => 'كيلوغرام', 'zero' => 'كيلوغرامات', 'two' => 'كيلوغرامان', 'few' => 'كيلوغرامات', 'many' => 'كيلوغرام', 'other' => 'كيلوغرام', 'aliases' => ['كيلو', 'كيلوجرام']],
    's' => ['one' => 'ثانية', 'zero' => 'ثوان', 'two' => 'ثانيتان', 'few' => 'ثوان', 'many' => 'ثانية', 'other' => 'ثانية', 'prefixed' => ['one' => 'ثانية', 'other' => 'ثانية', 'separator' => ' ']],
    'A' => ['one' => 'أمبير', 'zero' => 'أمبيرات', 'two' => 'أمبيران', 'few' => 'أمبيرات', 'many' => 'أمبير', 'other' => 'أمبير'],
    'K' => ['one' => 'كلفن', 'other' => 'كلفن'],
    'mol' => ['one' => 'مول', 'zero' => 'مولات', 'two' => 'مولان', 'few' => 'مولات', 'many' => 'مول', 'other' => 'مول'],
    'cd' => ['one' => 'شمعة', 'zero' => 'شموع', 'two' => 'شمعتان', 'few' => 'شموع', 'many' => 'شمعة', 'other' => 'شمعة', 'aliases' => ['كانديلا']],
    'N' => ['one' => 'نيوتن', 'other' => 'نيوتن'],
    'Pa' => ['one' => 'باسكال', 'other' => 'باسكال'],
    'J' => ['one' => 'جول', 'other' => 'جول'],
    'W' => ['one' => 'واط', 'other' => 'واط'],
    'V' => ['one' => 'فولت', 'other' => 'فولت'],
    'Ω' => ['one' => 'أوم', 'other' => 'أوم'],
    '°C' => ['one' => 'درجة مئوية', 'zero' => 'درجات مئوية', 'few' => 'درجات مئوية', 'many' => 'درجة مئوية', 'other' => 'درجة مئوية'],
];
