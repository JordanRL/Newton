# PHPhysics

[![Build Status](https://travis-ci.org/JordanRL/PHPhysics.svg?branch=master)](https://travis-ci.org/JordanRL/PHPhysics) [![Coverage Status](https://coveralls.io/repos/JordanRL/PHPhysics/badge.svg?branch=master&service=github)](https://coveralls.io/github/JordanRL/PHPhysics?branch=master)

## Installation

To install, simply require the package using composer:

    composer require samsara/phphysics
    
Or include it in your `composer.json` file:

```json
{
    "require": {
        "samsara/phphysics": "~0.1"
    }
}
```

The project namespace is `Samsara\PHPhysics\*`.

## Usage

There are many ways to use this package. The preferred way involves instantiating the UnitComposition class and using it as a factory.

In order to allow new unit classes which extend Quantity to work with the UnitComposition class, it was necessary to force instantiation of it. This is explained in further detail in the **Extending** section.

This also means that if you directly instantiate a unit, you must inject a UnitComposition instance.

```php
$unitComposition = new Samsara\PHPhysics\Core\UnitComposition();

$thrust = $unitComposition->getUnitClass('Thrust', 1000); 
echo $thrust; // 1000 Newtons
$mass = $unitComposition->getUnitClass('Mass', 1000); 
echo $mass; // 1000 kg

$acceleration = $thrust->divideBy($mass);

echo $acceleration; // 1 m/s^2

$acceleration->addAlias('N/kg', 'm/s^2')->to('N/kg'); 

echo $acceleration; // 1 N/kg [Gravitational field strength]
```

You can also add unit of different types.

```php
$unitComposition = new Samsara\PHPhysics\Core\UnitComposition();

$thrust = $unitComposition->getUnitClass('Thrust', 1000); 
echo $thrust; // 1000 Newtons
$mass = $unitComposition->getUnitClass('Mass', 500); 
echo $mass; // 500 kg

$mass2 = new Mass(5, $unitComposition, 't'); // 't' = metric ton = 100kg

$mass->add($mass2);
echo $mass; // 1000 kg;
```

The **MathProvider** has static methods which allow you to perform math operations using the BC Math extension. This is used internally in the project as we might very easily exceed the PHP_INT_MAX limit during unit conversions. It also provides several random functions, including a gaussianRandom() method.

The **PhysicsProvider** has static methods which implement some common physics equations using the correct unit classes.

An interesting, non-physics use for something like this library is to determine how many times a given server can execute a loop per second. For instance:

```php
$unitComposition = new UnitComposition();

$start = microtime(true);
for ($i = 0;$i < 10000;$i++) {
    // Loop to test
}
$end = microtime(true);

$duration = $end - $start;
$durationInMilliseconds = $duration * 1000;

$time = new Time($durationInMilliseconds, $unitComposition, 'ms');
$cycles = new Cycles(10000, $unitComposition);

$loopsPerSecond = $unitComposition->naiveDivide($cycles, $time);

// The number of times, as measured, that the computer can execute the loop
// in a single second.
echo $loopsPerSecond->getValue();
```

## Extending

Adding new units is relatively easy. You must first make your unit class, and this class must extend `Samsara\PHPhysics\Core\Quantity`. This class must define a set of units in the `$units` property (where it defines the index for `$rates`), and then define the relative conversion rates between them.

All of the conversions must be in terms of the **native** unit, which is defined in the property `$native`.

### Example

```php
use Samsara\PHPhysics\Core\Quantity;
use Samsara\PHPhysics\Core\UnitComposition;

class MyUnit extends Quantity
{
    const SOMEUNIT = 'g';
    const BIGUNIT = 'bg';
    
    protected $units = [
        // It is the first index in the rates array
        self::SOMEUNIT => 1, 
        self::BIGUNIT => 2
    ];
    
    protected $native = self::SOMEUNIT;
    
    public function __construct($value, UnitComposition $unitComposition, $unit = null)
    {
        $this->rates = [
            // Almost always the 'native' unit is set equal to 1
            $this->units[self::SOMEUNIT] => '1', 
            $this->units[self::BIGUNIT] => '1000',
        ];
        
        parent::__construct($value, $unitComposition, $unit)
        
        $this->setComposition($unitComposition->dynamicUnits['MyUnit']);
    }
}
```

Then, in the calling context, you must prepare the UnitComposition class with the definitions of what types of units this custom unit contains. This allows the UnitComposition class to automatically use your custom class in multiply and divide operations when it is appropriate to do so.

```php
$unitComposition = new UnitComposition();

// This will automatically instatiate the class Namespaced\MyUnit()
// when 'time' has an exponent of 2, and 'mass' has an exponent of 1
// after multiply or divide operations using the naive*() methods.
//
// The last argument defines how you can refer to the unit in the 
// factory method: getUnitClass()
$unitComposition->addUnit('Namespaced\\MyUnit', ['time' => 2, 'mass' => 1], 'MyUnit');

// Now we can instantiate two ways:

// $myunit is now an object of type MyUnit, in its native units, with a value of zero
$myunit = $unitComposition->getUnitClass('MyUnit'); 
// Object of MyUnit type in native units with value 1000
$myunit2 = $unitComposition->getUnitClass('MyUnit', 1000); 

// OR

// MyUnit object in BIGUNIT with value 1 == 1000 in SOMEUNIT
$myunit3 = new Namespaced\MyUnit(1, $unitComposition, 'bg'); 

// We can add them if we want

// Automatically converts. $myunit3 now has value of 2 and units of BIGUNIT.
$myunit3->add($myunit2)->add($myunit); 
```

Only the instance of UnitComposition prepared in the way outlined above, with a call to addUnit(), will understand how to automatically return an instance of MyUnit(). Because of this, it is suggested that you treat the UnitComposition class as a service, and use a single instance of it within your application.