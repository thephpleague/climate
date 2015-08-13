---
layout: default
title: Extending
permalink: /extending/
---

Extending
==============

Adding your own functionality to CLImate is very simple. First you have to ask yourself, are you creating a **Basic** terminal object, or a **Dynamic** one?

## Basic Terminal Object

A Basic Terminal Object simply prints output to the terminal based on the arguments. [Tables](/terminal-objects/table), [Columns](/terminal-objects/columns), and [Borders](/terminal-objects/border) are examples of existing Basic Terminal Objects.

<p class="message-notice">When creating a Basic Terminal Object, you must implement League\CLImate\TerminalObject\Basic\BasicTerminalObjectInterface.</p>

## Dynamic Terminal Object

A dynamic terminal object returns the object itself. Examples of existing Dynamic terminal objects include [Progress Bar](/terminal-objects/progress-bar), [Input](/terminal-objects/input), and [Animation](/terminal-objects/animation).

For example:

~~~php
// The progress method returns the Progress dynamic terminal object
$progress = $climate->progress(100);

for ($i = 0; $i <= 100; $i++) {
  $progress->current($i);

  // Simulate something happening
  usleep(80000);
}
~~~

<p class="message-notice">When creating a Basic Terminal Object, you must implement League\CLImate\TerminalObject\Dynamic\DynamicTerminalObjectInterface.</p>
