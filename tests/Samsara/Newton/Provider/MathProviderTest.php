<?php

namespace Samsara\Newton\Provider;

class MathProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testAdd()
    {
        $this->assertEquals(
            '100',
            MathProvider::add(25, '75')
        );

        $this->assertEquals(
            '1000000000000000000000000000000',
            MathProvider::add('999999999999999999999999999999', '1')
        );
    }

    public function testSubtract()
    {
        $this->assertEquals(
            '25',
            MathProvider::subtract('100', '75')
        );

        $this->assertEquals(
            '999999999999999999999999999999',
            MathProvider::subtract('1000000000000000000000000000000', '1')
        );
    }

    public function testMultiply()
    {
        $this->assertEquals(
            '25',
            MathProvider::multiply('5', '5')
        );

        $this->assertEquals(
            '5000000000000000000000000000000',
            MathProvider::multiply('1000000000000000000000000000000', '5')
        );
    }

    public function testDivide()
    {
        $this->assertEquals(
            '5',
            MathProvider::divide('25', '5')
        );

        $this->assertEquals(
            '1000000000000000000000000000000',
            MathProvider::divide('5000000000000000000000000000000', '5')
        );
    }

    public function testMultipleMultiply()
    {
        $this->assertEquals(
            '125',
            MathProvider::multipleMultiply('5', '5', '5')
        );
    }

    public function testExp()
    {
        $this->assertEquals(
            '1000000000000000000000000000000',
            MathProvider::exp('10', '30')
        );
    }

    public function testSquareRoot()
    {
        $this->assertEquals(
            '5',
            MathProvider::squareRoot('25')
        );
    }

}