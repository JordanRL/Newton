<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Density extends ScalarQuantity
{

    const KG_PER_CUBIC_METER        = 'kg/m^3';
    const G_PER_CUBIC_CENTIMETER    = 'g/cm^3';

    protected $units = [
        self::KG_PER_CUBIC_METER        => 1,
        self::G_PER_CUBIC_CENTIMETER    => 2
    ];

    protected $native = self::KG_PER_CUBIC_METER;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::KG_PER_CUBIC_METER]      => '1',
            $this->units[self::G_PER_CUBIC_CENTIMETER]  => '0.001'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::DENSITY);
    }

}