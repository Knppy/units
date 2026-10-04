<?php

use Knppy\Units\Calculator\BcMathCalculator;

it('compares numbers', function (string $a, string $b, int $expected) {
    expect(BcMathCalculator::compare($a, $b))->toBe($expected);
})->with([
    ['1', '2', -1],
    ['2', '1', 1],
    ['1.0', '1', 0],
    ['-1', '1', -1],
]);

it('adds', function (string $a, string $b, string $expected) {
    expect(BcMathCalculator::add($a, $b))->toBe($expected);
})->with([
    ['1', '2', '3'],
    ['1.5', '2.50', '4'],
    ['-1', '0.25', '-0.75'],
]);

it('subtracts', function (string $a, string $b, string $expected) {
    expect(BcMathCalculator::subtract($a, $b))->toBe($expected);
})->with([
    ['3', '1', '2'],
    ['1', '1.5', '-0.5'],
    ['1', '1', '0'],
]);

it('multiplies', function (string $a, string $b, string $expected) {
    expect(BcMathCalculator::multiply($a, $b))->toBe($expected);
})->with([
    ['1.5', '2', '3'],
    ['-2', '0.5', '-1'],
    ['0', '5', '0'],
]);

it('divides', function (string $a, string $b, string $expected) {
    expect(BcMathCalculator::divide($a, $b))->toBe($expected);
})->with([
    ['10', '4', '2.5'],
    ['1', '3', '0.33333333333333'],
    ['-9', '3', '-3'],
]);

it('rejects division by zero', function (string $method) {
    BcMathCalculator::$method('1', '0');
})->with(['divide', 'mod'])->throws(InvalidArgumentException::class);

it('ceils', function (string $n, string $expected) {
    expect(BcMathCalculator::ceil($n))->toBe($expected);
})->with([['1.2', '2'], ['-1.2', '-1'], ['3', '3']]);

it('floors', function (string $n, string $expected) {
    expect(BcMathCalculator::floor($n))->toBe($expected);
})->with([['1.8', '1'], ['-1.2', '-2'], ['100', '100']]);

it('returns the absolute value', function (string $n, string $expected) {
    expect(BcMathCalculator::absolute($n))->toBe($expected);
})->with([['-3.50', '3.5'], ['3', '3'], ['0', '0']]);

it('rounds using the rounding mode', function (string $n, int $mode, string $expected) {
    expect(BcMathCalculator::round($n, $mode))->toBe($expected);
})->with([
    ['2.5', PHP_ROUND_HALF_UP, '3'],
    ['-2.5', PHP_ROUND_HALF_UP, '-3'],
    ['2.5', PHP_ROUND_HALF_DOWN, '2'],
    ['-2.5', PHP_ROUND_HALF_DOWN, '-2'],
    ['2.5', PHP_ROUND_HALF_EVEN, '2'],
    ['3.5', PHP_ROUND_HALF_EVEN, '4'],
    ['2.5', PHP_ROUND_HALF_ODD, '3'],
    ['2.4', PHP_ROUND_HALF_UP, '2'],
]);

it('rejects unknown rounding modes', function () {
    BcMathCalculator::round('1.5', 99);
})->throws(InvalidArgumentException::class);

it('shares', function () {
    expect(BcMathCalculator::share('10', '1', '3'))->toBe('3.33333333333333')
        ->and(BcMathCalculator::share('10', '1', '2'))->toBe('5');
});

it('calculates the modulus', function (string $a, string $b, string $expected) {
    expect(BcMathCalculator::mod($a, $b))->toBe($expected);
})->with([['10', '3', '1'], ['10', '5', '0'], ['5.5', '2', '1.5']]);
