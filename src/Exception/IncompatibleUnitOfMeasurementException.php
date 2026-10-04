<?php

namespace Knppy\Units\Exception;

use InvalidArgumentException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when converting between units that do not share the same base unit.
 */
final class IncompatibleUnitOfMeasurementException extends InvalidArgumentException implements Exception {}
