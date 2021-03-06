<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Volume extends ScalarQuantity
{

    const CUBIC_METERS      = 'm^3';
    const CUBIC_KILOMETERS  = 'km^3';
    const LITERS            = 'L';
    const GALLONS           = 'G';

    protected $units = [
        self::CUBIC_METERS      => 1,
        self::CUBIC_KILOMETERS  => 2,
        self::LITERS            => 3,
        self::GALLONS           => 4
    ];

    protected $native = self::CUBIC_METERS;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::CUBIC_METERS]        => '1',
            $this->units[self::CUBIC_KILOMETERS]    => '1000000000',
            $this->units[self::LITERS]              => '0.001',
            $this->units[self::GALLONS]             => '0.00378541'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::VOLUME);
    }

}