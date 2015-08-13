---
layout: default
title: Extending
permalink: /extending/
---

Extending
==============

Adding your own functionality to CLImate is very simple.

~~~php
$climate->extend('MyProject\Console\MyCustomTerminalObject');

// You can now use your extension within CLImate:
// $climate->myCustomTerminalObject('These pretzels are making me thirsty!');
// $climate->boldMyCustomTerminalObject('These pretzels are making me thirsty!');

$climate->extend([
    'MyProject\Console\MyCustomTerminalObject',
    'MyProject\Console\AnotherCustomTerminalObject'
]);

// $climate->myCustomTerminalObject('These pretzels are making me thirsty!');
// $climate->anotherCustomTerminalObject('Hello... Newman.');
~~~

If you want to use a custom alias instead of the class name of your extension:

~~~php
$climate->extend('MyProject\Console\MyCustomTerminalObject', 'yell');

// $climate->yell('These pretzels are making me thirsty!');
// $climate->backgroundRedYell('These pretzels are making me thirsty!');

$climate->extend([
    'yell'            => 'MyProject\Console\MyCustomTerminalObject',
    'saySuspiciously' => 'MyProject\Console\AnotherCustomTerminalObject'
]);

// $climate->yell('These pretzels are making me thirsty!');
// $climate->saySuspiciously('Hello... Newman.');
~~~

You may also pass in instantiated objects instead of the FQN as a string:

~~~php
$climate->extend(new MyProject\Console\MyCustomTerminalObject);
$climate->extend(new MyProject\Console\MyCustomTerminalObject, 'yell');

$climate->extend([
    new MyProject\Console\MyCustomTerminalObject,
    new MyProject\Console\AnotherCustomTerminalObject
]);

$climate->extend([
    'yell'            => new MyProject\Console\MyCustomTerminalObject,
    'saySuspiciously' => new MyProject\Console\AnotherCustomTerminalObject
]);
~~~

When creating an extension, first you have to ask yourself: Are you creating a [Basic](#basic-terminal-object) Terminal Object, or a [Dynamic](#dynamic-terminal-object) one?

## Basic Terminal Object

A Basic Terminal Object simply prints output to the terminal based on the arguments. [Tables](/terminal-objects/table), [Columns](/terminal-objects/columns), and [Borders](/terminal-objects/border) are examples of existing Basic Terminal Objects.

<p class="message-notice">When creating a Basic Terminal Object, you must implement League\CLImate\TerminalObject\Basic\BasicTerminalObjectInterface.</p>

### Creating

The easiest way to create a Basic Terminal Object is to extend `League\CLImate\TerminalObject\Basic\BasicTerminalObject`. You may pass in arguments in one of two ways: through the constructor, or through an `arguments` method.

All you have to do is provide the `result` method that returns the terminal output as either a string or an array.

Let's say you wanted to write an terminal object that highlights an arbitrary word when used. It might look something like this:

~~~php
namespace MyProject\Console;

use League\CLImate\TerminalObject\Basic\BasicTerminalObject;

class Highlight extends BasicTerminalObject
{
    protected $text;

    protected $search;

    public function __construct($text, $search)
    {
        $this->text   = $text;
        $this->search = $search;
    }

    public function result()
    {
        $replace = "<background-yellow>{$this->search}</background-yellow>";

        return str_replace($this->search, $replace, $this->text);
    }
}
~~~

Then simply use it:

~~~php
$climate->extend('MyProject\Console\Highlight');

$climate->highlight('My whole life was ruined because of the puffy shirt.', 'puffy');
~~~

## Dynamic Terminal Object

A dynamic terminal object returns the object itself. Examples of existing Dynamic terminal objects include [Progress Bar](/terminal-objects/progress-bar), [Input](/terminal-objects/input), and [Animation](/terminal-objects/animation).

For example:

~~~php
// The progress method returns the Progress dynamic terminal object
$progress = $climate->progress(100);

for ($i = 0; $i <= 100; $i++) {
  $progress->current($i);
}
~~~

<p class="message-notice">When creating a Dynamic Terminal Object, you must implement League\CLImate\TerminalObject\Dynamic\DynamicTerminalObjectInterface.</p>

### Creating

The easiest way to create a Basic Terminal Object is to extend `League\CLImate\TerminalObject\Dynamic\DynamicTerminalObject`. Just like the basic object, you may pass in arguments in one of two ways: through the constructor, or through an `arguments` method.

To learn more about how Dynamic Terminal Objects work, you can look at the source code of the [Progress Bar](https://github.com/thephpleague/climate/blob/master/src/TerminalObject/Dynamic/Progress.php), [Input](https://github.com/thephpleague/climate/blob/master/src/TerminalObject/Dynamic/Progress.php), [Padding](https://github.com/thephpleague/climate/blob/master/src/TerminalObject/Dynamic/Padding.php), or [Animation](https://github.com/thephpleague/climate/blob/master/src/TerminalObject/Dynamic/Animation.php) Terminal Objects.
