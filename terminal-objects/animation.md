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

Valid directions are 'top', 'bottom', 'left', 'right'.

<img alt="Oh, Hello Animation" src="/img/oh-hello-animation.gif" style="max-width:100%" />

## Enter From, Exit To

~~~php
$climate->animation('hello')->enterFrom('right');
$climate->animation('hello')->enterFrom('left');
$climate->animation('hello')->enterFrom('top');
$climate->animation('hello')->enterFrom('bottom');

$climate->animation('hello')->exitTo('right');
$climate->animation('hello')->exitTo('left');
$climate->animation('hello')->exitTo('top');
$climate->animation('hello')->exitTo('bottom');
~~~

## Scroll

~~~php
$climate->animation('hello')->scroll('right');
$climate->animation('hello')->scroll('left');
$climate->animation('hello')->scroll('top');
$climate->animation('hello')->scroll('bottom');
~~~

## Speed

You can alter the speed of the animation with the `speed` method. The paramter should be an integer representing the percentage of the default speed.

For example, 50 would make it slower by half, whereas 200 would make it run at twice the speed.

~~~php
// This will animate twice as fast
$climate->animation('hello')->speed(200)->scroll('right');
~~~

## Custom Animations

Let's say you have some time on your hands. You can create a directory of text files that represent each keyframe in an animation and just run it manually:

~~~php
$climate->addArt(__DIR__ . '/custom-animation');
$climate->animation('custom-animation')->run();
~~~

