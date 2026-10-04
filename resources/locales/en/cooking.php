<?php

/**
 * English names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'millilitre', 'other' => 'millilitres', 'aliases' => ['milliliter', 'milliliters']],
    'l' => ['one' => 'litre', 'other' => 'litres', 'aliases' => ['liter', 'liters']],
    'tsp' => ['one' => 'teaspoon', 'other' => 'teaspoons'],
    'tbsp' => ['one' => 'tablespoon', 'other' => 'tablespoons', 'aliases' => ['tbs', 'tbl']],
    'fl oz' => ['one' => 'fluid ounce', 'other' => 'fluid ounces', 'aliases' => ['floz']],
    'cup' => ['one' => 'cup', 'other' => 'cups'],
    'pt' => ['one' => 'pint', 'other' => 'pints'],
    'qt' => ['one' => 'quart', 'other' => 'quarts'],
    'gal' => ['one' => 'gallon', 'other' => 'gallons'],

    // Mass
    'g' => ['one' => 'gram', 'other' => 'grams', 'aliases' => ['gramme', 'grammes']],
    'oz' => ['one' => 'ounce', 'other' => 'ounces'],
    'lb' => ['one' => 'pound', 'other' => 'pounds', 'aliases' => ['lbs']],

    // Imprecise amounts
    'pinch' => ['one' => 'pinch', 'other' => 'pinches'],
    'dash' => ['one' => 'dash', 'other' => 'dashes'],
    'smidgen' => ['one' => 'smidgen', 'other' => 'smidgens', 'aliases' => ['smidge']],
    'drop' => ['one' => 'drop', 'other' => 'drops'],
    'splash' => ['one' => 'splash', 'other' => 'splashes'],
    'handful' => ['one' => 'handful', 'other' => 'handfuls'],

    // Counts
    'clove' => ['one' => 'clove', 'other' => 'cloves'],
    'slice' => ['one' => 'slice', 'other' => 'slices'],
    'piece' => ['one' => 'piece', 'other' => 'pieces', 'aliases' => ['pc', 'pcs']],
    'stick' => ['one' => 'stick', 'other' => 'sticks'],
    'can' => ['one' => 'can', 'other' => 'cans', 'aliases' => ['tin', 'tins']],
    'package' => ['one' => 'package', 'other' => 'packages', 'aliases' => ['pack', 'packs', 'packet', 'packets']],
    'bunch' => ['one' => 'bunch', 'other' => 'bunches'],
    'sprig' => ['one' => 'sprig', 'other' => 'sprigs'],
];
