<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Pressure extends ScalarQuantity
{

    const PASCAL        = 'Pa';
    const KILOPASCAL    = 'kPa';
    const MEGAPASCAL    = 'MPa';
    const GIGAPASCAL    = 'GPa';
    const TERAPASCAL    = 'TPa';
    const BAR           = 'bar';
    const TORR          = 'Torr';
    const ATMOSPHERE    = 'atm';
    const PSI           = 'psi';

    protected $units = [
        self::PASCAL        => 1,
        self::KILOPASCAL    => 2,
        self::MEGAPASCAL    => 3,
        self::GIGAPASCAL    => 8,
        self::TERAPASCAL    => 4,
        self::BAR           => 5,
        self::TORR          => 6,
        self::ATMOSPHERE    => 7,
        self::PSI           => 9
    ];

    protected $native = self::PASCAL;

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::PASCAL]      => '1',
            $this->units[self::KILOPASCAL]  => '1000',
            $this->units[self::MEGAPASCAL]  => '1000000',
            $this->units[self::GIGAPASCAL]  => '1000000000',
            $this->units[self::TERAPASCAL]  => '1000000000000',
            $this->units[self::BAR]         => '100000',
            $this->units[self::TORR]        => '133.3224',
            $this->units[self::ATMOSPHERE]  => '101325',
            $this->units[self::PSI]         => '6894.8'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::PRESSURE);
    }

}