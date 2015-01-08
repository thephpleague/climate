---
layout: default
title: Padding
permalink: /terminal-objects/padding/
---

Padding
==============

The `padding` method pads out a string to a specified length, allowing for neatly organized data. It takes an optional `length` paramater, specifying the total length of the padded string.

~~~php
$padding = $climate->padding(10);

$padding->label('Eggs')->result('$1.99');
$padding->label('Oatmeal')->result('$4.99');
$padding->label('Bacon')->result('$2.99');

// Eggs...... $1.99
// Oatmeal... $4.99
// Bacon..... $2.99
~~~

You can specify the padding character(s) via the `char` method:

~~~php
$padding = $climate->padding(10)->char('-');

$padding->label('Eggs')->result('$1.99');
$padding->label('Oatmeal')->result('$4.99');
$padding->label('Bacon')->result('$2.99');

// Eggs------ $1.99
// Oatmeal--- $4.99
// Bacon----- $2.99
~~~
