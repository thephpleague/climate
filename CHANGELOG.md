Changelog
=========

--------

## 3.7.0 - 2021-01-10

### Changed

* [Support] Added support for PHP 8.0.
* [Support] Dropped support for PHP 7.2.

--------

## 3.6.0 - 2020-10-04

### Added

* [Arguments] Add a method to access trailing args as array. [#158](https://github.com/thephpleague/climate/pull/158)

### Fixed

* [Table] Add support for newlines in table data. [#160](https://github.com/thephpleague/climate/pull/160)
* [Checkbox] Don't try to add padding if the there's no spare space. [#161](https://github.com/thephpleague/climate/issues/161)

### Changed

* [Support] Dropped support for PHP 7.1.

--------

## 3.5.2 - 2019-12-01

### Fixed

* [Checkbox] Ensure we can output when the terminal width is unknown. [#156](https://github.com/thephpleague/climate/pull/156)

--------

## 3.5.1 - 2019-11-24

### Fixed

* [Art] Be stricter about matching filenames when looking for art. [#155](https://github.com/thephpleague/climate/issues/155)
* [Support] Provide better support for Windows using GitHub actions.

--------

## 3.5.0 - 2019-02-10

### Added

* [Arguments] Multiple arguments (eg `cli -d foo=bar -d baz=qux`) available via `$climate->arguments->getArray("d")`. [#111](https://github.com/thephpleague/climate/pull/111)
* [Arguments] A new method (`Argument::values()`) replaces the deprecated `valueArray()` method.
* [Spinner] Add an indeterminate progress spinner.
* [Exceptions] All exception now implement `League\CLImate\Exceptions\Exception`.
* [Basic] Allow single lines to be cleared using `$climate->clearLine()`. [#145](https://github.com/thephpleague/climate/issues/145).

### Fixed

* [Arguments] Mixing arguments with/without option values. [#122](https://github.com/thephpleague/climate/issues/122).
* [Output] Prevent `tput` output from being sent to the terminal.
* [Confirm] Accept more reasonable options for yes/no. [#126](https://github.com/thephpleague/climate/issues/126).
* [Radio] Allow ENTER to be used to choose an option. [#140](https://github.com/thephpleague/climate/issues/140).
* [Output] Improve the checks for ANSI color checks. [#128](https://github.com/thephpleague/climate/issues/128) / [#129](https://github.com/thephpleague/climate/issues/129).
* [Art] Only match filenames when looking for art. [#130](https://github.com/thephpleague/climate/issues/130)

### Changed

* [Support] Dropped support for PHP 5.6 and PHP 7.0

--------

## 3.4.1 - 2018-04-29

### Fixed

* [Json] Don't escape slashes when outputting JSON. [#121](https://github.com/thephpleague/climate/pull/121)

--------

## 3.4.0 - 2018-04-28

### Added

* [Logger] Added a Logger class to use CLImate as a PSR-3 logger.

--------

## 3.3.0 - 2018-04-20

### Fixed

* Ensure multibyte strings are supported everywhere.
* Improved support for IDE assistance when using method chaining. [#102](https://github.com/thephpleague/climate/pull/102)
* [Art] Improve handling of missing files. [#114](https://github.com/thephpleague/climate/issues/114)
* [Input] Correct the usage of `defaultTo()` with `accept()`. [#104](https://github.com/thephpleague/climate/pull/104)
* [Windows] Fixed the terminal width detection. [#64](https://github.com/thephpleague/climate/pull/64)

### Added

* [Table] Add support for a prefix argument for each row. [#51](https://github.com/thephpleague/climate/issues/51)
* [Progress] Added an `each()` method. [#112](https://github.com/thephpleague/climate/pull/112)

### Changed

* [Support] Add support for PHP 7.2
* [Support] Drop support for PHP 5.4
* [Support] Drop support for PHP 5.5
* [Support] Drop support for HHVM.
* Suggest the symfony polyfill library is `ext-mbstring` is not available. [#110](https://github.com/thephpleague/climate/pull/110)

--------

## 3.2.4 - 2016-10-30

### Fixed

* [Progres] Allow labels to be shown/hidden on each iteration. [#98](https://github.com/thephpleague/climate/pull/98)

--------

## 3.2.3 - 2016-10-17

### Added

* [Support] Added support for PHP 7.1

--------

## 3.2.2 - 2016-07-18

### Fixed

* [Art] Allow code to be used in a phar. [#86](https://github.com/thephpleague/climate/pull/86)

--------

## 3.2.1 - 2016-04-05

### Added

* [Arguments] Add a `trailing()` method to get any trailing arguments.
* [Progress] Added a `forceRedraw()` method. [#72](https://github.com/thephpleague/climate/issues/72)

### Fixed

* [Checkbox] Don't cancel out the formatting for the first checkbox. [#77](https://github.com/thephpleague/climate/issues/77)
* [Padding] Ensure formatting is handled. [#78](https://github.com/thephpleague/climate/issues/78)
* [Columns] Prevent error when less items than columns are passed. [#75](https://github.com/thephpleague/climate/pull/75)

--------

## 3.2.0 - 2015-08-13

### Added
- Multi-line support for `input` method [https://github.com/thephpleague/climate/pull/67](https://github.com/thephpleague/climate/pull/67)
- `extend` method for _much_ easier extending of CLImate

### Fixed
- Unnecessary progress bar re-drawing when the output hadn't changed [https://github.com/thephpleague/climate/pull/69](https://github.com/thephpleague/climate/pull/69)
- Progress label no longer removed once progress reaches 100% 
- Non-prefixed paramaters for `arguments` method now show in usage description [https://github.com/thephpleague/climate/issues/65](https://github.com/thephpleague/climate/issues/65)

## 3.1.1 - 2015-05-01

### Fixed
- Windows support added for `password` thanks to @Seldaek and [seld/cli-prompt](https://packagist.org/packages/seld/cli-prompt)

## 3.1.0 - 2015-04-30

### Added
- `password` prompt
- `checkboxes` prompt
- `radio` prompt
- 'file' as output option

## 3.0.0 - 2015-03-01

### Changed

- Custom output writers are added simply via the `output` property on CLImate now, as opposed to the immense amount of scaffolding required before

### Added

- Argument parsing
- StdErr output
- Buffer output
- `animate` method for running ASCII animations in the terminal. Because it's fun.
- Input now bolds the default response if it exists

## 2.6.1 - 2015-01-18

### Fixed

- Added `forceAnsiOn` and `forceAnsiOff` methods to address systems that were not identified correctly

## 2.6.0 - 2015-01-07

### Added

- Allow for passing an array of arrays into `columns` method
- `tab` method, for indenting text
- `padding` method, for padding strings to an equal width with a character
- `League\CLImate\TerminalObject\Repeatable` for repeatable objects such as `tab` and `br`
- `League\CLImate\Decorator\Parser\Ansi` and `League\CLImate\Decorator\Parser\NonAnsi`
- Factories:
    + `League\CLImate\Decorator\Parser\ParserFactory`
    + `League\CLImate\Util\System\SystemFactory`
- Terminal Objects now are appropriately namespaced as `Basic` or `Dynamic`
- Readers and Writers are appropriately namespaced as such under `League\CLImate\Util`

### Fixed

- Labels for `advance` method
- Non-ansi terminals will now have plaintext output instead of jumbled characters
- `border` method now default to full terminal width
