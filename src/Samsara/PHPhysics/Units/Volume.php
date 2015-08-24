<?php

namespace Samsara\PHPhysics\Units;

use Samsara\PHPhysics\Core\Quantity;
use Samsara\PHPhysics\Core\UnitComposition;

class Volume extends Quantity
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

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::CUBIC_METERS]        => '1',
            $this->units[self::CUBIC_KILOMETERS]    => '1000000000',
            $this->units[self::LITERS]              => '0.001',
            $this->units[self::GALLONS]             => '0.00378541'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::VOLUME);
    }

}