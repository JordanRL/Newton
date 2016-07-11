<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\UnitComposition;
use Samsara\Newton\Units\Core\ScalarQuantity;

class CatalyticActivity extends ScalarQuantity
{
    const KATAL     = 'kat';

    protected $units = [
        self::KATAL     => 1
    ];

    protected $native = self::KATAL;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::KATAL]   => '1'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::CATALYTIC_ACTIVITY);
    }

}