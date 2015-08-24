<?php

namespace Samsara\PHPhysics\Units;

use Samsara\PHPhysics\Core\Quantity;
use Samsara\PHPhysics\Core\UnitComposition;

class Energy extends Quantity
{
    const JOULE         = 'J';
    const KILOWATTHOUR  = 'kWh';

    protected $units = [
        self::JOULE         => 1,
        self::KILOWATTHOUR  => 2
    ];

    protected $native = self::JOULE;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::JOULE]           => '1',
            $this->units[self::KILOWATTHOUR]    => '3600'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::ENERGY);
    }

}