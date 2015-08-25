<?php

namespace Samsara\Newton\Units;

use Samsara\Newton\Core\Quantity;
use Samsara\Newton\Core\UnitComposition;

class Time extends Quantity
{
    const MILLISECOND   = 'ms';
    const SECOND        = 's';
    const MINUTE        = 'min';
    const HOUR          = 'hr';
    const DAY           = 'd';
    const WEEK          = 'wk';
    const YEAR          = 'y';

    protected $native = self::SECOND;

    protected $units = [
        self::SECOND        => 1,
        self::MINUTE        => 2,
        self::HOUR          => 3,
        self::DAY           => 4,
        self::WEEK          => 5,
        self::YEAR          => 6,
        self::MILLISECOND   => 7
    ];

    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            $this->units[self::MILLISECOND] => '0.001',
            $this->units[self::SECOND]      => '1',
            $this->units[self::MINUTE]      => '60',
            $this->units[self::HOUR]        => '3600',
            $this->units[self::DAY]         => '86400',
            $this->units[self::WEEK]        => '604800',
            $this->units[self::YEAR]        => '31556736'
        ];

        parent::__construct($value, $unitComposition, $unit);

        $this->setComposition(UnitComposition::TIME);
    }

}