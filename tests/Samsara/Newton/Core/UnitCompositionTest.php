<?php

namespace Samsara\Newton\Core;

use Samsara\Newton\Units\Force;
use Samsara\Newton\Units\Length;
use Samsara\Newton\Units\Mass;
use Samsara\Newton\Units\Acceleration;
use Samsara\Newton\Units\Frequency;

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
            'Samsara\\Newton\\Units\\Acceleration',
            $unit->getUnitClass('Acceleration')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Ampere',
            $unit->getUnitClass('Ampere')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Area',
            $unit->getUnitClass('Area')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Charge',
            $unit->getUnitClass('Charge')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Cycles',
            $unit->getUnitClass('Cycles')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Density',
            $unit->getUnitClass('Density')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Energy',
            $unit->getUnitClass('Energy')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Force',
            $unit->getUnitClass('Force')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Frequency',
            $unit->getUnitClass('Frequency')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Length',
            $unit->getUnitClass('Length')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Mass',
            $unit->getUnitClass('Mass')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Power',
            $unit->getUnitClass('Power')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Pressure',
            $unit->getUnitClass('Pressure')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Temperature',
            $unit->getUnitClass('Temperature')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Time',
            $unit->getUnitClass('Time')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Velocity',
            $unit->getUnitClass('Velocity')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Voltage',
            $unit->getUnitClass('Voltage')
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Volume',
            $unit->getUnitClass('Volume')
        );

        $unit->addUnit('Samsara\\Newton\\Units\\Volume',  ['time' => 1, 'mass' => 1], 'test');

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Volume',
            $unit->getUnitClass('test')
        );

        $this->setExpectedException('Exception', 'Unknown unit type: test2');

        $unit->getUnitClass('test2');
    }

    public function testGetUnitClassException()
    {
        $unit = new UnitComposition();

        $unit->addUnit('Samsara\\Newton\\Core\\SIPrefixes',  ['time' => 1, 'mass' => 1], 'test3');

        $this->setExpectedException('Exception', 'Valid units must extend the Quantity class.');

        $unit->getUnitClass('test3');
    }

    public function testNaiveMultiply()
    {
        $unit = new UnitComposition();
        $length = new Length(5, $unit);

        /** @var \Samsara\Newton\Units\Area $area */
        $area = $unit->naiveMultiply($length, $length);

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Area',
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
            'Samsara\\Newton\\Units\\Acceleration',
            $acceleration
        );

        $this->assertEquals(
            '1',
            $acceleration->getValue()
        );
    }

    public function testGetUnitCompNameException()
    {
        $comp = ['time' => 6];
        $unit = new UnitComposition();

        $this->setExpectedException('Exception', 'Cannot match the unit definition to an existing unit.');

        $unit->getUnitCompName($comp);
    }

    public function testNaiveMultiOpt()
    {
        $unit = new UnitComposition();

        $cycles = $unit->getUnitClass('Cycles', 10);
        $time = $unit->getUnitClass('Time', 1);

        /** @var Frequency $frequency */
        $frequency = $unit->naiveMultiOpt([$cycles], [$time]);

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Frequency',
            $frequency
        );

        $this->assertEquals(
            '10',
            $frequency->getValue()
        );
    }

}