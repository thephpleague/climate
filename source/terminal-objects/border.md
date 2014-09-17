---
layout: layout
title: Borders
---

Borders
==============

If you want to insert a border to break up output, simply use the `border` method. By default, `border` outputs a dashed border with 100 characters in it:

~~~.language-php
$climate->border();
// ----------------------------------------------------------------------------------------------------
~~~

The `border` method takes two optional arguments:

+ Character(s) to be repeated
+ Length of the border

~~~.language-php
$climate->border('*');
// ****************************************************************************************************

$climate->border('-*-');
// -*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--

$climate->border('-*-', 50);
// -*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*
~~~
