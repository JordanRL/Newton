<?php

namespace Samsara\PHPhysics\Core;

use Samsara\PHPhysics\Provider\MathProvider;

/**
 * Class Quantity
 */
abstract class Quantity
{
    protected $units = [];
    protected $rates = [];

    /**
     * @var mixed current value
     */
    protected $value;

    /**
     * @var string unit name
     */
    protected $unit;

    /**
     * @var string native unit name
     * Override this in each quantity subclass.
     */
    protected $native;

    /**
     * This keeps track of what base units the current unit is composed of. This allows the UnitComposition class
     * to intelligently determine what unit is the result of multiplication and division.
     *
     * @var array
     */
    protected $unitTypesPresent = [];

    /**
     * @var UnitComposition
     */
    protected $unitCompClass;

    /**
     * @param float             $value
     * @param UnitComposition   $unitComposition
     * @param string            $unit
     */
    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        if (is_null($unit)) {
            $this->unit = $this->native;
        } else {
            $this->unit = $unit;
        }
        $this->value = $value;

        $this->unitCompClass = $unitComposition;
    }

    protected function setComposition($key)
    {
        $this->unitTypesPresent = $this->unitCompClass->unitComp[$key];

        return $this;
    }

    public function convert($value, $from, $to)
    {
        return MathProvider::divide(MathProvider::multiply($value, $this->getConversionRate($from)), $this->getConversionRate($to));
    }

    public function toNative()
    {
        if ($this->unit == $this->native) {
            return $this;
        }

        return $this->to($this->native);
    }

    public function to($unit)
    {
        $this->value = $this->convert($this->value, $this->unit, $unit);
        $this->unit = $unit;

        return $this;
    }

    public function getConversionRate($unit)
    {
        if (!array_key_exists($unit, $this->units)) {
            throw new \Exception('Cannot undefined unit.');
        }

        if (!array_key_exists($this->units[$unit], $this->rates)) {

        }

        return $this->rates[$this->units[$unit]];
    }

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
     * @param string $alias The string by which you will reference this unit. Must be unique.
     * @param string|int|float $nativeConversion The number to multiply the native unit by to get the new unit.
     *
     * @return $this
     * @throws \Exception
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

    public function getValue()
    {
        return $this->value;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function getUnitsPresent()
    {
        return $this->unitTypesPresent;
    }

    public function preConvertedAdd($value)
    {
        $this->value = MathProvider::add($this->value, $value);

        return $this;
    }

    public function preConvertedSubtract($value)
    {
        $this->value = MathProvider::subtract($this->value, $value);

        return $this;
    }

    public function preConvertedMultiply($value)
    {
        $this->value = MathProvider::multiply($this->value, $value);

        return $this;
    }

    public function preCovertedDivide($value, $precision = 2)
    {
        $this->value = MathProvider::divide($this->value, $value, $precision);

        return $this;
    }

    public function add(Quantity $quantity)
    {
        if (get_class($this) != get_class($quantity)) {
            throw new \Exception('Cannot add units of two different types.');
        }

        $oldUnit = $quantity->getUnit();

        $this->value += $quantity->to($this->unit)->getValue();

        $quantity->to($oldUnit);

        return $this;
    }

    public function subtract(Quantity $quantity)
    {
        if (get_class($this) != get_class($quantity)) {
            throw new \Exception('Cannot subtract units of two different types.');
        }

        $this->value -= $quantity->to($this->unit)->getValue();

        return $this;
    }

    public function multiplyBy(Quantity $quantity)
    {
        return $this->unitCompClass->naiveMultiply($this, $quantity);
    }

    public function multiplyBySquared(Quantity $quantity)
    {
        return $this->unitCompClass->naiveMultiOpt([$this, $quantity, $quantity], []);
    }

    public function divideBy(Quantity $quantity, $precision = 2)
    {
        return $this->unitCompClass->naiveDivide($this, $quantity, $precision);
    }

    public function divideBySquared(Quantity $quantity, $precision = 2)
    {
        return $this->unitCompClass->naiveMultiOpt([$this], [$quantity, $quantity], $precision);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value.' '.$this->unit;
    }
}