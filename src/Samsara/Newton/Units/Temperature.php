<?php

namespace Samsara\Newton\Units;

use Samsara\Fermat\Values\Base\NumberInterface;
use Samsara\Newton\Units\Core\ScalarQuantity;
use Samsara\Newton\Core\UnitComposition;

class Temperature extends ScalarQuantity
{

    const KELVIN        = 'K';
    const CELSIUS       = 'ºC';
    const FAHRENHEIT    = 'ºF';

    protected $units = [
        self::KELVIN    => 1,
        self::CELSIUS   => 2,
        self::FAHRENHEIT=> 3
    ];

    protected $native = self::KELVIN;

    public function __construct($value, $unit = null)
    {
        $this->rates = [
            $this->units[self::KELVIN] => '1',
            $this->units[self::CELSIUS] => [
                'to' => function(NumberInterface $value) {
                    return $value->subtract('273.15');
                },
                'from' => function(NumberInterface $value) {
                    return $value->add('273.15');
                }
            ],
            $this->units[self::FAHRENHEIT] => [
                'to' => function(NumberInterface $value) {
                    return $value->multiply(9)->divide(5)->subtract('459.67');
                },
                'from' => function(NumberInterface $value) {
                    return $value->add('459.67')->multiply(5)->divide(9);
                }
            ]
        ];

        parent::__construct($value, $unit);

        $this->setComposition(UnitComposition::TEMPERATURE);
    }

}