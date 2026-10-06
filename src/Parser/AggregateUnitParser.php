<?php

namespace Knppy\Units\Parser;

use Knppy\Units\Contract\UnitParser;
use Knppy\Units\Exception\ParserException;
use Knppy\Units\Unit;
use Knppy\Units\UnitOfMeasurement;

/**
 * Tries each parser in order and returns the first result.
 *
 * Put stricter parsers first, since {@see SymbolUnitParser} accepts any symbol.
 */
final class AggregateUnitParser implements UnitParser
{
    /**
     * @param  non-empty-list<UnitParser>  $parsers
     */
    public function __construct(private readonly array $parsers) {}

    /**
     * {@inheritDoc}
     */
    public function parse(string $input, ?UnitOfMeasurement $fallbackUnitOfMeasurement = null): Unit
    {
        foreach ($this->parsers as $parser) {
            try {
                return $parser->parse($input, $fallbackUnitOfMeasurement);
            } catch (ParserException) {
                // Try the next parser.
            }
        }

        throw new ParserException('Unable to parse "'.$input.'" with any of the parsers.');
    }
}
