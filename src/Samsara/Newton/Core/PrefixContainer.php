<?php

namespace Samsara\Newton\Core;

use Samsara\Fermat\Values\Base\NumberInterface;

class PrefixContainer
{
    
    public $scale;
    
    public $prefixPos;
    
    public function __construct($scale, $prefixPos)
    {
        
        $this->scale = $scale;
        $this->prefixPos = $prefixPos;
        
    }
    
    public function makeUnitString($unit)
    {
        return SIPrefixes::getUnitPrefixString($this->prefixPos).$unit;
    }
    
    public function applyScaling(NumberInterface $value)
    {
        return $value->multiply($this->scale);
    }
    
}