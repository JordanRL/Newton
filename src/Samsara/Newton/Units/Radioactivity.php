<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class Radioactivity extends ScalarQuantity
{
    const BECQUEREL     = 'Bq';
    const CURIE         = 'Ci';
    const RUTHERFORD    = 'Rd';

    protected $units = [
        self::BECQUEREL     => 1,
        self::CURIE         => 2,
        self::RUTHERFORD    => 3
    ];

    protected $native = self::BECQUEREL;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::BECQUEREL]   => '1',
            $this->units[self::CURIE]       => '37000000000',
            $this->units[self::RUTHERFORD]  => '1000000'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::RADIOACTIVITY);
    }

}