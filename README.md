<p align="center"><img src="http://climate.thephpleague.com/img/CLImate_Blink.gif" width="300" alt="CLImate" /></p>

[![Latest Version](https://img.shields.io/github/tag/thephpleague/climate.svg?style=flat&label=release)](https://github.com/thephpleague/climate/tags)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/thephpleague/climate/master.svg?style=flat)](https://travis-ci.org/thephpleague/climate)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/climate.svg?style=flat)](https://scrutinizer-ci.com/g/thephpleague/climate/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/climate.svg?style=flat)](https://scrutinizer-ci.com/g/thephpleague/climate)
[![Total Downloads](https://img.shields.io/packagist/dt/league/climate.svg?style=flat)](https://packagist.org/packages/league/climate)

Running PHP from the command line? CLImate is your new best bud.

CLImate allows you to easily output colored text, special formats, and more.


## Installation
Using [composer](https://packagist.org/packages/league/climate):
```bash
$ composer require league/climate
```


## Quick Example
```php
require_once __DIR__ . "vendor/autoload.php";

$climate = new \League\CLImate\CLImate;

$climate->red('Whoa now this text is red.');
$climate->blue('Blue? Wow!');
```

_Read more at https://climate.thephpleague.com/_  


## Credits

This library was created by [Joe Tannenbaum](https://joe.codes/).  
Much love to [Damian Makki](https://dribbble.com/damianmakki) for the logo.  
