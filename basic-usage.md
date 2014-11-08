---
layout: default
title: Basic Usage
permalink: /basic-usage/
---

Basic Usage
==============

## Out

The `out` method simply receives a string that will output on a new line:

~~~php
require_once('vendor/autoload.php');

$climate = new League\CLImate\CLImate;

$climate->out('This prints to the terminal.');
~~~

## Inline

The `inline` method is the same as `out` except it will not add a line break at the end of the line:

~~~php
$climate->inline('Waiting');

for ($i = 0; $i < 10; $i++) {
    $climate->inline('.');
}

// Waiting..........
~~~

## But There's More

And you can do that. But that's not very fun. What about adding some [color](/styling/colors/)? [Formatting](/styling/formatting/) it a bit? [Getting super fancy](/terminal-objects/table/)?
