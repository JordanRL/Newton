<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Power extends ScalarQuantity
{
    const WATT          = 'W';
    const KILOWATT      = 'kW';
    const MEGAWATT      = 'MW';
    const GIGAWATT      = 'GW';
    const TERAWATT      = 'TW';
    const PETAWATT      = 'PW';
    const HORSEPOWER    = 'hp';

    protected $units = [
        self::WATT          => 1,
        self::KILOWATT      => 2,
        self::MEGAWATT      => 3,
        self::GIGAWATT      => 4,
        self::TERAWATT      => 5,
        self::PETAWATT      => 6,
        self::HORSEPOWER    => 7
    ];

    protected $native = self::WATT;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::WATT]            => '1',
            $this->units[self::KILOWATT]        => '1000',
            $this->units[self::MEGAWATT]        => '1000000',
            $this->units[self::GIGAWATT]        => '1000000000',
            $this->units[self::TERAWATT]        => '1000000000000',
            $this->units[self::PETAWATT]        => '1000000000000000',
            $this->units[self::HORSEPOWER]      => '745.699872'
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::POWER);
    }

}