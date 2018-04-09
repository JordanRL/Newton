<?php

namespace Samsara\Newton\Core;

use Samsara\Fermat\Numbers;
use Samsara\Fermat\Provider\TrigonometryProvider;
use Samsara\Fermat\Values\Base\NumberInterface;
use Samsara\Newton\Units\Ampere;
use Samsara\Newton\Units\Charge;
use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Units\Current;
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
use Samsara\Newton\Units\Vector\VectorAcceleration;
use Samsara\Newton\Units\Vector\VectorForce;
use Samsara\Newton\Units\Vector\VectorMomentum;
use Samsara\Newton\Units\Vector\VectorVelocity;
use Samsara\Newton\Units\Velocity;
use Samsara\Newton\Units\Acceleration;
use Samsara\Newton\Units\Time;
use Samsara\Newton\Units\Voltage;
use Samsara\Newton\Units\Volume;

class UnitComposition
{
    const ABSORBED_DOSE             = 'Absorbed Dose';
    const ACCELERATION              = 'Acceleration';
    const AMOUNT                    = 'Amount';
    const ANGULAR_ACCELERATION      = 'Angular Acceleration';
    const ANGULAR_VELOCITY          = 'Angular Velocity';
    const AREA                      = 'Area';
    const CAPACITANCE               = 'Capacitance';
    const CATALYTIC_ACTIVITY        = 'Catalytic Activity';
    const CHARGE                    = 'Charge';
    const CONDUCTANCE_ELEC          = 'Electric Conductance';
    const CONDUCTANCE_THERM         = 'Thermal Conductance';
    const CURRENT                   = 'Current';
    const CYCLES                    = 'Cycles';
    const DENSITY                   = 'Density';
    const ENERGY                    = 'Energy';
    const FORCE                     = 'Force';
    const FREQUENCY                 = 'Frequency';
    const ILLUMINATION              = 'Illumination';
    const INDUCTANCE                = 'Inductance';
    const LENGTH                    = 'Length';
    const LUMINOUS_FLUX             = 'Luminous Flux';
    const LUMINOUS_INTENSITY        = 'Luminous Intensity';
    const MAG_FLUX                  = 'Magnetic Flux';
    const MAG_FLUX_DENSITY          = 'Magnetic Flux Density';
    const MASS                      = 'Mass';
    const MOMENTUM                  = 'Momentum';
    const PLANE_ANGLE               = 'Plane Angle';
    const POWER                     = 'Power';
    const PRESSURE                  = 'Pressure';
    const RADIOACTIVITY             = 'Radioactivity';
    const RESISTANCE                = 'Resistance';
    const SOLID_ANGLE               = 'Solid Angle';
    const TEMPERATURE               = 'Temperature';
    const TIME                      = 'Time';
    const VELOCITY                  = 'Velocity';
    const VOLTAGE                   = 'Voltage';
    const VOLUME                    = 'Volume';

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
    protected $unitComp = [
        self::ABSORBED_DOSE => [
            'length' => 2,
            'time' => -2
        ],
        self::ACCELERATION => [
            'length' => 1,
            'time' => -2
        ],
        self::AMOUNT => [
            'mol' => 1
        ],
        self::ANGULAR_ACCELERATION => [
            'planeAngle' => 1,
            'time' => -2
        ],
        self::ANGULAR_VELOCITY => [
            'planeAngle' => 1,
            'time' => -1
        ],
        self::AREA => [
            'length' => 2
        ],
        self::CAPACITANCE => [
            'time' => 4,
            'electricCurrent' => 2,
            'mass' => -1,
            'length' => -2
        ],
        self::CATALYTIC_ACTIVITY => [
            'mol' => 1,
            'time' => -1
        ],
        self::CHARGE => [
            'electricCurrent' => 1,
            'time' => 1
        ],
        self::CONDUCTANCE_ELEC => [
            'time' => 3,
            'electricCurrent' => 2,
            'mass' => -1,
            'length' => -2
        ],
        self::CONDUCTANCE_THERM => [
            'mass' => 1,
            'length' => 1,
            'time' => -3,
            'temperature' => -1
        ],
        self::CURRENT => [
            'electricCurrent' => 1
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
        self::ILLUMINATION => [
            'luminousIntensity' => 1,
            'solidAngle' => 1,
            'length' => -2
        ],
        self::INDUCTANCE => [
            'mass' => 1,
            'length' => 2,
            'time' => -2,
            'electricCurrent' => -2
        ],
        self::LENGTH => [
            'length' => 1
        ],
        self::LUMINOUS_FLUX => [
            'luminousIntensity' => 1,
            'solidAngle' => 1
        ],
        self::LUMINOUS_INTENSITY => [
            'luminousIntensity' => 1
        ],
        self::MAG_FLUX => [
            'mass' => 1,
            'length' => 2,
            'time' => -2,
            'electricCurrent' => -1
        ],
        self::MAG_FLUX_DENSITY => [
            'mass' => 1,
            'time' => -2,
            'electricCurrent' => -1
        ],
        self::MASS => [
            'mass' => 1
        ],
        self::MOMENTUM => [
            'mass' => 1,
            'length' => 1,
            'time' => -1
        ],
        self::PLANE_ANGLE => [
            'planeAngle' => 1
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
        self::RADIOACTIVITY => [
            'time' => -1
        ],
        self::RESISTANCE => [
            'mass' => 1,
            'length' => 2,
            'time' => -3,
            'electricCurrent' => -2
        ],
        self::SOLID_ANGLE => [
            'solidAngle' => 1
        ],
        self::TEMPERATURE => [
            'temperature' => 1
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
    protected $dynamicUnits = [];

    /**
     * The acceptable base composition types.
     *
     * @var array
     */
    private $baseUnitTypes = [
        'length',
        'mass',
        'time',
        'temperature',
        'electricCurrent',
        'cycles',
        'luminousIntensity',
        'mol',
        'planeAngle',
        'solidAngle'
    ];

    /**
     * @var UnitComposition
     */
    private static $instance;

    private function __construct()
    {
        foreach ($this->unitComp as $unit => $unitDef) {
            ksort($unitDef);

            $this->unitComp[$unit] = $unitDef;
        }
    }
    
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new UnitComposition();
        }
        
        return self::$instance;
    }
    
    public function getCompArrayByName($name)
    {
        if (!isset($this->unitComp[$name])) {
            throw new \Exception('Cannot return unit composition array for non-existent unit: '.$name);
        }
        
        return $this->unitComp[$name];
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
            if ($unit instanceof Quantity) {
                foreach ($unit->getUnitsPresent() as $unitType => $unitCount) {
                    if ($unitCount != 0) {
                        $unitComp[$unitType] += $unitCount;
                    }
                }
            }
        }

        foreach ($denominators as $unit) {
            if ($unit instanceof Quantity) {
                foreach ($unit->getUnitsPresent() as $unitType => $unitCount) {
                    if ($unitCount != 0) {
                        $unitComp[$unitType] -= $unitCount;
                    }
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
     * @param   int|NumberInterface $value
     * @return  Quantity
     * @throws  \Exception
     */
    public function getUnitClass($unit, $value = 0)
    {
        switch ($unit) {
            case self::ACCELERATION:
                return new Acceleration($value);

            case self::CURRENT:
                return new Current($value);

            case self::AREA:
                return new Area($value);

            case self::CHARGE:
                return new Charge($value);

            case self::CYCLES:
                return new Cycles($value);

            case self::ENERGY:
                return new Energy($value);

            case self::DENSITY:
                return new Density($value);

            case self::FORCE:
                return new Force($value);

            case self::FREQUENCY:
                return new Frequency($value);

            case self::LENGTH:
                return new Length($value);

            case self::MASS:
                return new Mass($value);

            case self::MOMENTUM:
                return new Momentum($value);

            case self::POWER:
                return new Power($value);

            case self::PRESSURE:
                return new Pressure($value);

            case self::TEMPERATURE:
                return new Temperature($value);

            case self::TIME:
                return new Time($value);

            case self::VELOCITY:
                return new Velocity($value);

            case self::VOLTAGE:
                return new Voltage($value);

            case self::VOLUME:
                return new Volume($value);

            default:
                if (array_key_exists($unit, $this->dynamicUnits)) {
                    $class = new \ReflectionClass($this->dynamicUnits[$unit]);

                    $parent = $class->getParentClass();

                    if ($parent && ($parent->getName() == 'Samsara\\Newton\\Core\\Quantity' || $parent->getName() == 'Samsara\\Newton\\Units\\Core\\ScalarQuantity')) {
                        return $class->newInstance($value);
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
        $newVal = $this->multiOptValue($numerators, $denominators, $precision);

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
        $newVal = $this->multiOptValue($numerators, $denominators, $precision);

        $unitComp = $this->getUnitCompArray($numerators, $denominators);

        $newUnitComp = [];

        foreach ($unitComp as $unit => $exp) {
            $newExp = $exp/2;
            if (!is_int($newExp)) {
                throw new \Exception('Incorrect exponents after square root.');
            }
            $newUnitComp[$unit] = $newExp;
        }

        $newUnit = $this->getUnitCompClass($newUnitComp);

        return $newUnit->preConvertedAdd($newVal->sqrt()->roundToPrecision($precision));
    }

    public function getVectorBySphericalCoords(ScalarQuantity $quantity, $azimuth, $inclination)
    {
        if ($quantity instanceof Acceleration) {
            return new VectorAcceleration($quantity, $azimuth, $inclination);
        } elseif ($quantity instanceof Force) {
            return new VectorForce($quantity, $azimuth, $inclination);
        } elseif ($quantity instanceof Momentum) {
            return new VectorMomentum($quantity, $azimuth, $inclination);
        } elseif ($quantity instanceof Velocity) {
            return new VectorVelocity($quantity, $azimuth, $inclination);
        } else {
            throw new \InvalidArgumentException('Non-vectorable scalar unit given.');
        }
    }

    public function getVectorByCartesian(ScalarQuantity $quantity, $x, $y, $z = 0)
    {
        $azimuth = TrigonometryProvider::sphericalCartesianAzimuth($x, $y);
        $inclination = TrigonometryProvider::sphericalCartesianInclination($x, $y, $z);

        return $this->getVectorBySphericalCoords($quantity, $azimuth, $inclination);
    }

    public function getVectorByHeading(ScalarQuantity $quantity, $heading)
    {
        $parts = TrigonometryProvider::sphericalFromHeading($heading);

        return $this->getVectorBySphericalCoords($quantity, $parts['azimuth'], $parts['inclination']);
    }

    /**
     * @param array $numerators
     * @param array $denominators
     * @param int   $precision
     *
     * @return NumberInterface
     * @throws \Exception
     */
    protected function multiOptValue(array $numerators, array $denominators, $precision = 2)
    {
        $newVal = Numbers::make(Numbers::IMMUTABLE, 1);

        foreach ($numerators as $key => $quantity) {
            if ($quantity instanceof Quantity) {
                $oldUnit = $quantity->getUnit();
                $newVal = $newVal->multiply($quantity->toNative()->getValue());
                $quantity->to($oldUnit);
            } elseif (is_numeric($quantity)) {
                $newVal = $newVal->multiply($quantity);
            } else {
                throw new \Exception('Invalid numerator');
            }
        }

        foreach ($denominators as $key => $quantity) {
            if ($quantity instanceof Quantity) {
                $oldUnit = $quantity->getUnit();
                if ($quantity->getValue() == 0) {
                    throw new \Exception('Cannot divide by zero.');
                }
                $newVal = $newVal->divide($quantity->toNative()->getValue())->roundToPrecision($precision);
                $quantity->to($oldUnit);
            } elseif (is_numeric($quantity)) {
                if ($quantity == 0) {
                    throw new \Exception('Cannot divide by zero.');
                }
                $newVal = $newVal->divide($quantity)->roundToPrecision($precision);
            } else {
                throw new \Exception('Invalid denominator');
            }
        }

        return $newVal;
    }

}