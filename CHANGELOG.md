# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased] - [unreleased]
### Added
- Unit test for Planck constant
- Unit tests for exceptions in PhysicsProvider
- **Dependency:** 
  - samsara/fermat: dev-dev
- ScalarQuantity (extending Quantity)
- VectorQuantity (extending Quantity)
- VectorAcceleration (extending VectorQuantity)
- VectorForce (extending VectorQuantity)
- VectorMomentum (extending VectorQuantity)
- VectorVelocity (extending VectorQuantity)
- `pecl install stats` to travis config
- Divide by zero exception in UnitComposition (how did that get removed?)

### Removed
- MathProvider class
- MathProvider test
 
### Changed
- `throw new \Exception` to `throw new \InvalidArgumentException` in PhysicsProvider where appropriate
- All dimensionless physics unit (i.e. Acceleration, Energy, etc.) now extend ScalarQuantity
- All MathProvider usages (removed) to BCProvider usages (from samsara/fermat)

### Fixed
- **Renamed:** Plank.php -> Planck.php (incorrectly named file)

## [1.0.0] - 2015-10-09
### Added
- CHANGELOG.md (this file)

### Changed
- Added DocBlocks and comments for all public methods
- Examined the visibility of methods and properties in each class

## [0.3.0] - 2015-08-28
### Added
- A protected method on Quantity to allow a Unit to directly define its unit composition array
- Constants
  - Gravitation Constant
  - Planck's Constant
- Universal Gravitation Equation to the PhysicsProvider

## [0.2.0] - 2015-08-27
### Added
- Units can now calculate square roots.
- Instrumentation
  - Travis-CI
  - Coveralls
- CONTRIBUTING.md file with Contribution Guidelines
- COPYRIGHT file
- LICENSE file
- "Extending" section to README.md
- "Contributing" section to README.md
- Unit tests
- **New Dependency (Dev):** PHPUnit 4.8.*
- Quantity::preConvertedMultiply and Quantity::preConvertedDivide
- **New Units:**
  - Cycles
  - Frequency
  - Momentum
  - Temperature
- A naiveMultiOpt method for intelligently calculating the result of multiple multiplies and divides at once.

### Changed
- PhysicsProvider methods now represent equations instead of results, and the result they return depends on the inputs you provide.
- Renamed Project: PHPhysics => Newton
- Fixed places where native math operations were being used instead of MathProvider.
- Abstracted unit comp array comparison so that code can be reused in more places.
- Bug where unit comp arrays might match the wrong unit due to ordering of the array.
- Fixed condition where units might get set to non-numeric values, or get their unit changed permanently inside of a math operation.
- Fixed divide by zero problem in MathProvider

## [0.1.2] - 2015-08-24
### Changed
- Static references in UnitComposition to instance references

## [0.1.1] - 2015-08-24
### Added
- README explaining usage and installation

## 0.1.0 - 2015-08-24
### Added
- Initial commit with Units, UnitComposition, Quantity, etc.

[unreleased]: https://github.com/JordanRL/Newton/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/JordanRL/Newton/compare/v0.3.0...v1.0.0
[0.3.0]: https://github.com/JordanRL/Newton/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/JordanRL/Newton/compare/v0.1.2...v0.2.0
[0.1.2]: https://github.com/JordanRL/Newton/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/JordanRL/Newton/compare/v0.1.0...v0.1.1
