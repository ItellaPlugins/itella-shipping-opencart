# Changelog

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