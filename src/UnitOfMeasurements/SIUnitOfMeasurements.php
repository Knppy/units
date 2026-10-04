<?php

namespace Knppy\Units\UnitOfMeasurements;

/**
 * List of International System of Units (base units and derived units with special names).
 */
class SIUnitOfMeasurements extends ResourceUnitOfMeasurements
{
    /**
     * {@inheritDoc}
     */
    protected function resource(): string
    {
        return 'si.php';
    }
}
