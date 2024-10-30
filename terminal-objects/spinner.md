---
layout: default
title: Spinner
permalink: /terminal-objects/spinner/
---

Spinner
==============

Spinner displays a running indicator to indicate that a task is being performed.

~~~php
$spinner = $climate->spinner('Running task...');

for ($i = 0; $i < 12; $i++) {
    $spinner->advance();
    sleep(1);
}
~~~

Which will result in:

![Spinner](/img/spinner.gif)

Spinner can be started with a label and with custom characters to display:

~~~php
$spinner = $climate->spinner('My custom label', '[>   ]', '[ >  ]', '[   >]', '[   <]', '[  < ]', '[ <  ]', '[<   ]');

for ($i = 0; $i < 12; $i++) {
    $spinner->advance();
    sleep(1);
}
~~~

$label and $characters are optional. If $label is not provided, no label will be
 displayed. If $characters is not provided, the default characters will be used.

You can also set the spinner characters after creating the instance:

~~~php
$spinner->characters('[>   ]', '[ >  ]', '[   >]', '[   <]', '[  < ]', '[ <  ]', '[<   ]');
~~~

It is also possible to set a waiting time between drawing each stage. 
This is useful to avoid frequent redrawing of the screen.

~~~php
$spinner = $climate->spinner();
$spinner->timeLimit(2);// Redraws the screen every 2 seconds.
for ($i = 0; $i < 12; $i++) {
    $spinner->advance();
    sleep(1);
}
~~~

The `Spinner::advance()` method can be given a label:

~~~php
$spinner = $climate->spinner();
for ($i = 0; $i < 12; $i++) {
    $step = $i + 1;
    $spinner->advance("Step $step...");
    sleep(1);
}
~~~
