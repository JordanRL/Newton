# Contributing

This document lays out the guidelines for contributing to this project.

## Merge Acceptance Requirements

In order for your pull request to be merged, the merge itself must meet the following guidelines:

- New files created in the pull request must have a corresponding unit test file, or must be covered within an existing test file.
- Your merge may not drop the project's test coverage below 85%.
- Your merge may not drop the project's test coverage by MORE than 5%.
- Your merge must pass Tracis-CI build tests for BOTH PHP 5.6.X and PHP 7.X.

## Coding Requirements

The following guidelines are greatly encouraged, although strict adherence is not necessarily required for your pull request to be merged.

- Coding Style: PSR-2
- Namespacing:
  - Within `Samsara\Newton`
  - PSR-4
- Docblock comments should be included and list, at a minimum:
  - The params
  - The exceptions thrown
  - The return value
- Comments describing information for the developer should accompany any public methods
- All methods should return some value. In other words, void is not considered a valid return value within this project.
- Units, and anything dealing with units, should always treat them as MUTABLE.