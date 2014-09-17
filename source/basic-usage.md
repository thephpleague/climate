---
layout: layout
title: Basic Usage
---

Basic Usage
==============

The `out` method simply receives a string that will output on a new line:

~~~.language-php
require_once('vendor/autoload.php');

$climate = new League\CLImate\CLImate;

$climate->out('This prints to the terminal.');
~~~

And you can do that. But that's not very fun. What about adding some [color](/styling/colors/)? [Formatting](/styling/formatting/) it a bit? [Getting super fancy](/terminal-objects/table/)?
