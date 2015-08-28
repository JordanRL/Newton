<?php

namespace Samsara\Newton\Provider;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Acceleration;
use Samsara\Newton\Units\Energy;
use Samsara\Newton\Units\Force;
use Samsara\Newton\Units\Mass;
use Samsara\Newton\Units\Momentum;
use Samsara\Newton\Units\PhysicsConstants\Gravitation;
use Samsara\Newton\Units\Time;
use Samsara\Newton\Units\Length;
use Samsara\Newton\Units\Velocity;

class PhysicsProvider
{
    /**
     * Constant Acceleration Equation:
     *
     * s = 1/2 a t^2
     *
     * s = distance traveled
     * m = acceleration of object
     * t = time spent accelerating
     *
     * This method should be called with the TWO known values, in any order.
     *
     * eg.:
     *
     * PhysicsProvider::constantAccelCalcs($time, $length);
     * ...
     * PhysicsProvider::constantAccelCalcs($time, $acceleration);
     * ...
     * PhysicsProvider::constantAccelCalcs($length, $time);
     *
     * It returns the missing unit in the equation, with the value calculated based on the equation above, in native units.
     *
     * @param   Length[]|Time[]|Acceleration[]  ...$quantities
     * @return  Length|Time|Acceleration
     * @throws  \Exception
     */
    public static function constantAccelCalcs(...$quantities)
    {
        if (count($quantities) != 2) {
            throw new \Exception('The Constant Acceleration Equation needs exactly two of: Length, Time, Acceleration.');
        }

        $vals = [];

        foreach ($quantities as $unit) {
            if ($unit instanceof Length) {
                /** @var Length */
                $vals['length'] = $unit;
            } elseif ($unit instanceof Acceleration) {
                /** @var Acceleration */
                $vals['acceleration'] = $unit;
            } elseif ($unit instanceof Time) {
                /** @var Time */
                $vals['time'] = $unit;
            } else {
                throw new \Exception('Only Length, Time, and Acceleration are valid units for the Constant Acceleration Equation.');
            }
        }

        if (count($vals) != 2) {
            throw new \Exception('The Constant Acceleration Equation needs only one of each unit.');
        }

        if (array_key_exists('acceleration', $vals) && array_key_exists('time', $vals)) {
            /** @return Length */
            return $vals['acceleration']->multiplyBySquared($vals['time'])->preConvertedDivide(2);
        } elseif (array_key_exists('length', $vals) && array_key_exists('acceleration', $vals)) {
            /** @return Time */
            return $vals['length']->squareRoot([2], [$vals['acceleration']]);
        } else {
            /** @return Acceleration */
            return $vals['length']->divideBySquared($vals['time'])->preConvertedMultiply(2);
        }
    }

    /**
     * Force-Mass-Acceleration Equation: (Newton's Second Law)
     *
     * F = m a
     *
     * This is the same as the Force equation.
     *
     * This method should be called with the TWO known values, in any order.
     *
     * eg.:
     *
     * PhysicsProvider::forceMassAccelCalcs($mass, $force);
     * ...
     * PhysicsProvider::forceMassAccelCalcs($acceleration, $mass);
     * ...
     * PhysicsProvider::forceMassAccelCalcs($force, $mass);
     *
     * It returns the missing unit in the equation, with the value calculated based on the equation above, in native units.
     *
     * @param   Mass[]|Force[]|Acceleration[]   ...$quantities
     * @return  Mass|Force|Acceleration
     * @throws  \Exception
     */
    public static function forceMassAccelCalcs(...$quantities)
    {
        if (count($quantities) != 2) {
            throw new \Exception('The Thrust-Mass Equation needs exactly two of: Force, Mass, Acceleration.');
        }

        $vals = [];

        foreach ($quantities as $unit) {
            if ($unit instanceof Mass) {
                /** @var Mass */
                $vals['mass'] = $unit;
            } elseif ($unit instanceof Force) {
                /** @var Force */
                $vals['force'] = $unit;
            } elseif ($unit instanceof Acceleration) {
                /** @var Acceleration */
                $vals['acceleration'] = $unit;
            } else {
                throw new \Exception('Only Mass, Force, and Acceleration are valid units for the Thrust-Mass Equation.');
            }
        }

        if (count($vals) != 2) {
            throw new \Exception('The Thrust-Mass Equation needs only one of each unit.');
        }

        if (array_key_exists('mass', $vals) && array_key_exists('force', $vals)) {
            /** @return Acceleration */
            return $vals['force']->divideBy($vals['mass']);
        } elseif (array_key_exists('mass', $vals) && array_key_exists('acceleration', $vals)) {
            /** @return Force */
            return $vals['acceleration']->multiplyBy($vals['mass']);
        } else {
            /** @return Mass */
            return $vals['force']->divideBy($vals['acceleration']);
        }
    }

