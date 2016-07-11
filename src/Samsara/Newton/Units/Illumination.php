<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Illumination extends ScalarQuantity
{
    const LUX     = 'lx';

    protected $units = [
        self::LUX     => 1
    ];

    protected $native = self::LUX;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::LUX]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::ILLUMINATION);
    }

}