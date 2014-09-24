---
layout: default
title: Border
permalink: /terminal-objects/border/
---

Border
==============

If you want to insert a border to break up output, simply use the `border` method. By default, `border` outputs a dashed border with 100 characters in it:

~~~php
$climate->border();
// ----------------------------------------------------------------------------------------------------
~~~

The `border` method takes two optional arguments:

+ Character(s) to be repeated
+ Length of the border

~~~php
$climate->border('*');
// ****************************************************************************************************

$climate->border('-*-');
// -*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--

$climate->border('-*-', 50);
// -*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*
~~~
