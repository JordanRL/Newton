<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Capacitance extends ScalarQuantity
{
    const FARAD     = 'F';

    protected $units = [
        self::FARAD     => 1
    ];

    protected $native = self::FARAD;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::FARAD]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::CAPACITANCE);
    }

}