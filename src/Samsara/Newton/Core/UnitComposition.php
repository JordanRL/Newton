<?php

namespace Samsara\Newton\Core;

use Samsara\Newton\Units\Ampere;
use Samsara\Newton\Units\Charge;
use Samsara\Newton\Units\Cycles;
use Samsara\Newton\Units\Density;
use Samsara\Newton\Units\Energy;
use Samsara\Newton\Units\Force;
use Samsara\Newton\Units\Frequency;
use Samsara\Newton\Units\Length;
use Samsara\Newton\Units\Area;
use Samsara\Newton\Units\Mass;
use Samsara\Newton\Units\Momentum;
use Samsara\Newton\Units\Power;
use Samsara\Newton\Units\Pressure;
use Samsara\Newton\Units\Temperature;
use Samsara\Newton\Units\Velocity;
use Samsara\Newton\Units\Acceleration;
use Samsara\Newton\Units\Time;
use Samsara\Newton\Units\Voltage;
use Samsara\Newton\Units\Volume;
use Samsara\Newton\Provider\MathProvider;

class UnitComposition
{
    const ACCELERATION  = 'Acceleration';
    const AMPERE        = 'Ampere';
    const AREA          = 'Area';
    const CHARGE        = 'Charge';
    const CYCLES        = 'Cycles';
    const DENSITY       = 'Density';
    const ENERGY        = 'Energy';
    const FORCE         = 'Force';
    const FREQUENCY     = 'Frequency';
    const LENGTH        = 'Length';
    const MASS          = 'Mass';
    const MOMENTUM      = 'Momentum';
    const POWER         = 'Power';
    const PRESSURE      = 'Pressure';
    const TEMPERATURE   = 'Temperature';
    const TIME          = 'Time';
    const VELOCITY      = 'Velocity';
    const VOLTAGE       = 'Voltage';
    const VOLUME        = 'Volume';

