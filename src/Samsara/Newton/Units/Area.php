<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;

class Area extends Quantity
{
    // Metric system
    const SQUARE_METER      = 'm^2';
    const HECTARE           = 'ha';
    const SQUARE_KILOMETER  = 'km^2';
    // Imperial system
    const SQUARE_INCH       = 'in^2';
    const SQUARE_FEET       = 'ft^2';
    const SQUARE_YARD       = 'yd^2';
    const ACRE              = 'ac';
    const SQUARE_MILE       = 'mi^2';

    protected $native = self::SQUARE_METER;

    protected $units = [
        self::SQUARE_METER      => 1,
        self::HECTARE           => 2,
        self::SQUARE_KILOMETER  => 3,
        self::SQUARE_INCH       => 4,
        self::SQUARE_FEET       => 5,
        self::SQUARE_YARD       => 6,
        self::ACRE              => 7,
        self::SQUARE_MILE       => 8
    ];

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::SQUARE_METER]        => '1',
            $this->units[self::HECTARE]             => '100',
            $this->units[self::SQUARE_KILOMETER]    => '1000000',
            $this->units[self::SQUARE_INCH]         => '0.00064516',
            $this->units[self::SQUARE_FEET]         => '0.09290304',
            $this->units[self::SQUARE_YARD]         => '0.83612736',
            $this->units[self::ACRE]                => '247.105',
            $this->units[self::SQUARE_MILE]         => '2589988.110336'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::AREA);
    }

}