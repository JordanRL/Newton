<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Amount extends ScalarQuantity
{
    const MOLE     = 'mol';

    protected $units = [
        self::MOLE     => 1
    ];

    protected $native = self::MOLE;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::MOLE]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::AMOUNT);
    }

}