<?php

namespace Knppy\Units;

/**
 * A metric prefix of the International System of Units, e.g. kilo (k) for 10^3.
 */
enum Prefix: string
{
    case Quetta = 'Q';
    case Ronna = 'R';
    case Yotta = 'Y';
    case Zetta = 'Z';
    case Exa = 'E';
    case Peta = 'P';
    case Tera = 'T';
    case Giga = 'G';
    case Mega = 'M';
    case Kilo = 'k';
    case Hecto = 'h';
    case Deca = 'da';
    case Deci = 'd';
    case Centi = 'c';
    case Milli = 'm';
    case Micro = 'µ';
    case Nano = 'n';
    case Pico = 'p';
    case Femto = 'f';
    case Atto = 'a';
    case Zepto = 'z';
    case Yocto = 'y';
    case Ronto = 'r';
    case Quecto = 'q';

    /**
     * Returns the prefix symbol, e.g. "k".
     */
    public function getSymbol(): string
    {
        return $this->value;
    }

    /**
     * Returns the lowercase prefix name, e.g. "kilo".
     */
    public function getName(): string
    {
        return strtolower($this->name);
    }

    /**
     * Returns the power of ten the prefix stands for, e.g. 3 for kilo.
     */
    public function getExponent(): int
    {
        return match ($this) {
            self::Quetta => 30,
            self::Ronna => 27,
            self::Yotta => 24,
            self::Zetta => 21,
            self::Exa => 18,
            self::Peta => 15,
            self::Tera => 12,
            self::Giga => 9,
            self::Mega => 6,
            self::Kilo => 3,
            self::Hecto => 2,
            self::Deca => 1,
            self::Deci => -1,
            self::Centi => -2,
            self::Milli => -3,
            self::Micro => -6,
            self::Nano => -9,
            self::Pico => -12,
            self::Femto => -15,
            self::Atto => -18,
            self::Zepto => -21,
            self::Yocto => -24,
            self::Ronto => -27,
            self::Quecto => -30,
        };
    }
}
