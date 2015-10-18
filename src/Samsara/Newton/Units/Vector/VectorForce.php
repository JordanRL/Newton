<?php

namespace Samsara\Newton\Units\Vector;

use Samsara\Newton\Units\Core\VectorQuantity;
use Samsara\Newton\Units\Force;

class VectorForce extends VectorQuantity
{

    public function __construct(Force $force, $azimuth, $inclination)
    {
        parent::__construct($force, $azimuth, $inclination);
    }

}