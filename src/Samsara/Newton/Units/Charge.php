<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Charge extends ScalarQuantity
{
    const COULOMB       = 'C';
    const KILOCOULOMB   = 'kC';

    protected $units = [
        self::COULOMB       => 1,
        self::KILOCOULOMB   => 2
    ];

    protected $native = self::COULOMB;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::COULOMB]     => '1',
            $this->units[self::KILOCOULOMB] => '1000'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::CHARGE);
    }

}