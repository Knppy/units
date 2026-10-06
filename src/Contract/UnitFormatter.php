<?php

namespace Knppy\Units\Contract;

use Knppy\Units\Exception\FormatterException;
use Knppy\Units\Unit;

/**
 * Implement this to turn a unit into a string such as "5 kg".
 */
interface UnitFormatter
{
    /**
     * Formats the unit.
     *
     * @throws FormatterException
     */
    public function format(Unit $unit): string;
}
