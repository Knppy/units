<?php

namespace Knppy\Units\Exception;

use InvalidArgumentException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when a unit amount is not a valid integer.
 */
final class InvalidAmountException extends InvalidArgumentException implements Exception {}
