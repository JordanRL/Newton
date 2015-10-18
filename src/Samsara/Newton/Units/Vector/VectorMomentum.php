<?php

namespace Samsara\Newton\Units\Vector;

use Samsara\Newton\Units\Core\VectorQuantity;
use Samsara\Newton\Units\Momentum;

class VectorMomentum extends VectorQuantity
{

    public function __construct(Momentum $momentum, $azimuth, $inclination)
    {
        parent::__construct($momentum, $azimuth, $inclination);
    }

}