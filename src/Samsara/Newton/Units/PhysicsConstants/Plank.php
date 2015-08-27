<?php

namespace Samsara\Newton\Units\PhysicsConstants;

use Samsara\Newton\Units\Core\ConstantQuantity;
use Samsara\Newton\Core\UnitComposition;

class Planck extends ConstantQuantity
{
    const PLANCK     = 'm^2 kg/s';

    protected $units = [
        self::PLANCK     => 1
    ];

    protected $native = self::PLANCK;

    public function __construct()
    {
        $this->rates = [
            $this->units[self::PLANCK]   => '1'
        ];

        $value = '0.000000000000000000000000000000000662606957';
        $unitComposition = new UnitComposition();
        $unit = self::PLANCK;

        parent::__construct($value, $unitComposition, $unit);

        $this->defineComposition([
            'length' => 2,
            'mass' => 1,
            'time' => -1
        ]);
    }
}