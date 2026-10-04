<?php

namespace Knppy\Units\Exception;

use DomainException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when a conversion does not result in a whole number.
 */
final class InexactConversionException extends DomainException implements Exception {}
