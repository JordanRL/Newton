<?php

namespace Samsara\PHPhysics\Core;

class QuantityTest extends \PHPUnit_Framework_TestCase
{

    public function testAdd()
    {
        $unit = new UnitComposition();

        $time = $unit->getUnitClass(UnitComposition::TIME, '500');
        $time2 = $unit->getUnitClass(UnitComposition::TIME, '250');

        $this->assertEquals(
            '750',
            $time->add($time2)->getValue()
        );

        $length = $unit->getUnitClass(UnitComposition::LENGTH, '500');

        $this->setExpectedException('Exception', 'Cannot add units of two different types.');

        $time->add($length);
    }

    public function testSubtract()
    {
        $unit = new UnitComposition();

        $time = $unit->getUnitClass(UnitComposition::TIME, '500');
        $time2 = $unit->getUnitClass(UnitComposition::TIME, '250');

        $this->assertEquals(
            '250',
            $time->subtract($time2)->getValue()
        );

        $length = $unit->getUnitClass(UnitComposition::LENGTH, '500');

        $this->setExpectedException('Exception', 'Cannot subtract units of two different types.');

        $time->subtract($length);
    }

    public function testPreConverted()
    {
        $unit = new UnitComposition();

        $time = $unit->getUnitClass(UnitComposition::TIME, '500');

        $this->assertEquals(
            '600',
            $time->preConvertedAdd('100')->getValue()
        );

        $this->assertEquals(
            '500',
            $time->preConvertedSubtract('100')->getValue()
        );

        $this->assertEquals(
            '5',
            $time->preConvertedDivide('100')->getValue()
        );

        $this->assertEquals(
            '500',
            $time->preConvertedMultiply('100')->getValue()
        );
    }

    public function testGet()
    {
        $unit = new UnitComposition();

        $time = $unit->getUnitClass(UnitComposition::TIME, '500');

        $this->assertEquals(
            '500',
            $time->getValue()
        );

        $this->assertEquals(
            's',
            $time->getUnit()
        );

        $this->assertEquals(
            '1',
            $time->getConversionRate('s')
        );

        $unitComp = $time->getUnitsPresent();

        $this->assertEquals(
            1,
            count($unitComp)
        );

        $this->assertEquals(
            1,
            $unitComp['time']
        );
    }

}