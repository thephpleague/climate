---
layout: default
title: Animation
permalink: /terminal-objects/animation/
---

Animation
==============

Wait, what? Why does this exist? Because fun, that's why.

Basically `animate` will take ASCII art and run basic animations on it in the terminal.

Just like [Draw](/terminal-objects/draw/), you can add custom ASCII art using the `addArt` method.

## Enter From, Exit To

~~~php
$climate->animation('hello')->exitToRight();
$climate->animation('hello')->exitToLeft();
$climate->animation('hello')->exitToTop();
$climate->animation('hello')->exitToBottom();

$climate->animation('hello')->enterFromRight();
$climate->animation('hello')->enterFromLeft();
$climate->animation('hello')->enterFromTop();
$climate->animation('hello')->enterFromBottom();
~~~
