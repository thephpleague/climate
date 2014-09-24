---
layout: default
title: Combinations
permalink: /styling/combinations/
---

Combinations
==============

You can chain any of the above to get what you want:

~~~php
$climate->backgroundBlue()->green()->blink()->out('This may be a little hard to read.');
~~~

Feeling wild? Just throw them all into one method:

~~~php
$climate->backgroundBlueGreenBlink('This may be a little hard to read.');
~~~

You can apply more than one format to an output, but only one foreground and one background color. Unless you use...

## Tags

You can also apply a color/background color/format to just part of an output:

~~~php
$climate->blue('Please <light_red>remember</light_red> to restart the server.');
$climate->out('Remember to use your <blink><yellow>blinker</yellow></blink> when turning.');
~~~

You can use any of the color or formatting keywords (snake cased) as tags.

To use a background color tag, simply prepend the color with `background_`:

~~~php
$climate->blue('Please <bold><background_light_red>remember</background_light_red></bold> to restart the server.');
~~~
