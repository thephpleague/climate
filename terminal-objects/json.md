---
layout: default
title: JSON
permalink: /terminal-objects/json/
---

JSON
==============

The `json` method outputs pretty-printed JSON to the terminal:

~~~php
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
