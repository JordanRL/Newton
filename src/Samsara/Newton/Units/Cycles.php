<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Cycles extends ScalarQuantity
{

    const CYCLES        = 'cycles';

    protected $units = [
        self::CYCLES    => 1
    ];

    protected $native = self::CYCLES;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::CYCLES] => '1',
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::CYCLES);
    }

}