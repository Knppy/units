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
 * List of International System of Units (base units and derived units with special names).
 */
class SIUnitOfMeasurements implements UnitOfMeasurements
{
    /**
     * Map of known unit of measurements, keyed by symbol.
     *
     * @var array<string, array{name: string, quantity: Quantity}>|null
     */
    private static ?array $unitOfMeasurements = null;

    /**
     * {@inheritDoc}
     */
    public function contains(UnitOfMeasurement $unitOfMeasurement): bool
    {
        return isset($this->getUnitOfMeasurements()[$unitOfMeasurement->getSymbol()]);
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
                array_map('strval', array_keys($this->getUnitOfMeasurements()))
            )
        );
    }

    /**
     * Returns the name and quantity of a unit of measurement.
     *
     * @return array{name: string, quantity: Quantity}
     *
     * @throws UnknownUnitOfMeasurementException
     */
    private function definitionFor(UnitOfMeasurement $unitOfMeasurement): array
    {
        if (! $this->contains($unitOfMeasurement)) {
            throw new UnknownUnitOfMeasurementException('Cannot find unit of measurement '.$unitOfMeasurement->getSymbol());
        }

        return $this->getUnitOfMeasurements()[$unitOfMeasurement->getSymbol()];
    }

    /**
     * Returns the known unit of measurements, loading them on first use.
     *
     * @return array<string, array{name: string, quantity: Quantity}>
     */
    private function getUnitOfMeasurements(): array
    {
        return self::$unitOfMeasurements ??= $this->loadUnitOfMeasurements();
    }

    /**
     * Loads the unit of measurements from the resource file.
     *
     * @return array<string, array{name: string, quantity: Quantity}>
     *
     * @throws RuntimeException
     */
    private function loadUnitOfMeasurements(): array
    {
        $file = __DIR__.'/../../resources/si.php';

        if (is_file($file)) {
            return require $file;
        }

        throw new RuntimeException('Failed to load SI unit of measurements.');
    }
}
