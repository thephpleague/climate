---
layout: default
title: Input
permalink: /terminal-objects/input/
---

Input
==============

There are several ways you can get information from a user: [a basic input](#basic-input), [confirmation](#confirmation), [password](#password), [checkboxes](#checkboxes), and [radio buttons](#radio-buttons).

## Basic Input

~~~php
$input = $climate->input('How you doin?');

$response = $input->prompt();
~~~

## Multi-line Input

~~~php
$input = $climate->input('>>>');
$input->multiLine();

$response = $input->prompt(); // Will wait for ^D before returning
~~~

### Acceptable Answers

#### Via an Array

If you only want to accept certain answers from the user, you can specify those using the `accept` method. Simply pass an array in:

~~~php
$input = $climate->input('How you doin?');
$input->accept(['Fine', 'Ok']);

$response = $input->prompt();
~~~

If the user doesn't respond with an acceptable answer (case insensitive), they will be re-prompted until they do.

If you'd like to give the user a heads up as to what you are expecting from them, simply pass `true` in as a second parameter:

~~~php
$input = $climate->input('How you doin?');
$input->accept(['Fine', 'Ok'], true);

$response = $input->prompt();
// How you doin? [Fine/Ok]
~~~

If you only want the user to type in *exactly* what you specified, you can use the `strict` method:

~~~php
$input = $climate->input('How you doin?');
$input->accept(['Fine', 'Ok']);
$input->strict();

$response = $input->prompt();
// 'fine' or 'ok' will cause a re-prompt
~~~

#### Via a Closure

You can also pass a closure into the `accept` method:

~~~php
$input = $climate->input('How you doin?');

$input->accept(function($response) {
    return ($response == 'Fine');
});

$response = $input->prompt();
~~~

### Default Response

You can specify a default response for when the user simply presses `enter` without typing anything in:

~~~php
$input = $climate->input('How you doin?');

$input->defaultTo('Great!');

$response = $input->prompt();
~~~

## Confirmation

The `confirm` method will accept only `y` or `n` (strict). The `confirmed` method will prompt the user and return a boolean:

~~~php
$input = $climate->confirm('Continue?');

// Continue? [y/n]
if ($input->confirmed()) {
    // Do your thing here
} else {
    // Don't do your thing
}
~~~

## Password

The `password` method is exactly the same as the `input` method, it simply hides the text the user is typing.

~~~php
$input    = $climate->password('Please enter password:');
$password = $input->prompt();
~~~

## Checkboxes

<p class="message-notice">Please note the checkboxes method only works in <strong>non-Windows</strong> environments as of right now.</p>

You can present the user with a set of interactive checkboxes, you will get an array back with the checked responses (an empty array in the case of no checked responses).

The keyboard arrows are used to navigate the list, the spacebar key is used to select an item.

~~~php
$options  = ['Ice Cream', 'Mixtape', 'Teddy Bear', 'Pizza', 'Puppies'];
$input    = $climate->checkboxes('Please send me all of the following:', $options);
$response = $input->prompt();
~~~

<img alt="Example of Checkboxes" src="/img/checkboxes-example.gif" style="max-width:100%" />

If you provide an associative array as the options, an array of the selected keys will be provided as the response.

~~~php
// $value => $label
$options  = [
                'option1' => 'Ice Cream',
                'option2' => 'Mixtape',
                'option3' => 'Teddy Bear',
                'option4' => 'Pizza',
                'option5' => 'Puppies'
            ];
$input    = $climate->checkboxes('Please send me all of the following:', $options);
$response = $input->prompt();
~~~

## Radio Buttons

<p class="message-notice">Please note the radio method only works in <strong>non-Windows</strong> environments as of right now.</p>

The `radio` method works almost exactly the same as the `checkboxes` method with two differences:

- The user can only select one item
- The response will be a **string**, not an array (the selected key in the case of an associative array)

~~~php
$options  = ['Ice Cream', 'Mixtape', 'Teddy Bear', 'Pizza', 'Puppies'];
$input    = $climate->radio('Please send me one of the following:', $options);
$response = $input->prompt();
~~~

<img alt="Example of Radio Buttons" src="/img/radio-example.gif" style="max-width:100%" />
