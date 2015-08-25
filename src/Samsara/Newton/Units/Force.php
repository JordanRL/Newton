<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;

class Force extends Quantity
{
    const NEWTON        = 'N';
    const KILONEWTON    = 'kN';
    const MEGANEWTON    = 'MN';
    const GIGANEWTON    = 'GN';

    protected $units = [
        self::NEWTON        => 1,
        self::KILONEWTON    => 2,
        self::MEGANEWTON    => 3,
        self::GIGANEWTON    => 4
    ];

    protected $native = self::NEWTON;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::NEWTON]      => '1',
            $this->units[self::KILONEWTON]  => '1000',
            $this->units[self::MEGANEWTON]  => '1000000',
            $this->units[self::GIGANEWTON]  => '1000000000',
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::FORCE);
    }

}