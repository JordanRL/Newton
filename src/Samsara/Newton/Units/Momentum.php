<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Momentum extends ScalarQuantity
{

    const NEWTON_SECONDS        = 'Ns';
    const KILONEWTON_SECONDS    = 'kNs';
    const MEGANEWTON_SECONDS    = 'MNs';
    const KG_METER_SECONDS      = 'kg-m/s';

    protected $units = [
        self::NEWTON_SECONDS        => 1,
        self::KILONEWTON_SECONDS    => 2,
        self::MEGANEWTON_SECONDS    => 3,
        self::KG_METER_SECONDS      => 1,  // Same as Ns
    ];

    protected $native = self::NEWTON_SECONDS;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::NEWTON_SECONDS]      => '1', // Same as kg-m/s
            $this->units[self::KILONEWTON_SECONDS]  => '1000',
            $this->units[self::MEGANEWTON_SECONDS]  => '1000000'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::MOMENTUM);
    }

}