<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Resistance extends ScalarQuantity
{
    const OHMS     = 'Ω';

    protected $units = [
        self::OHMS     => 1
    ];

    protected $native = self::OHMS;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::OHMS]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::RESISTANCE);
    }

}