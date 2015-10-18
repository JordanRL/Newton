<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Acceleration extends ScalarQuantity
{
    const METERS_PER_SECOND_SQUARED     = 'm/s^2';

    protected $units = [
        self::METERS_PER_SECOND_SQUARED     => 1
    ];

    protected $native = self::METERS_PER_SECOND_SQUARED;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::METERS_PER_SECOND_SQUARED]   => '1'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::ACCELERATION);
    }

}