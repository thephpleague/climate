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

You can also shorthand it a bit if you'd like and pass the total right into the `progress` method:

~~~php
$climate->progress(100);
~~~

## Manually Advancing

You can also manually advance the bar:

~~~php
$progress = $climate->progress()->total(100);

// Do something

$progress->advance(); // Adds 1 to the current progress

// Do something

$progress->advance(10); // Adds 10 to the current progress

// Do something

$progress->advance(5, 'Still going.'); // Adds 5, displays a label
~~~

## Labels

If you'd like a more descriptive indicator of where you are in the process, pass a **label** into the `current` method:

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

