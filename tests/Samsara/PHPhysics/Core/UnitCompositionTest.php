<?php

namespace Samsara\PHPhysics\Core;

use Samsara\PHPhysics\Units\Force;
use Samsara\PHPhysics\Units\Length;
use Samsara\PHPhysics\Units\Mass;
use Samsara\PHPhysics\Units\Acceleration;

class UnitCompositionTest extends \PHPUnit_Framework_TestCase
{

    public function testAddUnit()
    {

        $unit = new UnitComposition();

        $unit->addUnit('SomeClass', ['time' => 1, 'mass' => 1], 'test');

        $this->assertEquals(
            'SomeClass',
            $unit->dynamicUnits['test']
        );

        $this->assertArrayHasKey(
            'time',
            $unit->unitComp['test']
        );

        $this->assertArrayHasKey(
            'mass',
            $unit->unitComp['test']
        );

        $this->assertEquals(
            1,
            $unit->unitComp['test']['time']
        );

        $this->assertEquals(
            1,
            $unit->unitComp['test']['mass']
        );

        $this->setExpectedException('Exception', 'Cannot add unit SomeClass with key test because that key is already being used.');

        $unit->addUnit('SomeClass', ['time' => 1, 'mass' => 1], 'test');

    }

    public function testGetUnitClass()
    {
        $unit = new UnitComposition();

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Acceleration',
            $unit->getUnitClass('Acceleration')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Ampere',
            $unit->getUnitClass('Ampere')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Area',
            $unit->getUnitClass('Area')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Charge',
            $unit->getUnitClass('Charge')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Cycles',
            $unit->getUnitClass('Cycles')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Density',
            $unit->getUnitClass('Density')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Energy',
            $unit->getUnitClass('Energy')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Force',
            $unit->getUnitClass('Force')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Frequency',
            $unit->getUnitClass('Frequency')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Length',
            $unit->getUnitClass('Length')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Mass',
            $unit->getUnitClass('Mass')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Power',
            $unit->getUnitClass('Power')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Pressure',
            $unit->getUnitClass('Pressure')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Temperature',
            $unit->getUnitClass('Temperature')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Time',
            $unit->getUnitClass('Time')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Velocity',
            $unit->getUnitClass('Velocity')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Voltage',
            $unit->getUnitClass('Voltage')
        );

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Volume',
            $unit->getUnitClass('Volume')
        );

        $unit->addUnit('Samsara\\PHPhysics\\Units\\Volume',  ['time' => 1, 'mass' => 1], 'test');

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Volume',
            $unit->getUnitClass('test')
        );

        $this->setExpectedException('Exception', 'Unknown unit type: test2');

        $unit->getUnitClass('test2');
    }

    public function testGetUnitClassException()
    {
        $unit = new UnitComposition();

        $unit->addUnit('Samsara\\PHPhysics\\Core\\SIPrefix',  ['time' => 1, 'mass' => 1], 'test3');

        $this->setExpectedException('Exception', 'Valid units must extend the Quantity class.');

        $unit->getUnitClass('test3');
    }

    public function testNaiveMultiply()
    {
        $unit = new UnitComposition();
        $length = new Length(5, $unit);

        /** @var \Samsara\PHPhysics\Units\Area $area */
        $area = $unit->naiveMultiply($length, $length);

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Area',
            $area
        );

        $this->assertEquals(
            '25',
            $area->getValue()
        );
    }

    public function testNaiveDivide()
    {
        $unit = new UnitComposition();

        $thrust = new Force(1000, $unit);
        $mass = new Mass(1000, $unit);

        /** @var Acceleration $acceleration */
        $acceleration = $unit->naiveDivide($thrust, $mass);

        $this->assertInstanceOf(
            'Samsara\\PHPhysics\\Units\\Acceleration',
            $acceleration
        );

        $this->assertEquals(
            '1',
            $acceleration->getValue()
        );
    }

}