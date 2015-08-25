<?php

namespace Samsara\Newton\Provider;

use Samsara\Newton\Units\Acceleration;
use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Force;
use Samsara\Newton\Units\Mass;
use Samsara\Newton\Units\Time;
use Samsara\Newton\Units\Length;

class PhysicsProvider
{

    /**
     * @param Time                  $time
     * @param Acceleration          $acceleration
     * @param UnitComposition|null  $unitComposition
     *
     * @return Length
     */
    public static function distanceFromConstantAccel(Time $time, Acceleration $acceleration, UnitComposition $unitComposition = null)
    {
        if (is_null($unitComposition)) {
            $unitComposition = new UnitComposition();
        }

        /** @var Length $distance */
        $distance = $unitComposition->naiveMultiOpt([$time, $time, $acceleration], []);

        return $distance->preConvertedSubtract(MathProvider::divide($distance->getValue(), 2));
    }

    /**
     * @param Length                $distance
     * @param Acceleration          $acceleration
     * @param UnitComposition|null  $unitComposition
     *
     * @return Time
     */
    public static function timeFromConstantAccel(Length $distance, Acceleration $acceleration, UnitComposition $unitComposition = null)
    {
        if (is_null($unitComposition)) {
            $unitComposition = new UnitComposition();
        }

        $distance->toNative();
        $acceleration->toNative();

        return new Time(MathProvider::squareRoot(MathProvider::multipleMultiply(2, $distance->getValue(), $acceleration->getValue())), $unitComposition);
    }

    /**
     * @param Force $thrust
     * @param Mass  $mass
     * @param int   $precision
     *
     * @return Acceleration
     */
    public static function accelFromThrustAndMass(Force $thrust, Mass $mass, $precision = 2)
    {
        return $thrust->divideBy($mass, $precision);
    }

}