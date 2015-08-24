# PHPhysics

## Installation

To install, simply require the package in your composer file:

    composer require samsara/phphysics
    
The project namespace is `Samsara\PHPhysics\*`.

## Usage

There are many ways to use this package. The preferred way involves instantiating the UniComposition class and using it as a factory.

In order to allow new unit classes which extend Quantity to work with the UnitComposition class, it was necessary to force instantiation of it.

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