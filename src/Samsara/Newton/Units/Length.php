<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Length extends ScalarQuantity
{
    // Metric system
    const MILLIMETER        = 'mm';
    const CENTIMETER        = 'cm';
    const METER             = 'm';
    const KILOMETER         = 'km';
    // Imperial system
    const INCH              = 'in';
    const FOOT              = 'ft';
    const YARD              = 'yd';
    const MILE              = 'mi';
    // Other systems
    const NAUTICAL_MILE     = 'nmi';
    // Stellar units
    const ASTRONOMICAL_UNIT = 'AU';
    const LIGHT_YEAR        = 'ly';
    const PARSEC            = 'psc';

    protected $units = [
        self::MILLIMETER        => 1,
        self::CENTIMETER        => 2,
        self::METER             => 3,
        self::KILOMETER         => 4,
        self::INCH              => 5,
        self::FOOT              => 6,
        self::YARD              => 7,
        self::MILE              => 8,
        self::NAUTICAL_MILE     => 9,
        self::ASTRONOMICAL_UNIT => 10,
        self::LIGHT_YEAR        => 11,
        self::PARSEC            => 12
    ];

    /**
     * @var string native unit name
     */
    protected $native = self::METER;


    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::MILLIMETER]        => '0.001',
            $this->units[self::CENTIMETER]        => '0.01',
            $this->units[self::METER]             => '1',
            $this->units[self::KILOMETER]         => '1000',
            $this->units[self::INCH]              => '0.0254',
            $this->units[self::FOOT]              => '0.3048',
            $this->units[self::YARD]              => '0.9144',
            $this->units[self::MILE]              => '1609.34',
            $this->units[self::NAUTICAL_MILE]     => '1852',
            $this->units[self::ASTRONOMICAL_UNIT] => '149597870700',
            $this->units[self::LIGHT_YEAR]        => '9460528400000000'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::LENGTH);
    }

}