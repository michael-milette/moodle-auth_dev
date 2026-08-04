# Change Log

All notable changes to this project will be documented in this file.

## [3.0.0] 2026-08-04

### Changed

- Renamed the plugin from "Auth Development tools" to "Exit Log In As". The old name suggested a developer tool and kept administrators away from a feature most of them use daily.
- The auth_dev component name is unchanged, so existing sites upgrade normally with no migration steps required.

### Added

- Exiting 'Log in as' now works for any user who holds the moodle/user:loginas capability, such as managers, instead of being restricted to site administrators.

### Fixed

- Exiting 'Log in as' no longer redirects to a non-existent course if the course id is invalid.
- Exiting 'Log in as' outside of a course now returns to the site home page, matching the behaviour of Moodle core.

### Updated

- Compatible with Moodle 3.11 to 5.2
- Compatible with PHP 7.4 to 8.4.
- Removed the unnecessary MOODLE_INTERNAL guard from the autoloaded privacy provider class.
- Installation instructions now refer to the Moodle webroot, which is correct both for Moodle 5.x, where the code lives under public/, and for earlier releases.

## [2.3.0] 2026-05-11

### Added

- Add public visibility to user_login method
- Compatible with Moodle 3.9 to 5.1
- Compatible with PHP 7.2 to 8.3.

### Updated

- Remove deprecated legacy_polyfill trait from privacy provider

## [2.2.0] 2024-09-05

### Added

- Added support to invalid user name bug.
- Moodle 4.5 and legacy releases.
- Compatible with PHP 7.2 to 8.3.
