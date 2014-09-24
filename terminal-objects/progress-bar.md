---
layout: default
title: Progress Bar
permalink: /terminal-objects/progress-bar/
---

Progress Bar
==============

Easily add a progress bar to your output:

~~~php
$progress = $climate->progress()->total(100);

for ($i = 0; $i <= 100; $i++) {
  $progress->current($i);

  // Simulate something happening
  usleep(80000);
}
~~~

Which will result in:

![Progress Bar](/img/progress.gif)

If you'd like a more exact indicator of where you are in the process, pass a label into the `current` method:

~~~php
$languages = [
    'php',
    'javascript',
    'python',
    'ruby',
    'java',
];

$progress = $climate->progress()->total(count($languages));

foreach ($languages as $key => $language) {
  $progress->current($key + 1, $language);

  // Simulate something happening
  usleep(80000);
}
~~~

You can also shorthand it a bit if you'd like and pass the total right into the `progress` method:

~~~php
$climate->progress(100);
~~~
