# CLImate

[![Build Status](https://travis-ci.org/joetannenbaum/climate.svg?branch=master)](https://travis-ci.org/joetannenbaum/climate)

Running PHP from the command line? CLImate allows you to output colored text, specially formatted text, and more.

## Installation

Using composer:

```
{
    "require": {
        "joetannenbaum/climate": "~1.0"
    }
}
```

## Basic Usage

```php
$climate = new CLImate;
$climate->out('This prints to the terminal.');
```

And you can do that. But that's not very fun.

## Colors

There are many pre-defined colors at your disposal:

+ Black
+ Red
+ Green
+ Yellow
+ Blue
+ Magenta
+ Cyan
+ Light Gray
+ Dark Gray
+ Light Red
+ Light Green
+ Light Yellow
+ Light Blue
+ Light Magenta
+ Light Cyan
+ White

```php
$climate->red('Whoa now this text is red.');
$climate->blue('Blue? Wow!');
$climate->lightGreen('It\'s not easy being (light) green.');
```

If you prefer, you can also simply chain the color method and continue using `out`:

```php
$climate->red()->out('Whoa now this text is red.');
$climate->blue()->out('Blue? Wow!');
$climate->lightGreen()->out('It\'s not easy being (light) green.');
```

## Backgrounds

To to apply a color as a background, simply prepend the color method with `background`:

```php
$climate->backgroundRed()->out('Whoa now this text is red.');
$climate->backgroundBlue()->out('Blue? Wow!');
$climate->backgroundLightGreen()->out('It\'s not easy being (light) green.');
```

## Formatting

You have several formatting options:

+ Bold
+ Dim
+ Underline
+ Blink
+ Invert
+ Hidden

To apply a format:

```php
$climate->bold('Bold and beautiful.');
$climate->underline('I have a line beneath me.');

$climate->bold()->out('Bold and beautiful.');
$climate->underline()->out('I have a line beneath me.');
```

You can apply multiple formats by chaining them:


```php
$climate->bold()->underline()->out('Bold (and underlined) and beautiful.');
$climate->blink()->dim('Dim. But noticeable.');
```

## Style Combinations

You can chain any of the above to get what you want:

```php
$climate->backgroundBlue()->green()->blink()->out('This may be a little hard to read.');
```

You can apply more than one format to an output, but only one foreground and one background color. Unless you use...

## Tags

You can also just apply a color/background color/format to part of an output:

```php
$this->blue('Please <bold><light_red>remember</light_red></bold> to restart the server.');
```

You can use any of the color or formatting keywords (snake cased) as tags.

To use a background color tag, simply prepend the color with `background_`:

```php
$this->blue('Please <bold><background_light_red>remember</background_light_red></bold> to restart the server.');
```

## Custom Colors

You can add your own custom colors:

```php
$climate->style->addColor('lilac', 38);
```

Once you've added the color, you can use it like any of the other colors:

```php
$climate->lilac('What a pretty color.');
$climate->lilacBackground('This background is a pretty color.');
$climate->out('Just this <lilac>word</lilac> is a pretty color.');
```

## Commands

Commands are simply pre-defined colors for specific output:

```php
$climate->error('Ruh roh.');
$climate->comment('Just so you know.');
$climate->whisper('Not so important, just a heads up.');
$climate->shout('This. This is important.');
$climate->info('Nothing fancy here. Just some info.');
```

## Custom Commands

You can add your own command, just make sure that the color is defined already.

```php
$climate->stye->addCommandColor('rage', 'dark_red');
$climate->rage('SOMETHING IS MESSED UP.');
```

You can also override any command;

```php
$climate->stye->addCommandColor('error', 'light_blue');
$climate->error('Whelp. That did not turn out so well.');
```

## Tables

The `table` method can receive any of the following:

+ Array of arrays
+ Array of associative arrays
+ Array of objects

### Array of Arrays

```php
$climate->table([
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
]);
```

```
------------------------------------------
| Walter White     | Father | Teacher    |
------------------------------------------
| Skyler White     | Mother | Accountant |
------------------------------------------
| Walter White Jr. | Son    | Student    |
------------------------------------------
```
### Array of (Associative Arrays | Objects)

```php
$climate->table([
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
]);
```

```
------------------------------------------
| name             | role   | profession |
==========================================
| Walter White     | Father | Teacher    |
------------------------------------------
| Skyler White     | Mother | Accountant |
------------------------------------------
| Walter White Jr. | Son    | Student    |
------------------------------------------
```

As with other methods, you can style a table as well. So all of the following works:


```php
$climate->redTable([
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
]);

$climate->red()->table([
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
]);

$climate->table([
    [
      'name'       => 'Walter White',
      'role'       => '<light_blue>Father</light_blue>',
      'profession' => 'Teacher',
    ],
    [
      'name'       => 'Skyler White',
      'role'       => 'Mother',
      'profession' => '<red>Accountant</red>',
    ],
]);
```

## Borders

If you want to insert a border to break up output, simply use the `border` method. By default, `border` outputs a dashed border with 100 characters in it

```php
$climate->border();
// ----------------------------------------------------------------------------------------------------

```

The `border` method takes two arguments:

+ Character(s) to be repeated
+ Length of the border

```php
$climate->border('*');
// ****************************************************************************************************

$climate->border('-*-');
// -*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--

$climate->border('-*-', 50);
// -*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*
```

As with the other methods, feel free to style the border:

```php
$climate->red()->border();

$climate->redBorder();

$climate->bold()->backgroundBlue()->border();
```

## JSON

The `json` method outputs some pretty-printed JSON to the terminal:

```php
$climate->json([
  'name' => 'Gary',
  'age'  => 52,
  'job'  => 'Engineer',
]);
```

```
{
    "name": "Gary",
    "age": 52,
    "job": "Engineer"
}
```

As with the other method, you can style this output as well:

```php
$climate->redJson([
  'name' => 'Gary',
  'age'  => 52,
  'job'  => 'Engineer',
]);

$climate->red()->json([
  'name' => 'Gary',
  'age'  => 52,
  'job'  => '<blink>Engineer</blink>',
]);

$climate->underline()->json([
  'name' => 'Gary',
  'age'  => 52,
  'job'  => 'Engineer',
]);
```

## Breaks

The `br` method does exactly that, inserts a line break:

```php
$climate->br();
```

The `br` method is chainable, so you can do this:

```php
$climate->br()->out('I have moved down a line.');
```
