<?php

namespace Knppy\Units\UnitOfMeasurements;

use ArrayIterator;
use Knppy\Units\Contract\UnitOfMeasurements;
use Knppy\Units\Exception\UnknownUnitOfMeasurementException;
use Knppy\Units\Quantity;
use Knppy\Units\UnitOfMeasurement;
use RuntimeException;
use Traversable;

/**
 * Unit of measurements defined in a resource file, keyed by symbol.
 *
 * @phpstan-type Definition array{name: string, quantity: Quantity}
 */
abstract class ResourceUnitOfMeasurements implements UnitOfMeasurements
{
    /**
     * Loaded definitions, per resource file.
     *
     * @var array<string, array<string, array<string, mixed>>>
     */
    private static array $loaded = [];

    /**
     * Returns the file name of the resource inside the resources directory, e.g. "si.php".
     */
    abstract protected function resource(): string;

    /**
     * {@inheritDoc}
     */
    public function contains(UnitOfMeasurement $unitOfMeasurement): bool
    {
        return isset($this->definitions()[$unitOfMeasurement->getSymbol()]);
    }

    /**
     * {@inheritDoc}
     */
    public function nameFor(UnitOfMeasurement $unitOfMeasurement): string
    {
        return $this->definitionFor($unitOfMeasurement)['name'];
    }

    /**
     * {@inheritDoc}
     */
    public function quantityFor(UnitOfMeasurement $unitOfMeasurement): Quantity
    {
        return $this->definitionFor($unitOfMeasurement)['quantity'];
    }

    /**
     * {@inheritDoc}
     *
     * @return Traversable<int, UnitOfMeasurement>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator(
            array_map(
                static fn (string $symbol) => new UnitOfMeasurement($symbol),
                array_map('strval', array_keys($this->definitions()))
            )
        );
    }

    /**
     * Returns the definition of a unit of measurement.
     *
     * @return array<string, mixed>
     *
     * @throws UnknownUnitOfMeasurementException
     */
    protected function definitionFor(UnitOfMeasurement $unitOfMeasurement): array
    {
        if (! $this->contains($unitOfMeasurement)) {
            throw new UnknownUnitOfMeasurementException('Cannot find unit of measurement '.$unitOfMeasurement->getSymbol());
        }

        return $this->definitions()[$unitOfMeasurement->getSymbol()];
    }

    /**
     * Returns the definitions, loading them on first use.
     *
     * @return array<string, array<string, mixed>>
     */
    private function definitions(): array
    {
        return self::$loaded[$this->resource()] ??= $this->load();
    }

    /**
     * Loads the definitions from the resource file.
     *
     * @return array<string, array<string, mixed>>
     *
     * @throws RuntimeException
     */
    private function load(): array
    {
        $file = __DIR__.'/../../resources/'.$this->resource();

        if (is_file($file)) {
            return require $file;
        }

        throw new RuntimeException('Failed to load unit of measurements from '.$this->resource().'.');
    }
}