    /**
     * This array describes the composition in base units of measure each of the classes which come by default with
     * this library. All other types of units can be composed from:
     *
     * Length
     * Time
     * Mass
     * Electric Current
     *
     * For simplicity, this library also includes the following as base composition units:
     *
     * Temperature
     * Cycles
     *
     * @var array
     */
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
        self::CYCLES => [
            'cycles' => 1
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
        self::FREQUENCY => [
            'cycles' => 1,
            'time' => -1
        ],
        self::LENGTH => [
            'length' => 1
        ],
        self::MASS => [
            'mass' => 1
        ],
        self::MOMENTUM => [
            'mass' => 1,
            'length' => 1,
            'time' => -1
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
        self::TEMPERATURE => [
            'temp' => 1
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

    /**
     * This is where units that are added at runtime have their classname stored so that can be instantiated correctly.
     *
     * @var array
     */
    public $dynamicUnits = [];

    /**
     * The acceptable base composition types.
     *
     * @var array
     */
    private $baseUnitTypes = [
        'length',
        'mass',
        'time',
        'temp',
        'electricCurrent',
        'cycles'
    ];

    public function __construct()
    {
        foreach ($this->unitComp as $unit => $unitDef) {
            ksort($unitDef);

            $this->unitComp[$unit] = $unitDef;
        }
    }

    /**
     * Add a brand new unit with class an composition.
     *
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
     * Returns the class for the set of numerators and denominators.
     *
     * @param Quantity[] $numerators
     * @param Quantity[] $denominators
     * @return Quantity
     */
    public function getMultiUnits(array $numerators, array $denominators)
    {
        $unitComp = $this->getUnitCompArray($numerators, $denominators);

        return $this->getUnitCompClass($unitComp);
    }

    /**
     * Returns the multiplied and divided unit composition ONLY for a set of numerators and denominators.
     *
     * @param   Quantity[] $numerators
     * @param   Quantity[] $denominators
     * @return  array
     */
    public function getUnitCompArray(array $numerators, array $denominators)
    {
        $unitComp = [];

        foreach ($this->baseUnitTypes as $type) {
            $unitComp[$type] = 0;
        }

        foreach ($numerators as $unit) {
            /** @var Quantity $unit */
            foreach ($unit->getUnitsPresent() as $unitType => $unitCount) {
                if ($unitCount != 0) {
                    $unitComp[$unitType] += $unitCount;
                }
            }
        }

        foreach ($denominators as $unit) {
            /** @var Quantity $unit */
            foreach ($unit->getUnitsPresent() as $unitType => $unitCount) {
                if ($unitCount != 0) {
                    $unitComp[$unitType] -= $unitCount;
                }
            }
        }

        foreach ($unitComp as $key => $val) {
            if ($val == 0) {
                unset($unitComp[$key]);
            }
        }

        return $unitComp;
    }

    /**
     * Gets the unit class for two units which are multiplied.
     *
     * @param   Quantity $unit1
     * @param   Quantity $unit2
     * @return  Quantity
     */
    public function getMultipliedUnit(Quantity $unit1, Quantity $unit2)
    {
        return $this->getMultiUnits([$unit1, $unit2], []);
    }

    /**
     * Gets the unit class for two units which are divided.
     *
     * @param   Quantity $numerator
     * @param   Quantity $denominator
     * @return  Quantity
     */
    public function getDividedUnit(Quantity $numerator, Quantity $denominator)
    {
        return $this->getMultiUnits([$numerator], [$denominator]);
    }

    /**
     * Gets the unit class from the composition array.
     *
     * @param   array $comp
     * @return  Quantity
     * @throws  \Exception
     */
    public function getUnitCompClass(array $comp)
    {
        return $this->getUnitClass($this->getUnitCompName($comp));
    }

    /**
     * Gets the unit name from the composition array.
     *
     * @param   array $comp
     * @return  string
     * @throws  \Exception
     */
    public function getUnitCompName(array $comp)
    {
        foreach ($this->unitComp as $unit => $unitDef) {
            ksort($comp);
            if ($comp === $unitDef) {
                return $unit;
            }
        }

        throw new \Exception('Cannot match the unit definition to an existing unit.');
    }

    /**
     * Gets the unit class from the unit name.
     *
     * @param   string $unit
     * @param   int $value
     * @return  Quantity
     * @throws  \Exception
     */
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

            case self::CYCLES:
                return new Cycles($value, $this);

            case self::ENERGY:
                return new Energy($value, $this);

            case self::DENSITY:
                return new Density($value, $this);

            case self::FORCE:
                return new Force($value, $this);

            case self::FREQUENCY:
                return new Frequency($value, $this);

            case self::LENGTH:
                return new Length($value, $this);

            case self::MASS:
                return new Mass($value, $this);

            case self::MOMENTUM:
                return new Momentum($value, $this);

            case self::POWER:
                return new Power($value, $this);

            case self::PRESSURE:
                return new Pressure($value, $this);

            case self::TEMPERATURE:
                return new Temperature($value, $this);

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

                    $parent = $class->getParentClass();

                    if ($parent && $parent->getName() == 'Samsara\\Newton\\Core\\Quantity') {
                        return $class->newInstance($value, $this);
                    } else {
                        throw new \Exception('Valid units must extend the Quantity class.');
                    }
                }
                throw new \Exception('Unknown unit type: '.$unit);
        }
    }

    /**
     * Alias for naiveMultiOpt where both arguments are multiplied
     *
     * @param   Quantity $unit1
     * @param   Quantity $unit2
     * @return  Quantity
     * @throws  \Exception
     */
    public function naiveMultiply(Quantity $unit1, Quantity $unit2)
    {
        return $this->naiveMultiOpt([$unit1, $unit2], []);
    }

