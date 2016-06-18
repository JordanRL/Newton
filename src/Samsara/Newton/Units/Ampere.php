<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Ampere extends ScalarQuantity
{
    const AMPERE        = 'A';
    const KILOAMPERE    = 'kA';
    const MEGAAMPERE    = 'MA';

    protected $units = [
        self::AMPERE        => 1,
        self::KILOAMPERE    => 2,
        self::MEGAAMPERE    => 3
    ];

    protected $native = self::AMPERE;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::AMPERE]      => '1',
            $this->units[self::KILOAMPERE]  => '1000',
            $this->units[self::MEGAAMPERE]  => '1000000'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::AMPERE);
    }

}