    /**
     * Kinetic Energy Equation:
     *
     * K = 1/2 m v^2
     *
     * This method should be called with the TWO known values, in any order.
     *
     * eg.:
     *
     * PhysicsProvider::kineticEnergyCalcs($mass, $energy);
     * ...
     * PhysicsProvider::kineticEnergyCalcs($energy, $velocity);
     * ...
     * PhysicsProvider::kineticEnergyCalcs($velocity, $mass);
     *
     * It returns the missing unit in the equation, with the value calculated based on the equation above, in native units.
     *
     * @param   Energy[]|Velocity[]|Mass[]  ...$quantities
     * @return  Energy|Velocity|Mass
     * @throws  \Exception
     */
    public static function kineticEnergyCalcs(...$quantities)
    {
        if (count($quantities) != 2) {
            throw new \Exception('The Kinetic Energy Equation needs exactly two of: Mass, Velocity, Energy.');
        }

        $vals = [];

        foreach ($quantities as $unit) {
            if ($unit instanceof Mass) {
                /** @var Mass */
                $vals['mass'] = $unit;
            } elseif ($unit instanceof Velocity) {
                /** @var Velocity */
                $vals['velocity'] = $unit;
            } elseif ($unit instanceof Energy) {
                /** @var Mass */
                $vals['energy'] = $unit;
            } else {
                throw new \Exception('Only Mass, Velocity, and Energy are valid units for the Kinetic Energy Equation.');
            }
        }

        if (count($vals) != 2) {
            throw new \Exception('The Kinetic Energy Equation needs only one of each unit.');
        }

        if (array_key_exists('mass', $vals) && array_key_exists('velocity', $vals)) {
            /** @return Energy */
            return $vals['mass']->multiplyBySquared($vals['velocity'])->preConvertedDivide(2);
        } elseif (array_key_exists('mass', $vals) && array_key_exists('energy', $vals)) {
            /** @return Velocity */
            return $vals['energy']->squareRoot([2], [$vals['mass']]);
        } else {
            /** @return Mass */
            return $vals['energy']->divideBySquared($vals['velocity'])->preConvertedMultiply(2);
        }
    }

    /**
     * Momentum Equation:
     *
     * p = m v
     *
     * This method should be called with the TWO known values, in any order.
     *
     * eg.:
     *
     * PhysicsProvider::momentumCalcs($mass, $velocity);
     * ...
     * PhysicsProvider::momentumCalcs($momentum, $mass);
     * ...
     * PhysicsProvider::momentumCalcs($velocity, $momentum);
     *
     * It returns the missing unit in the equation, with the value calculated based on the equation above, in native units.
     *
     * @param   Momentum[]|Velocity[]|Mass[]  ...$quantities
     * @return  Momentum|Velocity|Mass
     * @throws  \Exception
     */
    public static function momentumCalcs(...$quantities)
    {
        if (count($quantities) != 2) {
            throw new \Exception('The Momentum Equation needs exactly two of: Mass, Velocity, Momentum.');
        }

        $vals = [];

        foreach ($quantities as $unit) {
            if ($unit instanceof Mass) {
                /** @var Mass */
                $vals['mass'] = $unit;
            } elseif ($unit instanceof Velocity) {
                /** @var Velocity */
                $vals['velocity'] = $unit;
            } elseif ($unit instanceof Momentum) {
                /** @var Momentum */
                $vals['momentum'] = $unit;
            } else {
                throw new \Exception('Only Mass, Velocity, and Momentum are valid units for the Momentum Equation.');
            }
        }

        if (count($vals) != 2) {
            throw new \Exception('The Momentum Equation needs only one of each unit.');
        }

        if (array_key_exists('mass', $vals) && array_key_exists('velocity', $vals)) {
            /** @return Momentum */
            return $vals['mass']->multiplyBy($vals['velocity']);
        } elseif (array_key_exists('mass', $vals) && array_key_exists('momentum', $vals)) {
            /** @return Velocity */
            return $vals['momentum']->divideBy($vals['mass']);
        } else {
            /** @return Mass */
            return $vals['momentum']->divideBy($vals['velocity']);
        }
    }

    /**
     * Universal Gravitation Equation:
     *
     * A = (G m1 m2)/ r^2
     *
     * @param   Mass[]|Acceleration[]|Length[]  ...$quantities
     * @return  Mass|Acceleration|Length
     * @throws  \Exception
     */
    public static function universalGravitation(...$quantities)
    {
        if (count($quantities) != 3) {
            throw new \Exception('The Universal Gravitation Equation requires at least three given units to calculate something.');
        }

        $vals = [];

        foreach ($quantities as $unit) {
            if ($unit instanceof Mass) {
                /** @var Mass */
                $vals['mass'][] = $unit;
            } elseif ($unit instanceof Length) {
                /** @var Length */
                $vals['length'] = $unit;
            } elseif ($unit instanceof Acceleration) {
                /** @var Acceleration */
                $vals['acceleration'] = $unit;
            } else {
                throw new \Exception('Only Mass, Acceleration and Length valid units for the Universal Gravitation Equation.');
            }
        }

        $gravitation = new Gravitation();

        $unitComposition = new UnitComposition();

        if (array_key_exists('mass', $vals) && count($vals['mass']) == 2) {
            if (array_key_exists('length', $vals)) {
                /** @return Acceleration */
                return $unitComposition->naiveMultiOpt([$gravitation, $vals['mass'][0], $vals['mass'][1]], [$vals['length'], $vals['length']]);
            } else {
                /** @return Length */
                return $gravitation->squareRoot([$vals['mass'][0], $vals['mass'][1]], [$vals['acceleration']]);
            }
        } else {
            /** @return Mass */
            return $unitComposition->naiveMultiOpt([$vals['acceleration'], $vals['length'], $vals['length']], [$gravitation, $vals['mass'][0]]);
        }
    }

}