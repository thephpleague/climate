---
layout: default
title: Commands
permalink: /styling/commands/
---

Commands
==============

Commands are simply pre-defined styles for specific output:

~~~php
$climate->error('Ruh roh.');
$climate->comment('Just so you know.');
$climate->whisper('Not so important, just a heads up.');
$climate->shout('This. This is important.');
$climate->info('Nothing fancy here. Just some info.');
~~~

Note that the `error` command simply applies styles and sends the default stream (using STDOUT). To send content to STDERR see the section on [Output](../../output/).
