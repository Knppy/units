<?php

/**
 * Spanish names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'mililitro', 'other' => 'mililitros'],
    'l' => ['one' => 'litro', 'other' => 'litros'],
    'tsp' => ['one' => 'cucharadita', 'other' => 'cucharaditas', 'aliases' => ['cdta', 'cdita']],
    'tbsp' => ['one' => 'cucharada', 'other' => 'cucharadas', 'aliases' => ['cda', 'cucharada sopera', 'cucharadas soperas']],
    'fl oz' => ['one' => 'onza líquida', 'other' => 'onzas líquidas'],
    'cup' => ['one' => 'taza', 'other' => 'tazas'],
    'pt' => ['one' => 'pinta', 'other' => 'pintas'],
    'qt' => ['one' => 'cuarto de galón', 'other' => 'cuartos de galón'],
    'gal' => ['one' => 'galón', 'other' => 'galones'],

    // Mass
    'g' => ['one' => 'gramo', 'other' => 'gramos', 'aliases' => ['gr']],
    'oz' => ['one' => 'onza', 'other' => 'onzas'],
    'lb' => ['one' => 'libra', 'other' => 'libras'],

    // Imprecise amounts
    'pinch' => ['one' => 'pizca', 'other' => 'pizcas'],
    'dash' => ['one' => 'chorrito', 'other' => 'chorritos'],
    'smidgen' => ['one' => 'poquito', 'other' => 'poquitos'],
    'drop' => ['one' => 'gota', 'other' => 'gotas'],
    'splash' => ['one' => 'chorro', 'other' => 'chorros'],
    'handful' => ['one' => 'puñado', 'other' => 'puñados'],

    // Counts
    'clove' => ['one' => 'diente', 'other' => 'dientes'],
    'slice' => ['one' => 'rebanada', 'other' => 'rebanadas', 'aliases' => ['loncha', 'lonchas', 'rodaja', 'rodajas']],
    'piece' => ['one' => 'pieza', 'other' => 'piezas', 'aliases' => ['trozo', 'trozos']],
    'stick' => ['one' => 'barra', 'other' => 'barras'],
    'can' => ['one' => 'lata', 'other' => 'latas'],
    'package' => ['one' => 'paquete', 'other' => 'paquetes'],
    'bunch' => ['one' => 'manojo', 'other' => 'manojos', 'aliases' => ['ramo', 'ramos']],
    'sprig' => ['one' => 'ramita', 'other' => 'ramitas'],
];
