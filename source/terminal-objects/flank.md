---
layout: layout
title: Flank
---

Flank
==============

The `flank` method allows you to bring a little more attention to a line:

~~~.language-php
$climate->flank('Look at me. Now.');
// ### Look at me. Now. ###
~~~

You can specify the flanking characters:


~~~.language-php
$climate->flank('Look at me. Now.', '!');
// !!! Look at me. Now. !!!
~~~

And how many flanking characters there should be:

~~~.language-php
$climate->flank('Look at me. Now.', '!', 5);
// !!!!! Look at me. Now. !!!!!
~~~
