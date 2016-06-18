<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Frequency extends ScalarQuantity
{

    const HERTZ         = 'Hz';
    const KILOHERTZ     = 'kHz';
    const MEGAHERTZ     = 'MHz';
    const GIGAHERTZ     = 'GHz';
    const TERAHERTZ     = 'THz';

    protected $units = [
        self::HERTZ     => 1,
        self::KILOHERTZ => 2,
        self::MEGAHERTZ => 3,
        self::GIGAHERTZ => 4,
        self::TERAHERTZ => 5
    ];

    protected $native = self::HERTZ;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::HERTZ]       => '1',
            $this->units[self::KILOHERTZ]   => '1000',
            $this->units[self::MEGAHERTZ]   => '1000000',
            $this->units[self::GIGAHERTZ]   => '1000000000',
            $this->units[self::TERAHERTZ]   => '1000000000000'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::FREQUENCY);
    }

}