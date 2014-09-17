---
layout: layout
title: Colors
---

Colors
==============

There are many pre-defined colors at your disposal:

+ Black
+ Red
+ Green
+ Yellow
+ Blue
+ Magenta
+ Cyan
+ Light Gray
+ Dark Gray
+ Light Red
+ Light Green
+ Light Yellow
+ Light Blue
+ Light Magenta
+ Light Cyan
+ White

~~~.language-php
$climate->red('Whoa now this text is red.');
$climate->blue('Blue? Wow!');
$climate->lightGreen('It is not easy being (light) green.');
~~~

If you prefer, you can also simply chain the color method and continue using `out`:

~~~.language-php
$climate->red()->out('Whoa now this text is red.');
$climate->blue()->out('Blue? Wow!');
$climate->lightGreen()->out('It is not easy being (light) green.');
~~~

## Backgrounds

To to apply a color as a background, simply prepend the color method with `background`:

~~~.language-php
$climate->backgroundRed('Whoa now this text has a red background.');
$climate->backgroundBlue()->out('Blue background? Wow!');
$climate->backgroundLightGreen()->out('It is not easy being (light) green (background).');
~~~
