<?php

namespace Samsara\Newton\Units\PhysicsConstants;

class ConstantsTest extends \PHPUnit_Framework_TestCase
{

    public function testGravitation()
    {
        $gravitation = new Gravitation();

        $this->assertInstanceOf(
            'Samsara\\Newton\\Units\\PhysicsConstants\\Gravitation',
            $gravitation
        );

        $this->assertEquals(
            '0.0000000000667384',
            $gravitation->getValue()
        );

        $gravitation->preConvertedAdd(1);
        $gravitation->preConvertedMultiply(2);
        $gravitation->preConvertedDivide(10);
        $gravitation->preConvertedSubtract(1);
        $gravitation->add($gravitation);
        $gravitation->add($gravitation);
        $gravitation->subtract($gravitation);

        $this->assertEquals(
            '0.0000000000667384',
            $gravitation->getValue()
        );

        $this->assertEquals(
            'N (m/kg)^2',
            $gravitation->getUnit()
        );
    }

}