<?php

namespace Samsara\Newton\Units\Vector;

use Samsara\Newton\Units\Core\VectorQuantity;
use Samsara\Newton\Units\Velocity;

class VectorVelocity extends VectorQuantity
{

    public function __construct(Velocity $velocity, $azimuth, $inclination)
    {
        parent::__construct($velocity, $azimuth, $inclination);
    }

}