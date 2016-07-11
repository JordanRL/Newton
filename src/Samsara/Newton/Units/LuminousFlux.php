<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class LuminousFlux extends ScalarQuantity
{
    const LUMEN     = 'lm';

    protected $units = [
        self::LUMEN     => 1
    ];

    protected $native = self::LUMEN;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::LUMEN]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::LUMINOUS_FLUX);
    }

}