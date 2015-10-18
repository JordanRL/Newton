<?php

namespace Samsara\Newton\Units\Core;

use Samsara\Fermat\Numbers;
use Samsara\Fermat\Values\Base\SphericalCoordinateTrait;
use Samsara\Newton\Core\Quantity;
use Samsara\Fermat\Values\Base\NumberInterface;

abstract class VectorQuantity extends Quantity
{

    use SphericalCoordinateTrait;

    /**
     * @var string
     */
    private $scalarClass;

    /**
     * @param ScalarQuantity                    $scalarClass
     * @param string|int|float|NumberInterface  $azimuth
     * @param string|int|float|NumberInterface  $inclination
     */
    public function __construct(ScalarQuantity $scalarClass, $azimuth, $inclination)
    {
        $this->setAzimuth(Numbers::makeOrDont(Numbers::IMMUTABLE, $azimuth));
        $this->setInclination(Numbers::makeOrDont(Numbers::IMMUTABLE, $inclination));
        $this->setMagnitude($scalarClass);

        $this->scalarClass = (new \ReflectionClass($scalarClass))->getName();

        $this->defineComposition($scalarClass->getUnitsPresent());

        parent::__construct($scalarClass->getValue(), $scalarClass->getUnitCompositionClass(), $scalarClass->getUnit());
    }

    /**
     * @return ScalarQuantity
     */
    public function getScalarUnit()
    {
        return $this->getRho();
    }

    public function preConvertedAdd($value)
    {
        $this->getScalarUnit()->preConvertedAdd($value);

        return $this;
    }

    public function preConvertedSubtract($value)
    {
        $this->getScalarUnit()->preConvertedSubtract($value);

        return $this;
    }

    public function preConvertedMultiply($value)
    {
        $this->getScalarUnit()->preConvertedMultiply($value);

        return $this;
    }

    public function preConvertedDivide($value)
    {
        $this->getScalarUnit()->preConvertedDivide($value);

        return $this;
    }

    /**
     * @param VectorQuantity|ScalarQuantity $quantity
     *
     * @returns $this
     * @throws \Exception
     */
    public function add($quantity)
    {
        if ($this->scalarOrNot($quantity)) {
            $this->getScalarUnit()->add($quantity);
        } elseif ($quantity instanceof VectorQuantity) {
            $this->vectorAdd($quantity);
        } else {
            throw new \InvalidArgumentException('Can only add an instance of the scalar unit or VectorQuantity');
        }

        return $this;
    }

    public function vectorAdd(VectorQuantity $vectorQuantity)
    {
        if (!$this->scalarOrNot($vectorQuantity->getScalarUnit())) {
            throw new \InvalidArgumentException('Cannot add vectors which have different types of scalar units.');
        }

        $this->setAzimuth($this->getAzimuth()->add($vectorQuantity->getAzimuth()));
        $this->setInclination($this->getInclination()->add($vectorQuantity->getInclination()));
        $this->getScalarUnit()->add($vectorQuantity->getScalarUnit());

        return $this;
    }

    /**
     * @param VectorQuantity|ScalarQuantity $quantity
     *
     * @returns $this
     * @throws \Exception
     */
    public function subtract($quantity)
    {
        if ($this->scalarOrNot($quantity)) {
            $this->getScalarUnit()->subtract($quantity);
        } elseif ($quantity instanceof VectorQuantity) {
            $this->vectorSubtract($quantity);
        } else {
            throw new \InvalidArgumentException('Can only add an instance of the scalar unit or VectorQuantity');
        }

        return $this;
    }

    public function vectorSubtract(VectorQuantity $vectorQuantity)
    {
        if (!$this->scalarOrNot($vectorQuantity->getScalarUnit())) {
            throw new \InvalidArgumentException('Cannot add vectors which have different types of scalar units.');
        }

        $this->setAzimuth($this->getAzimuth()->subtract($vectorQuantity->getAzimuth()));
        $this->setInclination($this->getInclination()->subtract($vectorQuantity->getInclination()));
        $this->getScalarUnit()->subtract($vectorQuantity->getScalarUnit());

        return $this;
    }

    public function getUnitCompositionClass()
    {
        return $this->getScalarUnit()->getUnitCompositionClass();
    }

    public function to($unit)
    {
        $this->getScalarUnit()->to($unit);

        return $this;
    }

    public function toNative()
    {
        $this->getScalarUnit()->toNative();

        return $this;
    }

    public function getConversionRate($unit)
    {
        return $this->getScalarUnit()->getConversionRate($unit);
    }

    public function addAlias($alias, $unit)
    {
        $this->getScalarUnit()->addAlias($alias, $unit);

        return $this;
    }

    public function addUnit($alias, $nativeConversion)
    {
        $this->getScalarUnit()->addUnit($alias, $nativeConversion);

        return $this;
    }

    protected function scalarOrNot($testInput)
    {
        $className = $this->scalarClass;

        return $testInput instanceof $className;
    }

}