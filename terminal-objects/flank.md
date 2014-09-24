---
layout: default
title: Flank
permalink: /terminal-objects/flank/
---

Flank
==============

The `flank` method allows you to bring a little more attention to a line:

~~~php
$climate->flank('Look at me. Now.');
// ### Look at me. Now. ###
~~~

You can specify the flanking characters:


~~~php
$climate->flank('Look at me. Now.', '!');
// !!! Look at me. Now. !!!
~~~

And how many flanking characters there should be:

~~~php
$climate->flank('Look at me. Now.', '!', 5);
// !!!!! Look at me. Now. !!!!!
~~~
