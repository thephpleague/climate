---
layout: layout
title: Customizing
---

Customizing
==============

If you know the terminal codes, you can customize CLImate with your own colors and commands.

## Custom Colors

You can add your own custom colors:

~~~.language-php
$climate->style->addColor('lilac', 38);
~~~

Once you've added the color, you can use it like any of the other colors:

~~~.language-php
$climate->lilac('What a pretty color.');
$climate->backgroundLilac()->out('This background is a pretty color.');
$climate->out('Just this <lilac>word</lilac> is a pretty color.');
$climate->out('Just this <background_lilac>word</background_lilac> is a pretty color.');
~~~

## Custom Commands

You can also add your own command using either a string or an array of styles, just make sure that the style is defined already.

~~~.language-php
$climate->style->addCommand('rage', 'cyan');
$climate->rage('SOMETHING IS MESSED UP.');

$climate->style->addCommand('holler', ['underline', 'green', 'bold']);
$climate->holler('Yo, what up.');
~~~

Feel free to override any existing commands:

~~~.language-php
$climate->style->addCommand('error', 'light_blue');
$climate->error('Whelp. That did not turn out so well.');
~~~
