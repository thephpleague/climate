---
layout: layout
title: Dump
---

Dump
==============

The `dump` method allows you to `var_dump` variables out to the terminal:

~~~.language-php
$climate->dump([
  'This',
  'That',
  'Other Thing',
]);
~~~

Which results in:

~~~
array(3) {
  [0]=>
  string(4) "This"
  [1]=>
  string(4) "That"
  [2]=>
  string(11) "Other Thing"
}
~~~
