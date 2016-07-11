<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class PlaneAngle extends ScalarQuantity
{
    const RADIANS     = 'rad';

    protected $units = [
        self::RADIANS     => 1
    ];

    protected $native = self::RADIANS;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::RADIANS]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::PLANE_ANGLE);
    }

}