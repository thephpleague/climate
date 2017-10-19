---
layout: default
title: Tab
permalink: /terminal-objects/tab/
---

Tab
==============

The `tab` method does exactly that, inserts a tab:

~~~php
$climate->tab()->out('I am all sorts of indented.');
$climate->tab()->tab()->tab()->out('I am even more indented.');
~~~


It can also insert multiple tabs:

~~~php
$climate->tab(7)->out('I am extremely indented.');
~~~
