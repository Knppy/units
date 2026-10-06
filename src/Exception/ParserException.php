<?php

namespace Knppy\Units\Exception;

use InvalidArgumentException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when an input cannot be parsed into a unit.
 */
final class ParserException extends InvalidArgumentException implements Exception {}
