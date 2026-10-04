<?php

use Knppy\Units\Prefix;

it('has all 24 SI prefixes', function () {
    expect(Prefix::cases())->toHaveCount(24);
});

it('knows its symbol, name and exponent', function (string $symbol, string $name, int $exponent) {
    $prefix = Prefix::from($symbol);

    expect($prefix->getSymbol())->toBe($symbol)
        ->and($prefix->getName())->toBe($name)
        ->and($prefix->getExponent())->toBe($exponent);
})->with([
    ['Q', 'quetta', 30], ['R', 'ronna', 27], ['Y', 'yotta', 24], ['Z', 'zetta', 21],
    ['E', 'exa', 18], ['P', 'peta', 15], ['T', 'tera', 12], ['G', 'giga', 9],
    ['M', 'mega', 6], ['k', 'kilo', 3], ['h', 'hecto', 2], ['da', 'deca', 1],
    ['d', 'deci', -1], ['c', 'centi', -2], ['m', 'milli', -3], ['µ', 'micro', -6],
    ['n', 'nano', -9], ['p', 'pico', -12], ['f', 'femto', -15], ['a', 'atto', -18],
    ['z', 'zepto', -21], ['y', 'yocto', -24], ['r', 'ronto', -27], ['q', 'quecto', -30],
]);
