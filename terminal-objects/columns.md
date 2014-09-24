---
layout: default
title: Columns
permalink: /terminal-objects/columns/
---

Columns
==============

The `columns` method allows you to list out an array of data so that it is easily readable, much like the format of the `ls` command:

~~~php
$data = [
    '12 Monkeys',
    '12 Years a Slave',
    'A River Runs Through It',
    'Across the Tracks',
    'Babel',
    'Being John Malkovich',
    'Burn After Reading',
    'By the Sea',
    'Confessions of a Dangerous Mind',
    'Contact',
    'Cool World',
    'Cutting Class',
    'Fight Club',
    'Fury',
    'Happy Feet Two',
    'Happy Together',
    'Hunk',
    'Inglourious Basterds',
    'Interview with the Vampire',
    'Johnny Suede',
    'Kalifornia',
    'Killing Them Softly',
    'Legends of the Fall',
    'Less Than Zero',
    'Meet Joe Black',
    'Megamind',
    'Moneyball',
];

$climate->columns($data);
~~~

which results in:

~~~
12 Monkeys                          Contact                  Interview with the Vampire
12 Years a Slave                    Cool World               Johnny Suede
A River Runs Through It             Cutting Class            Kalifornia
Across the Tracks                   Fight Club               Killing Them Softly
Babel                               Fury                     Legends of the Fall
Being John Malkovich                Happy Feet Two           Less Than Zero
Burn After Reading                  Happy Together           Meet Joe Black
By the Sea                          Hunk                     Megamind
Confessions of a Dangerous Mind     Inglourious Basterds     Moneyball
~~~

You can specify the number of columns by passing in a second parameter:

~~~php
$climate->columns($data, 4);
~~~

Otherwise CLImate will try to figure out how it best fits in your terminal.
