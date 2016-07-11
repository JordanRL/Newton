<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class SolidAngle extends ScalarQuantity
{
    const STERADIAN     = 'sr';

    protected $units = [
        self::STERADIAN     => 1
    ];

    protected $native = self::STERADIAN;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::STERADIAN]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::SOLID_ANGLE);
    }

}