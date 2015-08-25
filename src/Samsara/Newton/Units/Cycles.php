<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;

class Cycles extends Quantity
{

    const CYCLES        = 'cycles';

    protected $units = [
        self::CYCLES    => 1
    ];

    protected $native = self::CYCLES;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::CYCLES] => '1',
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::CYCLES);
    }

}