    /**
     * Alias for naiveMultiOpt where the first argument is divided by the second argument.
     *
     * @param   Quantity $numerator
     * @param   Quantity $denominator
     * @param   int $precision
     * @return  Quantity
     * @throws  \Exception
     */
    public function naiveDivide(Quantity $numerator, Quantity $denominator, $precision = 2)
    {
        return $this->naiveMultiOpt([$numerator], [$denominator], $precision);
    }

    /**
     * Takes an arbitrary number of unit objects which are to be multiplied and divided and attempts to determine both
     * the numerical answer, as well as what unit the answer is in, then returns an instance of the appropriate class
     * with the appropriate value.
     *
     * @param Quantity[] $numerators
     * @param Quantity[] $denominators
     * @param int        $precision
     *
     * @return Quantity
     * @throws \Exception
     */
    public function naiveMultiOpt(array $numerators, array $denominators, $precision = 2)
    {
        $newVal = 1;

        foreach ($numerators as $key => $quantity) {
            if ($quantity instanceof Quantity) {
                $oldUnit = $quantity->getUnit();
                $newVal = MathProvider::multiply($newVal, $quantity->toNative()->getValue());
                $quantity->to($oldUnit);
            } elseif (is_numeric($quantity)) {
                $newVal = MathProvider::multiply($newVal, $quantity);
                unset($numerators[$key]);
            } else {
                throw new \Exception('Invalid numerator');
            }
        }

        foreach ($denominators as $key => $quantity) {
            if ($quantity instanceof Quantity) {
                $oldUnit = $quantity->getUnit();
                $newVal = MathProvider::divide($newVal, $quantity->toNative()->getValue(), $precision);
                $quantity->to($oldUnit);
            } elseif (is_numeric($quantity)) {
                $newVal = MathProvider::divide($newVal, $quantity, $precision);
                unset($denominators[$key]);
            } else {
                throw new \Exception('Invalid denominator');
            }
        }

        $newUnit = $this->getMultiUnits($numerators, $denominators);

        return $newUnit->preConvertedAdd($newVal);
    }

    /**
     * Attempts to take the square root of a set of numerators and denominators, determining both the value and unit
     * composition, and returning the correct unit object with the correct value.
     *
     * @param   Quantity[]|int[] $numerators
     * @param   Quantity[]|int[] $denominators
     * @param   int        $precision
     *
     * @return  Quantity
     * @throws  \Exception
     */
    public function naiveSquareRoot(array $numerators, array $denominators, $precision = 2)
    {
        $newVal = 1;

        foreach ($numerators as $key => $quantity) {
            if ($quantity instanceof Quantity) {
                $oldUnit = $quantity->getUnit();
                $newVal = MathProvider::multiply($newVal, $quantity->toNative()->getValue());
                $quantity->to($oldUnit);
            } elseif (is_numeric($quantity)) {
                $newVal = MathProvider::multiply($newVal, $quantity);
                unset($numerators[$key]);
            } else {
                throw new \Exception('Invalid numerator');
            }
        }

        foreach ($denominators as $key => $quantity) {
            if ($quantity instanceof Quantity) {
                $oldUnit = $quantity->getUnit();
                $newVal = MathProvider::divide($newVal, $quantity->toNative()->getValue(), $precision);
                $quantity->to($oldUnit);
            } elseif (is_numeric($quantity)) {
                $newVal = MathProvider::divide($newVal, $quantity, $precision);
                unset($denominators[$key]);
            } else {
                throw new \Exception('Invalid denominator');
            }
        }

        $unitComp = $this->getUnitCompArray($numerators, $denominators);

        foreach ($unitComp as $unit => $exp) {
            $newExp = $exp/2;
            if (!is_int($newExp)) {
                throw new \Exception('Incorrect exponents after square root.');
            }
            $unitComp[$unit] = $newExp;
        }

        $newUnit = $this->getUnitCompClass($unitComp);

        return $newUnit->preConvertedAdd(MathProvider::squareRoot($newVal, $precision));
    }

}