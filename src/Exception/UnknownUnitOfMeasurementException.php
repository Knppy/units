<?php

namespace Knppy\Units\Exception;

use DomainException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when trying to get a unit of measurement that does not exists.
 */
final class UnknownUnitOfMeasurementException extends DomainException implements Exception {}
