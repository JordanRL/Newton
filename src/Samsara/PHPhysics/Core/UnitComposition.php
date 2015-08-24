<?php

namespace Samsara\PHPhysics\Core;

use Samsara\PHPhysics\Units\Ampere;
use Samsara\PHPhysics\Units\Charge;
use Samsara\PHPhysics\Units\Density;
use Samsara\PHPhysics\Units\Energy;
use Samsara\PHPhysics\Units\Force;
use Samsara\PHPhysics\Units\Length;
use Samsara\PHPhysics\Units\Area;
use Samsara\PHPhysics\Units\Mass;
use Samsara\PHPhysics\Units\Power;
use Samsara\PHPhysics\Units\Pressure;
use Samsara\PHPhysics\Units\Velocity;
use Samsara\PHPhysics\Units\Acceleration;
use Samsara\PHPhysics\Units\Time;
use Samsara\PHPhysics\Units\Voltage;
use Samsara\PHPhysics\Units\Volume;
use Samsara\PHPhysics\Provider\MathProvider;

class UnitComposition
{
    const ACCELERATION  = 'Acceleration';
    const AMPERE        = 'Ampere';
    const AREA          = 'Area';
    const CHARGE        = 'Charge';
    const DENSITY       = 'Density';
    const ENERGY        = 'Energy';
    const FORCE         = 'Force';
    const LENGTH        = 'Length';
    const MASS          = 'Mass';
    const POWER         = 'Power';
    const PRESSURE      = 'Pressure';
    const TIME          = 'Time';
    const VELOCITY      = 'Velocity';
    const VOLTAGE       = 'Voltage';
    const VOLUME        = 'Volume';

    public $unitComp = [
        self::ACCELERATION => [
            'length' => 1,
            'time' => -2
        ],
        self::AMPERE => [
            'electricCurrent' => 1
        ],
        self::AREA => [
            'length' => 2
        ],
        self::CHARGE => [
            'electricCurrent' => 1,
            'time' => 1
        ],
        self::DENSITY => [
            'mass' => 1,
            'length' => -3
        ],
        self::ENERGY => [
            'mass' => 1,
            'length' => 2,
            'time' => -2
        ],
        self::FORCE => [
            'mass' => 1,
            'length' => 1,
            'time' => -2
        ],
        self::LENGTH => [
            'length' => 1
        ],
        self::MASS => [
            'mass' => 1
        ],
        self::POWER => [
            'mass' => 1,
            'length' => 2,
            'time' => -3
        ],
        self::PRESSURE => [
            'mass' => 1,
            'length' => -1,
            'time' => -2
        ],
        self::TIME => [
            'time' => 1
        ],
        self::VELOCITY => [
            'length' => 1,
            'time' => -1
        ],
        self::VOLTAGE => [
            'mass' => 1,
            'length' => 2,
            'electricCurrent' => -1,
            'time' => -3
        ],
        self::VOLUME => [
            'length' => 3
        ]
    ];

    public $dynamicUnits = [];

    /**
     * @param string    $class
     * @param array     $composition
     * @param string    $key
     * @return $this
     * @throws \Exception
     */
    public function addUnit($class, array $composition, $key)
    {
        if (array_key_exists($key, $this->unitComp)) {
            throw new \Exception('Cannot add unit '.$class.' with key '.$key.' because that key is already being used.');
        }

        $this->unitComp[$key] = $composition;
        $this->dynamicUnits[$key] = $class;

        return $this;
    }

    /**
     * @param Quantity[] $numerators
     * @param Quantity[] $denominators
     */
    public function getMultiUnits(array $numerators, array $denominators)
    {
        $unitComp = [];

        foreach ($numerators as $unit) {
            foreach ($unit->getUnitsPresent() as $unitType => $unitCount) {
                if ($unitCount != 0) {
                    $unitComp[$unitType] += $unitCount;
                }
            }
        }

        foreach ($denominators as $unit) {
            foreach ($unit->getUnitsPresent() as $unitType => $unitCount) {
                if ($unitCount != 0) {
                    $unitComp[$unitType] -= $unitCount;
                }
            }
        }

        return self::getUnitCompClass($unitComp);
    }

