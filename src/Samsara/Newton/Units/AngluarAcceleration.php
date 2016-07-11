<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class AngularAcceleration extends ScalarQuantity
{
    const RADIANS_PER_SECOND_SQUARED     = 'rad/s^2';

    protected $units = [
        self::RADIANS_PER_SECOND_SQUARED     => 1
    ];

    protected $native = self::RADIANS_PER_SECOND_SQUARED;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::RADIANS_PER_SECOND_SQUARED]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::ANGULAR_ACCELERATION);
    }

}