<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class ConductanceElectric extends ScalarQuantity
{
    const SIEMENS     = 'S';

    protected $units = [
        self::SIEMENS     => 1
    ];

    protected $native = self::SIEMENS;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::SIEMENS]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::CONDUCTANCE_ELEC);
    }

}