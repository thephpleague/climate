---
layout: layout
title: Columns
---

Columns
==============

The `columns` method allows you to list out an array of data so that it is easily readable, much like the format of the `ls` command:

~~~.language-php

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
