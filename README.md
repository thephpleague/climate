<p align="center"><img src="http://climate.thephpleague.com/img/CLImate_Blink.gif" width="300" alt="CLImate" /></p>

[![Latest Version](https://img.shields.io/github/tag/thephpleague/climate.svg?style=flat&label=release)](https://github.com/thephpleague/climate/tags)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
[![Build Status](https://github.com/thephpleague/climate/workflows/.github/workflows/buildcheck.yml/badge.svg?branch=master)](https://github.com/thephpleague/climate/actions?query=branch%3Amaster+workflow%3Abuildcheck)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/climate.svg?style=flat)](https://scrutinizer-ci.com/g/thephpleague/climate/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/climate.svg?style=flat)](https://scrutinizer-ci.com/g/thephpleague/climate)
[![Total Downloads](https://img.shields.io/packagist/dt/league/climate.svg?style=flat)](https://packagist.org/packages/league/climate)

Running PHP from the command line? CLImate is your new best bud.

CLImate allows you to easily output colored text, special formats, and more.


## Installation

The recommended method of installing this library is via [Composer](https://getcomposer.org/).

Run the following command from your project root:

```bash
$ composer require league/climate
```


## Usage

```php
require_once __DIR__ . "/vendor/autoload.php";

$climate = new \League\CLImate\CLImate;

$climate->red('Whoa now this text is red.');
$climate->blue('Blue? Wow!');
```

_Read more at https://climate.thephpleague.com/_  


## Credits

This library was created by [Joe Tannenbaum](https://joe.codes/).  
It is currently maintained and developed by [Craig Duncan](https://twitter.com/duncan3dc).  
Much love to [Damian Makki](https://dribbble.com/damianmakki) for the logo.    
