<?php

namespace Samsara\Newton\Provider;

use RandomLib\Factory;

class MathProvider
{

    public static function add($x, $y)
    {
        return bcadd($x, $y);
    }

    public static function multiply($x, $y)
    {
        return bcmul($x, $y);
    }

    /**
     * @return string
     */
    public static function multipleMultiply(...$nums)
    {
        $total = 1;

        foreach ($nums as $val) {
            $total = bcmul($total, $val);
        }

        return $total;
    }

    public static function divide($numerator, $denominator, $precision = null)
    {
        if ($denominator == 0) {
            throw new \Exception('Cannot divide by zero.');
        }
        
        return bcdiv($numerator, $denominator, $precision);
    }

    public static function subtract($left, $right)
    {
        return bcsub($left, $right);
    }

    public static function exp($base, $exp)
    {
        return bcpow($base, $exp);
    }

    public static function squareRoot($num, $scale = 2)
    {
        return bcsqrt($num, $scale);
    }

    /**
     * @param      $min
     * @param      $max
     * @param null $std_deviation
     * @param int  $step
     *
     * @return float
     *
     * @codeCoverageIgnore
     */
    public static function gaussianRandom($min, $max, $std_deviation = null, $step = 1)
    {
        // This makes it so that the average of the min and max is exactly 2.5 standard deviations from both min and max
        // if the size of a standard deviation is not provided
        if (is_null($std_deviation)) {
            $std_deviation = ($max-$min)/5;
        }

        // Need two random numbers between 0 and 1
        $rand1 = self::randomInt()/PHP_INT_MAX;
        $rand2 = self::randomInt()/PHP_INT_MAX;

        // Must do math...
        $gaussian_number = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
        $mean = ($max + $min) / 2;

        // Okay, this part transforms the point we picked on the unit circle to the range of numbers we were interested in
        $random_number = ($gaussian_number * $std_deviation) + $mean;

        // This takes the chosen number and rounds it to the nearest multiple of $step
        $random_number = round($random_number / $step) * $step;

        // It's possible (!?) that we got a random number out of the range of our min and max... if so, call this function
        // again and pray for better luck
        if($random_number < $min || $random_number > $max) {
            $random_number = self::gaussianRandom($min, $max, $std_deviation, $step);
        }

        return $random_number;
    }

    /**
     * @param array $picker
     *
     * @return int|string
     *
     * @codeCoverageIgnore
     */
    public static function weightedRandom(array $picker)
    {
        // The number
        $rand = self::randomInt(1, array_sum($picker));
        $limit = 0;

        /*
         * Loop through the weighted array. This array is in the format:
         *
         * ['option1' => 20, 'option2' => 15, 'option3' => 30]
         *
         * Where any individual option has a probability of being chosen equal to the weight of the option divided by
         * the sum of all weights in the array.
         *
         * This adds the weights together until the random number is less than or equal to the cumulative weight.
         */
        foreach ($picker as $option => $weight) {
            $limit += $weight;
            if ($rand <= $limit) {
                return $option;
            }
        }
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public static function randomInt($min = 0, $max = PHP_INT_MAX)
    {
        $factory = new Factory();
        $generator = $factory->getLowStrengthGenerator();

        $num = $generator->generateInt($min, $max);

        unset($factory);
        unset($generator);

        return $num;
    }
}