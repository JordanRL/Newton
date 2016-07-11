<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class ConductanceThermal extends ScalarQuantity
{
    const WATT_PER_METER_KELVIN     = 'W/(m·K)';

    protected $units = [
        self::WATT_PER_METER_KELVIN     => 1
    ];

    protected $native = self::WATT_PER_METER_KELVIN;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::WATT_PER_METER_KELVIN]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::CONDUCTANCE_THERM);
    }

}