<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class LuminousIntensity extends ScalarQuantity
{
    const CANDELA     = 'cd';

    protected $units = [
        self::CANDELA     => 1
    ];

    protected $native = self::CANDELA;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::CANDELA]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::LUMINOUS_INTENSITY);
    }

}