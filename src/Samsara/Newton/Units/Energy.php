<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Energy extends ScalarQuantity
{
    const JOULE         = 'J';
    const KILOWATTHOUR  = 'kWh';

    protected $units = [
        self::JOULE         => 1,
        self::KILOWATTHOUR  => 2
    ];

    protected $native = self::JOULE;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::JOULE]           => '1',
            $this->units[self::KILOWATTHOUR]    => '3600'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::ENERGY);
    }

}