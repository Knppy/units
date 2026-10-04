<?php

/**
 * Russian names of the International System of Units, keyed by symbol.
 *
 * Only units whose name differs from the English one are listed; the others fall back to English.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    'm' => ['one' => 'метр', 'many' => 'метров', 'other' => 'метра', 'aliases' => ['м']],
    'kg' => ['one' => 'килограмм', 'many' => 'килограммов', 'other' => 'килограмма', 'aliases' => ['кг']],
    's' => ['one' => 'секунда', 'many' => 'секунд', 'other' => 'секунды', 'aliases' => ['с']],
    'A' => ['one' => 'ампер', 'many' => 'ампер', 'other' => 'ампера'],
    'K' => ['one' => 'кельвин', 'many' => 'кельвинов', 'other' => 'кельвина'],
    'mol' => ['one' => 'моль', 'many' => 'молей', 'other' => 'моля'],
    'cd' => ['one' => 'кандела', 'many' => 'кандел', 'other' => 'канделы'],
    'N' => ['one' => 'ньютон', 'many' => 'ньютонов', 'other' => 'ньютона'],
    'Pa' => ['one' => 'паскаль', 'many' => 'паскалей', 'other' => 'паскаля'],
    'J' => ['one' => 'джоуль', 'many' => 'джоулей', 'other' => 'джоуля'],
    'W' => ['one' => 'ватт', 'many' => 'ватт', 'other' => 'ватта'],
    'V' => ['one' => 'вольт', 'many' => 'вольт', 'other' => 'вольта'],
    'Ω' => ['one' => 'ом', 'many' => 'ом', 'other' => 'ома'],
    '°C' => ['one' => 'градус Цельсия', 'many' => 'градусов Цельсия', 'other' => 'градуса Цельсия'],
];
