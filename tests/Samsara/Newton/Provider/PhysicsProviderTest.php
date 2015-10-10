<?php

namespace Samsara\Newton\Provider;

use Samsara\Newton\Core\UnitComposition;

class PhysicsProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testConstantAccel()
    {

        $unit = new UnitComposition();

        $length = $unit->getUnitClass(UnitComposition::LENGTH);
        $time = $unit->getUnitClass(UnitComposition::TIME);
        $accel = $unit->getUnitClass(UnitComposition::ACCELERATION);

        $length->preConvertedAdd(1);
        $time->preConvertedAdd(1);
        $accel->preConvertedAdd(1);

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Time',
            PhysicsProvider::constantAccelCalcs($length, $accel)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Length',
            PhysicsProvider::constantAccelCalcs($time, $accel)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Acceleration',
            PhysicsProvider::constantAccelCalcs($length, $time)
        );

    }

    public function testConstantAccelTooFewArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::constantAccelCalcs(0);

    }

    public function testConstantAccelTooManyArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::constantAccelCalcs(0, 1, 2);

    }

    public function testConstantAccelInvalidArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::constantAccelCalcs(0, 1);

    }

    public function testConstantAccelOneOfEach()
    {

        $this->setExpectedException('InvalidArgumentException');
        $unit = new UnitComposition();

        $length = $unit->getUnitClass(UnitComposition::LENGTH);
        $length->preConvertedAdd(1);

        PhysicsProvider::constantAccelCalcs($length, $length);

    }

    public function testNewtonsSecondLaw()
    {

        $unit = new UnitComposition();

        $force = $unit->getUnitClass(UnitComposition::FORCE);
        $mass = $unit->getUnitClass(UnitComposition::MASS);
        $accel = $unit->getUnitClass(UnitComposition::ACCELERATION);

        $force->preConvertedAdd(1);
        $mass->preConvertedAdd(1);
        $accel->preConvertedAdd(1);

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Mass',
            PhysicsProvider::forceMassAccelCalcs($force, $accel)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Force',
            PhysicsProvider::forceMassAccelCalcs($mass, $accel)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Acceleration',
            PhysicsProvider::forceMassAccelCalcs($force, $mass)
        );

    }

    public function testNewtonsSecondLawTooFewArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::forceMassAccelCalcs(0);

    }

    public function testNewtonsSecondLawTooManyArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::forceMassAccelCalcs(0, 1, 2);

    }

    public function testNewtonsSecondLawInvalidArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::forceMassAccelCalcs(0, 1);

    }

    public function testNewtonsSecondLawOneOfEach()
    {

        $this->setExpectedException('InvalidArgumentException');
        $unit = new UnitComposition();

        $mass = $unit->getUnitClass(UnitComposition::MASS);
        $mass->preConvertedAdd(1);

        PhysicsProvider::forceMassAccelCalcs($mass, $mass);

    }

    public function testKineticEnergy()
    {

        $unit = new UnitComposition();

        $energy = $unit->getUnitClass(UnitComposition::ENERGY);
        $mass = $unit->getUnitClass(UnitComposition::MASS);
        $velocity = $unit->getUnitClass(UnitComposition::VELOCITY);

        $energy->preConvertedAdd(1);
        $mass->preConvertedAdd(1);
        $velocity->preConvertedAdd(1);

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Mass',
            PhysicsProvider::kineticEnergyCalcs($energy, $velocity)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Energy',
            PhysicsProvider::kineticEnergyCalcs($mass, $velocity)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Velocity',
            PhysicsProvider::kineticEnergyCalcs($energy, $mass)
        );

    }

    public function testKineticEnergyTooFewArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::kineticEnergyCalcs(0);

    }

    public function testKineticEnergyTooManyArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::kineticEnergyCalcs(0, 1, 2);

    }

    public function testKineticEnergyInvalidArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::kineticEnergyCalcs(0, 1);

    }

    public function testKineticEnergyOneOfEach()
    {

        $this->setExpectedException('InvalidArgumentException');
        $unit = new UnitComposition();

        $mass = $unit->getUnitClass(UnitComposition::MASS);
        $mass->preConvertedAdd(1);

        PhysicsProvider::kineticEnergyCalcs($mass, $mass);

    }

    public function testMomentum()
    {

        $unit = new UnitComposition();

        $momentum = $unit->getUnitClass(UnitComposition::MOMENTUM);
        $mass = $unit->getUnitClass(UnitComposition::MASS);
        $velocity = $unit->getUnitClass(UnitComposition::VELOCITY);

        $momentum->preConvertedAdd(1);
        $mass->preConvertedAdd(1);
        $velocity->preConvertedAdd(1);

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Mass',
            PhysicsProvider::momentumCalcs($momentum, $velocity)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Momentum',
            PhysicsProvider::momentumCalcs($mass, $velocity)
        );

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\Velocity',
            PhysicsProvider::momentumCalcs($momentum, $mass)
        );

    }

    public function testMomentumTooFewArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::momentumCalcs(0);

    }

    public function testMomentumTooManyArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::momentumCalcs(0, 1, 2);

    }

    public function testMomentumInvalidArguments()
    {

        $this->setExpectedException('InvalidArgumentException');
        PhysicsProvider::momentumCalcs(0, 1);

    }

    public function testMomentumOneOfEach()
    {

        $this->setExpectedException('InvalidArgumentException');
        $unit = new UnitComposition();

        $mass = $unit->getUnitClass(UnitComposition::MASS);
        $mass->preConvertedAdd(1);

        PhysicsProvider::momentumCalcs($mass, $mass);

    }

}