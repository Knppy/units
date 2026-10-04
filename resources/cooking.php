<?php

use Knppy\Units\Quantity;

/**
 * Cooking units.
 *
 * Maps each symbol to its name and the quantity it measures. Volumes and masses are US customary and carry an exact
 * ratio: millilitres per unit for volumes, grams per unit for masses. Units without a ratio have no fixed size and
 * cannot be converted.
 *
 * @var array<string, array{name: string, quantity: Quantity, ratio?: string}>
 */
return [
    // Volume
    'ml' => ['name' => 'millilitre', 'quantity' => Quantity::Volume, 'ratio' => '1'],
    'l' => ['name' => 'litre', 'quantity' => Quantity::Volume, 'ratio' => '1000'],
    'tsp' => ['name' => 'teaspoon', 'quantity' => Quantity::Volume, 'ratio' => '4.92892159375'],
    'tbsp' => ['name' => 'tablespoon', 'quantity' => Quantity::Volume, 'ratio' => '14.78676478125'],
    'fl oz' => ['name' => 'fluid ounce', 'quantity' => Quantity::Volume, 'ratio' => '29.5735295625'],
    'cup' => ['name' => 'cup', 'quantity' => Quantity::Volume, 'ratio' => '236.5882365'],
    'pt' => ['name' => 'pint', 'quantity' => Quantity::Volume, 'ratio' => '473.176473'],
    'qt' => ['name' => 'quart', 'quantity' => Quantity::Volume, 'ratio' => '946.352946'],
    'gal' => ['name' => 'gallon', 'quantity' => Quantity::Volume, 'ratio' => '3785.411784'],

    // Mass
    'g' => ['name' => 'gram', 'quantity' => Quantity::Mass, 'ratio' => '1'],
    'oz' => ['name' => 'ounce', 'quantity' => Quantity::Mass, 'ratio' => '28.349523125'],
    'lb' => ['name' => 'pound', 'quantity' => Quantity::Mass, 'ratio' => '453.59237'],

    // Imprecise amounts
    'pinch' => ['name' => 'pinch', 'quantity' => Quantity::ImpreciseAmount],
    'dash' => ['name' => 'dash', 'quantity' => Quantity::ImpreciseAmount],
    'smidgen' => ['name' => 'smidgen', 'quantity' => Quantity::ImpreciseAmount],
    'drop' => ['name' => 'drop', 'quantity' => Quantity::ImpreciseAmount],
    'splash' => ['name' => 'splash', 'quantity' => Quantity::ImpreciseAmount],
    'handful' => ['name' => 'handful', 'quantity' => Quantity::ImpreciseAmount],

    // Counts
    'clove' => ['name' => 'clove', 'quantity' => Quantity::Count],
    'slice' => ['name' => 'slice', 'quantity' => Quantity::Count],
    'piece' => ['name' => 'piece', 'quantity' => Quantity::Count],
    'stick' => ['name' => 'stick', 'quantity' => Quantity::Count],
    'can' => ['name' => 'can', 'quantity' => Quantity::Count],
    'package' => ['name' => 'package', 'quantity' => Quantity::Count],
    'bunch' => ['name' => 'bunch', 'quantity' => Quantity::Count],
    'sprig' => ['name' => 'sprig', 'quantity' => Quantity::Count],
];
