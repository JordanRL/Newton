<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Inductance extends ScalarQuantity
{
    const HENRY     = 'H';

    protected $units = [
        self::HENRY     => 1
    ];

    protected $native = self::HENRY;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::HENRY]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::INDUCTANCE);
    }

}