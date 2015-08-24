<?php

namespace Samsara\PHPhysics\Units;

use Samsara\PHPhysics\Core\Quantity;
use Samsara\PHPhysics\Core\UnitComposition;

class Voltage extends Quantity
{
    const VOLTS         = 'V';
    const KILOVOLTS     = 'kV';
    const MEGAVOLTS     = 'MV';
    const GIGAVOLTS     = 'GV';
    const TERRAVOLTS    = 'TV';

    protected $units = [
        self::VOLTS         => 1,
        self::KILOVOLTS     => 2,
        self::MEGAVOLTS     => 3,
        self::GIGAVOLTS     => 4,
        self::TERRAVOLTS    => 5
    ];

    protected $native = self::VOLTS;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::VOLTS]       => '1',
            $this->units[self::KILOVOLTS]   => '1000',
            $this->units[self::MEGAVOLTS]   => '1000000',
            $this->units[self::GIGAVOLTS]   => '1000000000',
            $this->units[self::TERRAVOLTS]  => '1000000000000'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::VOLTAGE);
    }

}