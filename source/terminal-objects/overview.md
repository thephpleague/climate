---
layout: layout
title: Terminal Objects
---

Terminal Objects
==============

Terminal Objects are classes that allow for a little more than just basic output. They can transform your data into something more readable, allow for more specific spacing, draw attention to important output, and more.

## Styling

You can combine any of the styling options with Terminal Objects. All of the following are examples of things you could do:

~~~.language-php
$climate->redTable([
    [
      'name'       => 'Walter White',
      'role'       => 'Father',
      'profession' => 'Teacher',
    ],
    [
      'name'       => 'Skyler White',
      'role'       => 'Mother',
      'profession' => 'Accountant',
    ],
]);

$climate->bold()->backgroundBlue()->border();

$climate->underlineJson([
  'name' => 'Gary',
  'age'  => 52,
  'job'  => '<blink>Engineer</blink>',
]);
~~~
