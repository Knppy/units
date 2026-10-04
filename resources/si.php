<?php

use Knppy\Units\Quantity;

/**
 * International System of Units (SI): base units and derived units with special names.
 *
 * Maps each symbol to its name and the physical quantity it measures.
 *
 * @var array<string, array{name: string, quantity: Quantity}>
 */
return [
    // Base units
    'm' => ['name' => 'metre', 'quantity' => Quantity::Length],
    'kg' => ['name' => 'kilogram', 'quantity' => Quantity::Mass],
    's' => ['name' => 'second', 'quantity' => Quantity::Time],
    'A' => ['name' => 'ampere', 'quantity' => Quantity::ElectricCurrent],
    'K' => ['name' => 'kelvin', 'quantity' => Quantity::ThermodynamicTemperature],
    'mol' => ['name' => 'mole', 'quantity' => Quantity::AmountOfSubstance],
    'cd' => ['name' => 'candela', 'quantity' => Quantity::LuminousIntensity],

    // Derived units with special names
    'rad' => ['name' => 'radian', 'quantity' => Quantity::PlaneAngle],
    'sr' => ['name' => 'steradian', 'quantity' => Quantity::SolidAngle],
    'Hz' => ['name' => 'hertz', 'quantity' => Quantity::Frequency],
    'N' => ['name' => 'newton', 'quantity' => Quantity::Force],
    'Pa' => ['name' => 'pascal', 'quantity' => Quantity::Pressure],
    'J' => ['name' => 'joule', 'quantity' => Quantity::Energy],
    'W' => ['name' => 'watt', 'quantity' => Quantity::Power],
    'C' => ['name' => 'coulomb', 'quantity' => Quantity::ElectricCharge],
    'V' => ['name' => 'volt', 'quantity' => Quantity::ElectricPotential],
    'F' => ['name' => 'farad', 'quantity' => Quantity::Capacitance],
    'Ω' => ['name' => 'ohm', 'quantity' => Quantity::ElectricResistance],
    'S' => ['name' => 'siemens', 'quantity' => Quantity::ElectricalConductance],
    'Wb' => ['name' => 'weber', 'quantity' => Quantity::MagneticFlux],
    'T' => ['name' => 'tesla', 'quantity' => Quantity::MagneticFluxDensity],
    'H' => ['name' => 'henry', 'quantity' => Quantity::Inductance],
    '°C' => ['name' => 'degree Celsius', 'quantity' => Quantity::Temperature],
    'lm' => ['name' => 'lumen', 'quantity' => Quantity::LuminousFlux],
    'lx' => ['name' => 'lux', 'quantity' => Quantity::Illuminance],
    'Bq' => ['name' => 'becquerel', 'quantity' => Quantity::Radioactivity],
    'Gy' => ['name' => 'gray', 'quantity' => Quantity::AbsorbedDose],
    'Sv' => ['name' => 'sievert', 'quantity' => Quantity::EquivalentDose],
    'kat' => ['name' => 'katal', 'quantity' => Quantity::CatalyticActivity],
];
