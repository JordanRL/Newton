<?php

namespace Samsara\Newton\Core;

use Samsara\Fermat\Numbers;
use Samsara\Fermat\Types\Base\NumberInterface;

/**
 * Class Quantity
 */
abstract class Quantity
{
    /**
     * An array that correlates the different units (in string form) to their index in the rates array. This allows for
     * multiple string representations to point to the same conversion rate without having to enter duplicate conversion
     * rates.
     *
     * $units['m/s'] => 0
     * $units['km/h'] => 1
     * $units['km/hr'] => 1
     *
     * $rates[0] => 1
     * $rates[1] => 3.6
     *
     * @var array
     */
    protected $units = [];

    /**
     * An array which explains the conversion rate from the native unit to the desired unit (by multiplication).
     *
     * m/s => km/s == 1 => 1000
     * km/s => km/h == 1000 => 3.6
     *
     * @var array
     */
    protected $rates = [];

    /**
     * The native unit (in string form) that all multiplication or division should take place in. For instance, the
     * native unit of length is 'm' for meters; the native unit of mass is 'kg' for kilogram.
     *
     * @var string
     * Override this in each quantity subclass.
     */
    protected $native;

    /**
     * The current numerical value of the unit in string form. It's important that numbers are operated on as strings,
     * because with the scale differences of the various units it is extremely likely that the maximum integer size
     * for PHP might be exceeded, and data loss might occur.
     *
     * @var NumberInterface
     */
    private $value;

    /**
     * The current unit which the value is in.
     *
     * @var string
     */
    private $unit;

    /**
     * This keeps track of what base units the current unit is composed of. This allows the UnitComposition class
     * to intelligently determine what unit is the result of multiplication and division.
     *
     * @var array
     */
    private $unitTypesPresent = [];

    /**
     * The instance of UnitComposition which should be used when determining the unit types present in different units
     * and from which multiplication, division, and similar operations should take place.
     *
     * @var UnitComposition
     */
    private $unitCompClass;
    
    private $alias;

    /**
     * @param float|int|string  $value
     * @param string            $unit
     */
    public function __construct($value, $unit = null)
    {
        if (is_null($unit)) {
            $this->unit = $this->native;
        } else {
            $this->unit = $unit;
        }
        $this->value = Numbers::makeOrDont(Numbers::IMMUTABLE, $value);

        $this->unitCompClass = UnitComposition::getInstance();
    }

    /**
     * Returns the UnitComposition class so that it can be modified or injected.
     *
     * @return UnitComposition
     */
    public function getUnitCompositionClass()
    {
        return $this->unitCompClass;
    }

    /**
     * Converts the value of the current unit to its native units.
     *
     * @return Quantity
     */
    public function toNative()
    {
        if ($this->unit == $this->native) {
            return $this;
        }

        return $this->to($this->native);
    }

