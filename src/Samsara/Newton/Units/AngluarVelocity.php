<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class AngularVelocity extends ScalarQuantity
{
    const RADIANS_PER_SECOND     = 'rad/s';

    protected $units = [
        self::RADIANS_PER_SECOND     => 1
    ];

    protected $native = self::RADIANS_PER_SECOND;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::RADIANS_PER_SECOND]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::ANGULAR_VELOCITY);
    }

}