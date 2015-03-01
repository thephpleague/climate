---
layout: default
title: Arguments
permalink: /arguments/
---

Arguments
==============

CLImate gives you the ability to easily define and parse arguments passed to your script.

## Defining Arguments

When defining arguments, there are several options at your disposal:

+ `prefix` The short prefix version of your argument without any dashes (-u)
+ `longPrefix` The long prefix version of your argument without any dashes (--user)
+ `description` A helpful explanation of the argument
+ `defaultValue` A default value if a value is not passed
+ `required` (bool) Whether or not the argument is required
+ `noValue` (bool) If the argument does not require a value, it is simply passed, the value is automatically cast to a boolean
+ `castTo` Cast the value of the argument to either a 'string', 'int', 'float', or 'bool'

These options are not required, you may choose any that are applicable to your definition.

Argument definitions are always passed as an associative array:

~~~php
$climate->arguments->add([
    'user' => [
        'prefix'       => 'u',
        'longPrefix'   => 'user',
        'description'  => 'Username',
        'defaultValue' => 'me_myself_i',
    ],
    'password' => [
        'prefix'      => 'p',
        'longPrefix'  => 'password',
        'description' => 'Password',
        'required'    => true,
    ],
    'iterations' => [
        'prefix'      => 'i',
        'longPrefix'  => 'iterations',
        'description' => 'Number of iterations',
        'castTo'      => 'int',
    ],
    'verbose' => [
        'prefix'      => 'v',
        'longPrefix'  => 'verbose',
        'description' => 'Verbose output',
        'noValue'     => true,
    ],
    'help' => [
        'longPrefix'  => 'help',
        'description' => 'Prints a usage statement',
        'noValue'     => true,
    ],
    'path' => [
        'description' => 'The path to push',
    ],
]);
~~~

## Parsing and Retrieving Values

Parsing the passed arguments and retrieving their values is very simple.

You must first parse the arguments:

~~~php
$climate->arguments->parse();
~~~

<p class="message-notice">Please note that if you have defined required arguments and they are not passed in, the parse method will throw an Exception</p>

Then you may retrieve the value of any of your arguments by the key associated with their definition:

~~~php
$climate->arguments->get('user');
$climate->arguments->get('password');
~~~

To simply check if an argument was was passed at all, you can use the `defined` method:

~~~php
$climate->arguments->defined('verbose');
~~~

## Adding a Description

Sometimes it's helpful to add a short description of the script to help a user out. Easy enough:

~~~php
$climate->description('My CLI Script');
~~~

This comes in handy when printing...

## Usage Statements

Printing a formatted usage statement is easy:

~~~php
$climate->usage();
~~~

would result in:

~~~
My CLI Script

Usage: functional/args.php [--help] [-i iterations, --iterations iterations] [-p password, --password password] [-u user, --user user (default: me_myself_i)] [-v, --verbose] [path]

Required Arguments:
    -p password, --password password
        Password

Optional Arguments:
    --help
        Prints a usage statement
    -i iterations, --iterations iterations
        Number of iterations
    -u user, --user user (default: me_myself_i)
        Username
    -v, --verbose
        Verbose output
~~~
