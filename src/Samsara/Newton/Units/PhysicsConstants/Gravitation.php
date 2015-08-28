<?php

namespace Samsara\Newton\Units\PhysicsConstants;

use Samsara\Newton\Units\Core\ConstantQuantity;
use Samsara\Newton\Core\UnitComposition;

class Gravitation extends ConstantQuantity
{

    const GRAVITATION     = 'N (m/kg)^2';

    protected $units = [
        self::GRAVITATION     => 1
    ];

    protected $native = self::GRAVITATION;

    public function __construct()
    {
        $this->rates = [
            $this->units[self::GRAVITATION]   => '1'
        ];

        $value = '0.0000000000667384';
        $unitComposition = new UnitComposition();
        $unit = self::GRAVITATION;

        parent::__construct($value, $unitComposition, $unit);

        $this->defineComposition([
            'length' => 3,
            'mass' => -1,
            'time' => -2
        ]);
    }

}