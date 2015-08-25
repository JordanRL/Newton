<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;

class Temperature extends Quantity
{

    const KELVIN        = 'K';

    protected $units = [
        self::KELVIN    => 1
    ];

    protected $native = self::KELVIN;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::KELVIN] => '1',
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::TEMPERATURE);
    }

}