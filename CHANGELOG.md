# Changelog

## [Unreleased]
### Fixed
- Fixed missing rename to "Smartposti"

## [1.3.0] - 2025-03-20
### Updated
- itella-mapping.js to v1.3.2
- itella-api to 2.3.9

### Changed
- name "Smartpost" and "Smartpost Itella" to "Smartposti"
- logo to "Smartposti"

### Fixed
- Fixed browser tab title in module controlers

## [1.2.18] - 2024-12-02
### Updated
- itella-api to 2.3.8.1

## [1.2.17] - 2024-09-20
### Added
- Added option to disable display of pickup points that have "Outdoor" parameter

### Fixed
- Fixed that the COD service would not be selected automatically
- Fix error when installing module on server with PHP 5.6

## [1.2.16] - 2023-09-27
### Changed
- Parcel terminal locations API

## [1.2.15] - 2022-12-02
### Added
- feature to change shipping option title in checkout for courier and pickup points

## [1.2.14] - 2022-01-17
### Updated
- itella-api to 2.3.7
- updated logo colors

## [1.2.13] - 2022-01-17
### Changed
- Changed how terminal selector place is determined. To accomodate possible structure differences, it will be added to closes div element from radio input.

## [1.2.12] - 2021-09-30
### Added
- Pickup point product (2711) now supports COD additional service

### Updated
- itella-api to 2.3.4

## [1.2.11] - 2021-09-03
### Changed
- Call carrier now uses Opencart Mail object, this should fix issues when Opencart has custom mail settings instead of using default php mail() function.

## [1.2.10] - 2021-06-28
### Added
- Added new module functionality for sending email with tracking URL upon label generation.

## [1.2.9] - 2021-03-09
### Added
- Add shipment comment to label. Done inside Itella form in order page.

### Updated
- itella-api to 2.3.2

## [1.2.8] - 2021-02-05
### Fixed
- Fixed a typo in lithuanian language for courier called success message

## [1.2.7] - 2021-02-05
### Added
- Price field in settings now accepts formating for cost per weight range. Ranges going from lowest weight to highest.
Format `weight1:price1 ; weight2:price2`
- 2317 (Courier) product now support dual contract settings, second one is for GLS countries only (not LT, LV, EE, FI), if left empty defaults to first contract number

### Fixed
- Fixed an issue with information block inside order form where laoding overlay would not be properly applied

## [1.2.6] - 2021-02-01
### Updated
- itella-api to 2.3.1

### Changed
- applied changes by the itella-api v2.3.1 library

## [1.2.5] - 2021-01-20
### Changed
- name "Itella" to "Smartpost"

### Updated
- translations
- itella-api to 2.3.0

## [1.2.4] - 2020-11-26
### Added
- Estonian localization
- Latvian localization
- Russian localization

## [1.2.3] - 2020-11-18
### Updated
- itella-mapping.js to v1.3.1
- itella-api to 2.2.5

## [1.2.2] - 2020-09-09
### Updated
- itella-mapping.js to v1.2.3

## [1.2.1] - 2020-06-05
### Changed
- Itella courier and pickup point lithuanian translation for checkout display

### Updated
- itella-mapping.js to v1.2.2
- itella-api to 2.2.3

## [1.2.0] - Finland
### Added
- Finland support
- Check for changed modification file version (will be notified in mmodule settings page)

### Updated
- itella-mapping.js to v1.2.0
- itella-api to 2.2.1

### Fixed
- Fixed incorrect TWIG check for selected additional services

## [1.1.1] - Bugfix
### Fixed
- Fixed an issue where getUserToken was calling itself instead of returning oc 2.3 token

## [1.1.0] - 2020-05-14
### Added
- Support for Opencart 3
- Autocheck `session` table `data` column datatype
- This changelog file

### Fixed
- Fixed `itella_order` table `id_pickup_point` column datatype (added autocheck if upgrading from previuos version)

## [1.0.0] - Initial release