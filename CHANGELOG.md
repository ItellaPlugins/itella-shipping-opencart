# Changelog

## [Unreleased] - 
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