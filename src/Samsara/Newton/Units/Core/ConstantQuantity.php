<?php

namespace Samsara\Newton\Units\Core;

use Samsara\Newton\Core\Quantity;

class ConstantQuantity extends Quantity
{

    public function preConvertedAdd($value)
    {
        return $this;
    }

    public function preConvertedSubtract($value)
    {
        return $this;
    }

    public function preConvertedMultiply($value)
    {
        return $this;
    }

    public function preConvertedDivide($value, $precision = 2)
    {
        return $this;
    }

    public function add(Quantity $quantity)
    {
        return $this;
    }

    public function subtract(Quantity $quantity)
    {
        return $this;
    }

}