    public function getMultipliedUnit(Quantity $unit1, Quantity $unit2)
    {

        $unitComp = [];

        foreach ($unit1->getUnitsPresent() as $unitType => $unitCount) {
            if ($unitCount != 0) {
                $unitComp[$unitType] += $unitCount;
            }
        }

        foreach ($unit2->getUnitsPresent() as $unitType => $unitCount) {
            if ($unitCount != 0) {
                $unitComp[$unitType] += $unitCount;
            }
        }

        return self::getUnitCompClass($unitComp);
    }

    public function getDividedUnit(Quantity $numerator, Quantity $denominator)
    {
        $unitComp = [];

        foreach ($numerator->getUnitsPresent() as $unitType => $unitCount) {
            if ($unitCount != 0) {
                $unitComp[$unitType] += $unitCount;
            }
        }

        foreach ($denominator->getUnitsPresent() as $unitType => $unitCount) {
            if ($unitCount != 0) {
                $unitComp[$unitType] -= $unitCount;
            }
        }

        return self::getUnitCompClass($unitComp);
    }

    public function getUnitCompClass(array $comp)
    {
        return self::getUnitClass(self::getUnitCompName($comp));
    }

    public function getUnitCompName(array $comp)
    {
        foreach ($this->unitComp as $unit => $unitDef) {
            $diff = array_diff($comp, $unitDef);
            if (count($diff) === 0) {
                return $unit;
            }
        }

        throw new \Exception('Cannot match the unit definition to an existing unit.');
    }

    public function getUnitClass($unit, $value = 0)
    {
        switch ($unit) {
            case self::ACCELERATION:
                return new Acceleration($value, $this);

            case self::AMPERE:
                return new Ampere($value, $this);

            case self::AREA:
                return new Area($value, $this);

            case self::CHARGE:
                return new Charge($value, $this);

            case self::ENERGY:
                return new Energy($value, $this);

            case self::DENSITY:
                return new Density($value, $this);

            case self::FORCE:
                return new Force($value, $this);

            case self::LENGTH:
                return new Length($value, $this);

            case self::MASS:
                return new Mass($value, $this);

            case self::POWER:
                return new Power($value, $this);

            case self::PRESSURE:
                return new Pressure($value, $this);

            case self::TIME:
                return new Time($value, $this);

            case self::VELOCITY:
                return new Velocity($value, $this);

            case self::VOLTAGE:
                return new Voltage($value, $this);

            case self::VOLUME:
                return new Volume($value, $this);

            default:
                if (array_key_exists($unit, $this->dynamicUnits)) {
                    $class = new \ReflectionClass($this->dynamicUnits[$unit]);

                    if ($class->getExtensionName() == 'Samsara\\PHPhysics\\Core\\Quantity') {
                        return $class->newInstance($value, $this);
                    } else {
                        throw new \Exception('Valid units must extend the Quantity class.');
                    }
                }
                throw new \Exception('Unknown unit type: '.$unit);
        }
    }

    public function naiveMultiply(Quantity $unit1, Quantity $unit2)
    {
        $newUnit = self::getMultipliedUnit($unit1, $unit2);

        $newVal = MathProvider::multiply($unit1->toNative()->getValue(), $unit2->toNative()->getValue());

        return $newUnit->preConvertedAdd($newVal);
    }

    public function naiveDivide(Quantity $numerator, Quantity $denominator, $precision = 2)
    {
        $newUnit = self::getDividedUnit($numerator, $denominator);

        $newVal = MathProvider::divide($numerator->toNative()->getValue(), $denominator->toNative()->getValue(), $precision);

        return $newUnit->preConvertedAdd($newVal);
    }

    /**
     * @param Quantity[] $mults
     * @param Quantity[] $divides
     * @param int        $precision
     */
    public function naiveMultiOpt(array $mults, array $divides, $precision = 2)
    {
        $newUnit = self::getMultiUnits($mults, $divides);

        $newVal = 1;

        foreach ($mults as $quantity) {
            $newVal = MathProvider::multiply($newVal, $quantity->toNative()->getValue());
        }

        foreach ($divides as $quantity) {
            $newVal = MathProvider::divide($newVal, $quantity->toNative()->getValue(), $precision);
        }

        return $newUnit->preConvertedAdd($newVal);
    }

}