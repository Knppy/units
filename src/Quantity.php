<?php

namespace Knppy\Units;

/**
 * Physical quantity measured by a unit of measurement.
 */
enum Quantity: string
{
    case Length = 'length';
    case Mass = 'mass';
    case Time = 'time';
    case ElectricCurrent = 'electric current';
    case ThermodynamicTemperature = 'thermodynamic temperature';
    case AmountOfSubstance = 'amount of substance';
    case LuminousIntensity = 'luminous intensity';
    case PlaneAngle = 'plane angle';
    case SolidAngle = 'solid angle';
    case Frequency = 'frequency';
    case Force = 'force';
    case Pressure = 'pressure';
    case Energy = 'energy';
    case Power = 'power';
    case ElectricCharge = 'electric charge';
    case ElectricPotential = 'electric potential';
    case Capacitance = 'capacitance';
    case ElectricResistance = 'electric resistance';
    case ElectricalConductance = 'electrical conductance';
    case MagneticFlux = 'magnetic flux';
    case MagneticFluxDensity = 'magnetic flux density';
    case Inductance = 'inductance';
    case Temperature = 'temperature relative to 273.15 K';
    case LuminousFlux = 'luminous flux';
    case Illuminance = 'illuminance';
    case Radioactivity = 'radioactivity';
    case AbsorbedDose = 'absorbed dose of ionizing radiation';
    case EquivalentDose = 'equivalent dose of ionizing radiation';
    case CatalyticActivity = 'catalytic activity';
    case Volume = 'volume';
    case Count = 'count';
    case ImpreciseAmount = 'imprecise amount';
}
