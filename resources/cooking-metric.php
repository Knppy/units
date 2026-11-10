<?php

use Knppy\Units\Quantity;

/**
 * Cooking units with the metric kitchen spoons and cup as used in the Netherlands and most of Europe: a teaspoon is
 * 5 ml, a tablespoon is 15 ml and a cup is 250 ml. Everything else is as in cooking.php.
 *
 * @var array<string, array{name: string, quantity: Quantity, ratio?: string}>
 */
$units = require __DIR__.'/cooking.php';

$units['tsp']['ratio'] = '5';
$units['tbsp']['ratio'] = '15';
$units['cup']['ratio'] = '250';

return $units;
