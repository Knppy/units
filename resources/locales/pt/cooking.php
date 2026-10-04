<?php

/**
 * Portuguese names of cooking units, keyed by symbol.
 *
 * @var array<string, array{one: string, other: string, aliases?: list<string>}>
 */
return [
    // Volume
    'ml' => ['one' => 'mililitro', 'other' => 'mililitros'],
    'l' => ['one' => 'litro', 'other' => 'litros'],
    'tsp' => ['one' => 'colher de chá', 'other' => 'colheres de chá', 'aliases' => ['cc', 'colher de cha', 'colheres de cha']],
    'tbsp' => ['one' => 'colher de sopa', 'other' => 'colheres de sopa', 'aliases' => ['cs']],
    'fl oz' => ['one' => 'onça fluida', 'other' => 'onças fluidas'],
    'cup' => ['one' => 'xícara', 'other' => 'xícaras', 'aliases' => ['chávena', 'chávenas']],
    'pt' => ['one' => 'pinta', 'other' => 'pintas'],
    'qt' => ['one' => 'quarto de galão', 'other' => 'quartos de galão'],
    'gal' => ['one' => 'galão', 'other' => 'galões'],

    // Mass
    'g' => ['one' => 'grama', 'other' => 'gramas', 'aliases' => ['gr']],
    'oz' => ['one' => 'onça', 'other' => 'onças'],
    'lb' => ['one' => 'libra', 'other' => 'libras'],

    // Imprecise amounts
    'pinch' => ['one' => 'pitada', 'other' => 'pitadas'],
    'dash' => ['one' => 'fio', 'other' => 'fios'],
    'smidgen' => ['one' => 'pouquinho', 'other' => 'pouquinhos'],
    'drop' => ['one' => 'gota', 'other' => 'gotas'],
    'splash' => ['one' => 'jorro', 'other' => 'jorros', 'aliases' => ['esguicho', 'esguichos']],
    'handful' => ['one' => 'punhado', 'other' => 'punhados', 'aliases' => ['mão cheia']],

    // Counts
    'clove' => ['one' => 'dente', 'other' => 'dentes'],
    'slice' => ['one' => 'fatia', 'other' => 'fatias'],
    'piece' => ['one' => 'pedaço', 'other' => 'pedaços', 'aliases' => ['peça', 'peças']],
    'stick' => ['one' => 'barra', 'other' => 'barras', 'aliases' => ['tablete', 'tabletes']],
    'can' => ['one' => 'lata', 'other' => 'latas'],
    'package' => ['one' => 'pacote', 'other' => 'pacotes', 'aliases' => ['embalagem', 'embalagens']],
    'bunch' => ['one' => 'maço', 'other' => 'maços'],
    'sprig' => ['one' => 'ramo', 'other' => 'ramos', 'aliases' => ['raminho', 'raminhos']],
];
