<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class MagneticFlux extends ScalarQuantity
{
    const WEBER     = 'Wb';

    protected $units = [
        self::WEBER     => 1
    ];

    protected $native = self::WEBER;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::WEBER]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::MAG_FLUX);
    }

}