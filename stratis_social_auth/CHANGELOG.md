# Changelog
All notable changes to this extension will be documented in this file.

## [5.2.3] - 2025-10-27
### Fixed
- Fixed buttons in [List.html](Resources/Private/Templates/Bind/List.html)

## [5.2.2] - 2025-10-24
### Changed
- Replaced the button with a simple link in [List.html](Resources/Private/Templates/Bind/List.html)

## [5.2.1] - 2025-10-19
### Fixed
- Rollback InitializePhpSessionMiddleware.
- Added a condition in InitializePhpSessionMiddleware to prevent deadlock situations when generating PDF files.

## [5.2.0] - 2025-10-19
### Removed
- Remove InitializePhpSessionMiddleware to prevent deadlocks.

## [5.1.1] - 2025-10-14
### Fixed
- Fixed interaction with the felogin extension.

## [5.1.0] - 2025-10-09
### Added
- Added proper support for multi-domain functionality.

## [5.0.2] - 2025-10-03
### Added
- Added InitializePhpSessionMiddleware to initialize PHP session.
### Fixed
- Fixed start PHP session

## [5.0.1] - 2025-10-03
### Fixed
- Fixed authentication process.

## [5.0.0] - 2025-09-03
### Added
- FranceConnect V2 support has been implemented.

## [4.0.4] - 2024-10-18
### Fixed
- Fix FC auth process.

## [4.0.3] - 2024-10-03
### Fixed
- Fix Typo3 12 compatibility.

## [4.0.2] - 2024-03-18
### Fixed
- Fix queries inn Base and User repositories.

## [4.0.1] - 2024-01-09
### Fixed
- Event listener registration in `Service.yaml`.

## [4.0.0] - 2023-08-24
### Added
- Typo3 12 compatibility.

## [3.3.5] - 2023-06-08
### Fixed
- Fix FranceConnect button

## [3.3.4] - 2021-12-21
### Added
- PHP 8 compatibility

## [3.3.3] - 2021-12-21
### Fixed
- Made FC work

## [3.3.2] - 2021-12-20
### Fixed
- Fixed FC template

## [3.3.1] - 2021-12-03
### Fixed
- Fixed templates

## [3.3.0] - 2021-12-03
### Added
- TYPO3-11 compatibility

## [3.2.0] - 2021-10-15
### Added
-  Add new wrap for connect form

## [3.1.1] - 2021-07-13
### Fixed
-  Fixed code quality issues.

## [3.1.0] - 2021-04-12
### Added
- Code quality tools.

## [3.0.3] - 2020-10-08
### Fixed
- Fixed dependency injection for Bind controller.

## [3.0.2] - 2020-09-25
### Fixed
- Revert address functional.

## [3.0.1] - 2020-08-05
### Fixed
- Fixed usage of nom d'usage field.
- Fixed error when user try connect not fully unloged.

## [3.0.0] - 2020-08-05
### Added
- Typo3-10 compatibility.

## [2.3.6] - 2020-04-29
### Fixed
- Missed fields synchronization for france connect provider.

## [2.3.5] - 2020-02-19
### Fixed
- Missed `gender` db field definition

## [2.3.4] - 2020-01-21
### Fixed
- Template error after accounts bind
- Write login page to session data

## [2.3.3] - 2019-12-14
### Fixed
- User accounts bind
- Redirect after user accounts bind

## [2.3.2] - 2019-12-16
### Fixed
- Incorrect gender identifiers
- `created_by_france_connect` filling
- Post logout redirect
- Changed s:user.info() to s:user.record() in Bind/List template.

## [2.3.1] - 2019-12-09
### Fixed
- Logout hook if page id is null

## [2.3.0] - 2019-12-03
### Added
- `acr_values` parameter for FranceConnect HybridAuthProvider

## [2.2.6] - 2019-10-26
### Fixed
- Conflict with stratis_felogin
- Catching Login Errors

## [2.2.5] - 2019-10-19
### Fixed
- Social account creation
- Password encryption

## [2.2.4] - 2019-10-17
### Fixed
- Search request for existing user

## [2.2.3] - 2019-10-05
### Fixed
- Logout from main page

## [2.2.2] - 2019-10-03
### Fixed
- Ignore redirect by referrer

## [2.2.1] - 2019-10-03
### Fixed
- FranceConnect HybridAuthProvider

## [2.2.0] - 2019-09-30
### Added
- Publik HybridAuthProvider
- HybridAuth 3.0 support
### Removed
- Typo3 8 support

## [2.1.0] - 2019-07-12
### Fixed
- TSFE initialization on AuthenticationService
- Logout finctional
### Added
- Last bugfixes from Darncy

## [2.0.3] - 2019-07-15
### Fixed
- Add missing required DB columns

## [2.0.2] - 2019-07-12
### Fixed
- General authorization

## [2.0.1] - 2019-07-11
### Fixed
- Added civility field sync
- Fixed field name for last_name

## [2.0.0] - 2019-07-11
### Added
- Migrated to TYPO3 v9
- Refactored repositories and services

## [1.0.0] - 2018-07-12
### Added
- First extension release
