# Change Log

## 3.0.0
- Added `Crumbs` object to represent each element.
- Added `addCrumb` & `prependCrumb` method.
- Removed `active` option for each crumb. It's now automatically handled by the Twig template.
- Crumbs title is not optional anymore.
- Update to the base breadcrumb template (removal of first, last element, which is handled by Twig now).
- `BreadcrumbManager` is now `Breadcrumb/manager`.
- Removed `src/Breadcrumb.php` Sprinkle class (not needed anyway).
- Added automated tests.
- Added Travis, PHP-CS-Fixer, PHPStan, Codecov, StyleCI configuration.

## 2.0.1
- Updated Readme instructions
- Fix styling

## 2.0.0
- Updated for UserFrosting v4.1.x

## 1.0.0
- Initial release
