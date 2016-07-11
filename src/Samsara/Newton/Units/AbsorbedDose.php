<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class AbsorbedDose extends ScalarQuantity
{
    const GRAY     = 'Gy';

    protected $units = [
        self::GRAY     => 1
    ];

    protected $native = self::GRAY;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::GRAY]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::ABSORBED_DOSE);
    }

}