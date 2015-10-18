<?php

namespace Samsara\Newton\Units\Vector;

use Samsara\Newton\Units\Acceleration;
use Samsara\Newton\Units\Core\VectorQuantity;

class VectorAcceleration extends VectorQuantity
{

    public function __construct(Acceleration $acceleration, $azimuth, $inclination)
    {
        parent::__construct($acceleration, $azimuth, $inclination);
    }

}