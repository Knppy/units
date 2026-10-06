<?php

namespace Knppy\Units\Exception;

use InvalidArgumentException;
use Knppy\Units\Contract\Exception;

/**
 * Thrown when a unit cannot be formatted.
 */
final class FormatterException extends InvalidArgumentException implements Exception {}
