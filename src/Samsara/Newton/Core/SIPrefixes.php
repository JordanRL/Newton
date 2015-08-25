<?php

namespace Samsara\Newton\Core;

use Samsara\Newton\Provider\MathProvider;

class SIPrefixes
{
    // Larger
    const DECA  = 'da'; // Not currently used
    const HECTO = 'h'; // Not currently used
    const KILO  = 'k';
    const MEGA  = 'M';
    const GIGA  = 'G';
    const TERA  = 'T';
    const PETA  = 'P';
    const EXA   = 'E';
    const ZETTA = 'Z';

    // Smaller
    const DECI  = 'd'; // Not currently used
    const CENTI = 'c'; // Not currently used
    const MILLI = 'm';
    const MICRO = 'μ';
    const NANO  = 'n';
    const PICO  = 'p';
    const FEMTO = 'f';
    const ATTO  = 'a';
    const ZEPTO = 'z';

    protected $scale = [
        self::KILO  => '1000',
        self::MEGA  => '1000000',
        self::GIGA  => '1000000000',
        self::TERA  => '1000000000000',
        self::PETA  => '1000000000000000',
        self::EXA   => '1000000000000000000',
        self::ZETTA => '1000000000000000000000',
        self::MILLI => '0.001',
        self::MICRO => '0.000001',
        self::NANO  => '0.000000001',
        self::PICO  => '0.000000000001',
        self::FEMTO => '0.000000000000001',
        self::ATTO  => '0.000000000000000001',
        self::ZEPTO => '0.000000000000000000001',
    ];

    protected $order = [
        0 => self::ZEPTO,
        1 => self::ATTO,
        2 => self::FEMTO,
        3 => self::PICO,
        4 => self::NANO,
        5 => self::MICRO,
        6 => self::MILLI,
        7 => 'BASE',
        8 => self::KILO,
        9 => self::MEGA,
        10 => self::GIGA,
        11 => self::TERA,
        12 => self::PETA,
        13 => self::EXA,
        14 => self::ZETTA
    ];

    public function convertTo($value, $unit)
    {

    }

    public function matchBest($value, $pos = 7)
    {
        /*
         * Have to use this instead of scalar type hints. Because we are dealing with arbitrarily large numbers, we are
         * using the bc math extension. This means that all numbers are actually strings in order to retain precision.
         *
         * If we used the int or float type hints, PHP 7 would cast string values (which is good), but that would lose
         * precision in the cast (which is bad).
         *
         * is_numeric will achieve the desired effect without altering the $value
         */
        if (!is_numeric($value)) {
            throw new \Exception('Cannot pass a non-numeric value.');
        }

        // The number is more than three orders of magnitude from zero
        if ($value >= 1000 || $value <= -1000) {
            // Increase the exponent by three and try again
            return $this->matchBest(MathProvider::divide($value, 1000), ($pos+1));
        }

        // The number is a decimal less than one from zero
        if ($value < 1 && $value > -1 && $value != 0) {
            // Decrease the exponent by three and try again
            return $this->matchBest(MathProvider::multiply($value, 1000), ($pos-1));
        }

        // If no transformation is needed, we have a special case of the return
        if ($pos == 7) {
            return [
                'value' => $value,
                'scale' => '1',
                'prefix' => ''
            ];
        }

        // Otherwise, we have our answer
        return [
            'value' => $value,
            'scale' => $this->scale[$this->order[$pos]],
            'prefix' => $this->order[$pos]
        ];
    }

}