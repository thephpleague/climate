---
layout: layout
title: Input
---

Input
==============

You can create a user prompt via the `input` method to get information from the user:

~~~.language-php
$input = $climate->input('How you doin?');

$response = $input->prompt();
~~~

## Acceptable Answers

If you only want to accept certain answers from the user, you can specify those using the `accept` method. Simply pass an array in:

~~~.language-php
$input = $climate->input('How you doin?');
$input->accept(['Fine', 'Ok']);

$response = $input->prompt();
~~~

If the user doesn't respond with an acceptable answer (case insensitive), they will be re-prompted until they do.

If you'd like to give the user a heads up as to what you are expecting from them, simply pass `true` in as a second parameter:

~~~.language-php
$input = $climate->input('How you doin?');
$input->accept(['Fine', 'Ok'], true);

$response = $input->prompt();
// How you doin? [Fine/Ok]
~~~

If you only want the user to type in *exactly* what you specified, you can use the `strict` method:

~~~.language-php
$input = $climate->input('How you doin?');
$input->accept(['Fine', 'Ok']);
$input->strict();

$response = $input->prompt();
// 'fine' or 'ok' will cause a re-prompt
~~~

## Confirmation

The `confirm` method will accept only `y` or `n` (strict). The `confirmed` method will prompt the user and return a boolean:

~~~.language-php
$input = $climate->confirm('Continue?');

// Continue? [y/n]
if ($input->confirmed()) {
    // Do your thing here
} else {
    // Don't do your thing
}
~~~
