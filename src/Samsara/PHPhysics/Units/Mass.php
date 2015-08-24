<?php

namespace Samsara\PHPhysics\Units;

use Samsara\PHPhysics\Core\Quantity;
use Samsara\PHPhysics\Core\UnitComposition;

class Mass extends Quantity
{
    const MICROGRAM     = 'mcg';
    const MILLIGRAM     = 'mg';
    const GRAM          = 'g';
    const KILOGRAM      = 'kg';
    const METRIC_TON    = 't';

    protected $native = self::KILOGRAM;

    protected $units = [
        self::MICROGRAM     => 1,
        self::MILLIGRAM     => 2,
        self::GRAM          => 3,
        self::KILOGRAM      => 4,
        self::METRIC_TON    => 5
    ];

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::MICROGRAM]       => '0.000000001',
            $this->units[self::MILLIGRAM]       => '0.000001',
            $this->units[self::GRAM]            => '0.001',
            $this->units[self::KILOGRAM]        => '1',
            $this->units[self::METRIC_TON]      => '100'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::MASS);
    }

}