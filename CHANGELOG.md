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