    /**
     * Convert this object to another unit of measuring the same thing. For instance, meters -> feet. The value passed
     * to the to() method should be the string form of the unit (which is normally abbreviated, not spelled).
     *
     * @param   string $unit
     * @return  $this
     */
    public function to($unit)
    {
        $this->value = $this->convert($this->value, $this->unit, $unit);
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get's the conversion rate (by multiplication) between the argument unit and the native unit.
     *
     * @param   string $unit
     * @return  string
     * @throws  \Exception
     */
    public function getConversionRate($unit)
    {
        if (!array_key_exists($unit, $this->units)) {
            throw new \Exception('Cannot get conversion rate for undefined unit.');
        }

        if (!array_key_exists($this->units[$unit], $this->rates)) {
            throw new \Exception('Cannot get conversion rate without defined rate.');
        }

        return $this->rates[$this->units[$unit]];
    }

    /**
     * Adds another string which can be used to reference the conversion rate of an existing unit. For instance, you
     * could add the verbose form 'meters' instead of just 'm' with the following:
     *
     * addAlias('meters', 'm')
     *
     * @param   string $alias
     * @param   string $unit
     * @return  $this
     * @throws  \Exception
     */
    public function addAlias($alias, $unit)
    {
        if (array_key_exists($alias, $this->units)) {
            throw new \Exception('Cannot use '.$alias.' as an alias for '.$unit.' because '.$alias.' is already defined.');
        }

        if (!array_key_exists($unit, $this->units)) {
            throw new \Exception('Cannot assign alias '.$alias.' to '.$unit.' because '.$unit.' is not yet defined.');
        }

        $this->units[$alias] = $this->units[$unit];

        return $this;
    }

    /**
     * Add a brand new conversion rate to this object, including the string alias it will be referenced by.
     *
     * @param   string              $alias              The string by which you will reference this unit. Must be unique.
     * @param   string|int|float    $nativeConversion   The number to multiply the native unit by to get the new unit.
     *
     * @return  $this
     * @throws  \Exception
     */
    public function addUnit($alias, $nativeConversion)
    {
        if (array_key_exists($alias, $this->units)) {
            throw new \Exception('Cannot add new unit '.$alias.' because a unit with the same alias already exists.');
        }

        $this->units[$alias] = (count($this->units)+1);

        $this->rates[$this->units[$alias]] = $nativeConversion;

        return $this;
    }

    /**
     * Returns the current numerical value.
     *
     * @return NumberInterface
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the current unit (in string form).
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Returns the array of the current unit types that exist in this unit object.
     *
     * @return array
     */
    public function getUnitsPresent()
    {
        return $this->unitTypesPresent;
    }

    /**
     * Add a number to the value without consideration to conversion or units.
     *
     * @param   string|int|float|NumberInterface $value
     * @return  $this
     */
    public function preConvertedAdd($value)
    {
        $this->value = $this->value->add($value);

        return $this;
    }

    /**
     * Subtract a number to the value without consideration to conversion or units.
     *
     * @param   string|int|float|NumberInterface $value
     * @return  $this
     */
    public function preConvertedSubtract($value)
    {
        $this->value = $this->value->subtract($value);

        return $this;
    }

    /**
     * Multiply a number by the value without consideration to conversion or units.
     *
     * @param   string|int|float|NumberInterface $value
     * @return  $this
     */
    public function preConvertedMultiply($value)
    {
        $this->value = $this->value->multiply($value);

        return $this;
    }

    /**
     * Divide a number by the value without consideration to conversion or units.
     *
     * @param   string|int|float|NumberInterface $value
     * @param   int $precision
     * @return  $this
     */
    public function preConvertedDivide($value, $precision = 2)
    {
        $this->value = $this->value->divide($value)->roundToPrecision($precision);

        return $this;
    }

    /**
     * Take an instance of the same unit object, convert it to the units that this unit is in, and add it to this unit.
     *
     * @param   Quantity $quantity
     * @return  $this
     * @throws  \Exception
     */
    public function add(Quantity $quantity)
    {
        if (get_class($this) != get_class($quantity)) {
            throw new \Exception('Cannot add units of two different types.');
        }

        $oldUnit = $quantity->getUnit();

        $this->value = $this->value->add($quantity->to($this->unit)->getValue());

        $quantity->to($oldUnit);

        return $this;
    }

    /**
     * Take an instance of the same unit object, convert it to the units that this unit is in, and subtract it
     * from this unit.
     *
     * @param   Quantity $quantity
     * @return  $this
     * @throws  \Exception
     */
    public function subtract(Quantity $quantity)
    {
        if (get_class($this) != get_class($quantity)) {
            throw new \Exception('Cannot subtract units of two different types.');
        }

        $oldUnit = $quantity->getUnit();

        $this->value = $this->value->subtract($quantity->to($this->unit)->getValue());

        $quantity->to($oldUnit);

        return $this;
    }

    /**
     * Take an instance of any unit and attempt to multiply. This will pass responsibility to the UnitComposition class
     * so that it can attempt to figure out what the resulting units should be.
     *
     * @param   Quantity $quantity
     * @return  Quantity
     */
    public function multiplyBy(Quantity $quantity)
    {
        return $this->unitCompClass->naiveMultiply($this, $quantity);
    }

    /**
     * Take an instance of any unit and attempt to multiply by that unit after squaring it. This will pass
     * responsibility to the UnitComposition class so that it can attempt to figure out what the resulting
     * units should be.
     *
     * @param   Quantity $quantity
     * @return  Quantity
     * @throws  \Exception
     */
    public function multiplyBySquared(Quantity $quantity)
    {
        return $this->unitCompClass->naiveMultiOpt([$this, $quantity, $quantity], []);
    }

    /**
     * Take an instance of any unit and attempt to divide. This will pass responsibility to the UnitComposition class
     * so that it can attempt to figure out what the resulting units should be.
     *
     * @param   Quantity $quantity
     * @param   int $precision
     * @return  Quantity
     */
    public function divideBy(Quantity $quantity, $precision = 2)
    {
        return $this->unitCompClass->naiveDivide($this, $quantity, $precision);
    }

    /**
     * Take an instance of any unit and attempt to divide by that unit after squaring it. This will pass
     * responsibility to the UnitComposition class so that it can attempt to figure out what the resulting
     * units should be.
     *
     * @param   Quantity $quantity
     * @param   int $precision
     * @return  Quantity
     * @throws  \Exception
     */
    public function divideBySquared(Quantity $quantity, $precision = 2)
    {
        return $this->unitCompClass->naiveMultiOpt([$this], [$quantity, $quantity], $precision);
    }

    /**
     * Attempts to take the square root of this unit. In practice it is very rare for a unit that has a common purpose
     * or name on its own to be rooted. Instead it is more common for the square root to occur after a series of
     * multiplication and division, so you may provide numerators and denominators to this method as well which will
     * occur BEFORE the square root is taken.
     *
     * @param   Quantity[] $numerators
     * @param   Quantity[] $denominators
     * @param   int $precision
     * @return  Quantity
     * @throws  \Exception
     */
    public function squareRoot(array $numerators = [], array $denominators = [], $precision = 2)
    {
        $numerators[] = $this;

        return $this->unitCompClass->naiveSquareRoot($numerators, $denominators, $precision);
    }

    /**
     * Return the current value and unit.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value->getValue().' '.$this->unit;
    }
    
    public function useAs($alias)
    {
        
    }
    
    public function hasAlias($alias)
    {
        return $this->alias === $alias;
    }

    /**
     *
     *
     * @param   NumberInterface $value
     * @param   string $from
     * @param   string $to
     * @return  string
     * @throws  \Exception
     */
    protected function convert(NumberInterface $value, $from, $to)
    {
        if (!is_array($this->rates[$to]) && !is_array($this->rates[$from])) {
            // For simple, scaling conversions
            return $value->multiply($this->getConversionRate($from))->divide($this->getConversionRate($to));
        } else {
            // For more complex conversions, like that between Celsius and Fahrenheit.
            // From and To callables must be how to get to native unit
            if (is_array($this->rates[$to])) {
                /** @var callable $toConversion */
                $toConversion = $this->rates[$to]['to'];
            } else {
                $toConversion = function(NumberInterface $value) use ($to){
                    return $value->divide($this->getConversionRate($to));
                };
            }

            if (is_array($this->rates[$from])) {
                /** @var callable $fromConversion */
                $fromConversion = $this->rates[$from]['from'];
            } else {
                $fromConversion = function(NumberInterface $value) use ($from){
                    return $value->multiply($this->getConversionRate($from));
                };
            }

            return $toConversion($fromConversion($value));
        }
    }

    /**
     *
     *
     * @param   string $key
     * @return  $this
     */
    protected function setComposition($key)
    {
        $this->unitTypesPresent = $this->unitCompClass->getCompArrayByName($key);

        return $this;
    }

    /**
     *
     *
     * @param   array $comp
     * @return  $this
     */
    protected function defineComposition(array $comp)
    {
        $this->unitTypesPresent = $comp;

        return $this;
    }
}