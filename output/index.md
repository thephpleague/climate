---
layout: default
title: Output
permalink: /output/
---

Output
==============

Prior to 3.0, it was a bit cumbersome to add different writers to CLImate. Starting with 3.0, you have more flexibility and options when it comes to output.

## Available Writers

Out of the box, CLImate comes with three writers:

+ `out` -> `STDOUT` (default)
+ `error` -> `STDERR`
+ `buffer` -> string buffer

## Output Once Using a Writer

You can easily write to another output for just a single line:

~~~php
$climate->to('error')->red('Something went terribly wrong.');
~~~

## Setting the Default Writer

Setting the default writer is simple:

~~~php
$climate->output->defaultTo('error');
~~~

You can also simply add a default writer instead of replacing all of them using `addDefault`:

~~~php
$climate->output->addDefault('buffer');
~~~

## Registering a Custom Writer

All writers must implement `League\CLImate\Util\Writer\WriterInterface`. To register your writer:

~~~php
$climate->output->add('logger', new LogWriter());
~~~

The first parameter is a key that you can reference the writer by. Now you can set it as a default or output with it for one line:

~~~php
$climate->to('logger')->out('Logging this right.... now.');
$climate->output->defaultTo('logger');
~~~

## Multiple Writers at Once

The following methods accept multiple writers: `to`, `defaultTo`, `addDefault`, `add`.

So, for example, if you want to write everything to `STDOUT` and also log it at the same time, you can.

All you need to do is pass an array instead:

~~~php
// Write once to multiple
$climate->to(['error', 'buffer'])->red('Something went terribly wrong.');

// Write every time to multiple
$climate->defaultTo(['error', 'buffer']);
$climate->addDefault(['error', 'buffer']);

// Add two custom writers accessible by one key
$climate->add('combo', [new LogWriter(), new TotallyCustomWriter()]);

// Add a combo of two already registered writers
$cliamte->add('another-combo', ['out', 'error']);
~~~

## Accessing Registered Writers

To access a registered writer, use the `get` method:

~~~php
$climate->output->get('buffer');
~~~

If the key correlates with a single writer class, that class will be returned to you. Otherwise, the array of writer classes will be returned.

So for `buffer`, you have access to the following:

~~~php
// Get the current contents of the buffer string
$climate->output->get('buffer')->get();

// Clean the buffer and throw away the contents
$climate->output->get('buffer')->clean();
~~~

## Getting Available Writers

You can see the writers available to you using the `getAvailable` method:

~~~php
$climate->output->getAvailable();

// [
//    'out'    => 'League\CLImate\Util\Writer\StdOut',
//    'error'  => 'League\CLImate\Util\Writer\StdErr',
//    'buffer' => 'League\CLImate\Util\Writer\Buffer',
// ]
~~~

