---
layout: default
title: Table
permalink: /terminal-objects/table/
---

Table
==============

The `table` method can receive any of the following:

+ Array of arrays
+ Array of associative arrays
+ Array of objects

## Array of Arrays

~~~php
$data = [
    [
      'Walter White',
      'Father',
      'Teacher',
    ],
    [
      'Skyler White',
      'Mother',
      'Accountant',
    ],
    [
      'Walter White Jr.',
      'Son',
      'Student',
    ],
];

$climate->table($data);
~~~

~~~
------------------------------------------
| Walter White     | Father | Teacher    |
------------------------------------------
| Skyler White     | Mother | Accountant |
------------------------------------------
| Walter White Jr. | Son    | Student    |
------------------------------------------
~~~

## Array of (Associative Arrays | Objects)

If you pass in an array of associative arrays or objects, the keys will automatically become the first row (header) of the table.

~~~php
$data = [
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
    [
  		'name'       => 'Walter White Jr.',
  		'role'       => 'Son',
  		'profession' => 'Student',
    ],
];

$climate->table($data);
~~~

~~~
------------------------------------------
| name             | role   | profession |
==========================================
| Walter White     | Father | Teacher    |
------------------------------------------
| Skyler White     | Mother | Accountant |
------------------------------------------
| Walter White Jr. | Son    | Student    |
------------------------------------------
~~~
