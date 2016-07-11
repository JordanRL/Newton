<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class MagneticFluxDensity extends ScalarQuantity
{
    const TESLA     = 'T';

    protected $units = [
        self::TESLA     => 1
    ];

    protected $native = self::TESLA;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::TESLA]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::MAG_FLUX_DENSITY);
    }

}