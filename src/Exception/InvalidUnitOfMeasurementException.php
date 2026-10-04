<?php

namespace Knppy\Units\Exception;

use InvalidArgumentException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when a unit of measurement cannot be created from the given symbol.
 */
final class InvalidUnitOfMeasurementException extends InvalidArgumentException implements Exception {}
