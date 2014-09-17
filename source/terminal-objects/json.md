---
layout: layout
title: JSON
---

JSON
==============

The `json` method outputs pretty-printed JSON to the terminal:

~~~.language-php
$climate->json([
  'name' => 'Gary',
  'age'  => 52,
  'job'  => 'Engineer',
]);
~~~

~~~.language-javascript
{
    "name": "Gary",
    "age": 52,
    "job": "Engineer"
}
~~~
