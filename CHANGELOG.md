# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased] - [unreleased]
### Added
- CHANGELOG.md (this file)

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

### Changed
- PhysicsProvider methods now represent equations instead of results, and the result they return depends on the inputs you provide.
- Various bug fixes and typos.

## [0.1.2] - 2015-08-24
### Changed
- Static references in UnitComposition to instance references

## [0.1.1] - 2015-08-24
### Added
- README explaining usage and installation

## [0.1.0] - 2015-08-24
### Added
- Initial commit with Units, UnitComposition, Quantity, etc.

[unreleased]: https://github.com/JordanRL/Newton/compare/v0.3.0...HEAD
[0.3.0]: https://github.com/JordanRL/Newton/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/JordanRL/Newton/compare/v0.1.2...v0.2.0
[0.1.2]: https://github.com/JordanRL/Newton/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/JordanRL/Newton/compare/v0.1.0...v0.1.1
