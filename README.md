<p align="center"><img src="http://joe.codes/images/climate/CLImate_Blink.gif" width="500" alt="CLImate" /></p>

[![Build Status](https://travis-ci.org/joetannenbaum/climate.svg?branch=master)](https://travis-ci.org/joetannenbaum/climate)

Running PHP from the command line? CLImate is your new best bud.

CLImate allows you to easily output colored text, special formats, and more.

## Table of Contents

+ [Installation](#installation)
+ [Basic Usage](#basic-usage)
+ [Colors](#colors)
+ [Backgrounds](#backgrounds)
+ [Style Combinations](#style-combinations)
+ [Tags](#tags)
+ [Custom Colors](#custom-colors)
+ [Commands](#commands)
+ [Custom Commands](#custom-commands)
+ [Tables](#tables)
+ [Borders](#borders)
+ [Progress Bar](#progress-bar)
+ [JSON](#json)
+ [Dump](#dump)
+ [Flanking](#flanking)
+ [Breaks](#breaks)
+ [Draw](#draw)
+ [Laravel Users](#laravel-users)
+ [Credits](#credits)

## Installation

Using [composer](https://packagist.org/packages/joetannenbaum/climate):

```
{
    "require": {
        "joetannenbaum/climate": "0.1.*"
    }
}
```

## Basic Usage

The `out` method simply receives a string that will output on a new line:

```php
require_once('vendor/autoload.php');

$climate = new JoeTannenbaum\CLImate\CLImate;

$climate->out('This prints to the terminal.');
$climate->out('This prints to the terminal.')->out('This will be on a new line');
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
$climate->backgroundRed('Whoa now this text is red.');
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

Feeling wild? Just throw them all into one method:

```php
$climate->backgroundBlueGreenBlink('This may be a little hard to read.');
$climate->backgroundBlueGreenBlinkJson([
    'this' => 'is some colorful json output'
]);
```

You can apply more than one format to an output, but only one foreground and one background color. Unless you use...

## Tags

You can also just apply a color/background color/format to part of an output:

```php
$climate->blue('Please <light_red>remember</light_red> to restart the server.');
$climate->out('Remember to use your <blink><yellow>blinker</yellow></blink> when turning.');
```

You can use any of the color or formatting keywords (snake cased) as tags.

To use a background color tag, simply prepend the color with `background_`:

```php
$climate->blue('Please <bold><background_light_red>remember</background_light_red></bold> to restart the server.');
```

## Custom Colors

You can add your own custom colors:

```php
$climate->style->addColor('lilac', 38);
```

Once you've added the color, you can use it like any of the other colors:

```php
$climate->lilac('What a pretty color.');
$climate->backgroundLilac()->out('This background is a pretty color.');
$climate->out('Just this <lilac>word</lilac> is a pretty color.');
$climate->out('Just this <background_lilac>word</background_lilac> is a pretty color.');
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
$climate->style->addCommandColor('rage', 'cyan');
$climate->rage('SOMETHING IS MESSED UP.');
```

You can also override any command;

```php
$climate->style->addCommandColor('error', 'light_blue');
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

## Progress Bar

Easily add a progress bar to your output:

```php
$progress = $climate->progress()->total(100);

for ( $i = 0; $i <= 100; $i++ )
{
  $progress->current( $i );
  usleep(80000);
}
```
Which will result in:

![Progress Bar](http://joe.codes/images/climate/progress.gif)

You can also shorthand it a bit if you'd like:

```php
$climate->progress(100);
```

As with everything else, style it however you like:

```php
$climate->redProgress(100);
$climate->redBoldProgress(100);
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

## Dump

The `dump` method allows you to `var_dump` variables out to the terminal:

```php
$climate->dump([
  'This',
  'That',
  'Other Thing',
]);
```

Which results in:

```
array(3) {
  [0]=>
  string(4) "This"
  [1]=>
  string(4) "That"
  [2]=>
  string(11) "Other Thing"
}
```

But why not make it look cool:

```php
$climate->errorDump([
  'This',
  'That',
  'Other Thing',
]);

$climate->blinkDump([
  'This',
  'That',
  'Other Thing',
]);
```


## Flanking

The `flank` method allows you to bring a little more attention to a line:

```php
$climate->flank('Look at me. Now.');
/// ### Look at me. Now. ###
```

You can specify the flanking characters:


```php
$climate->flank('Look at me. Now.', '!');
/// !!! Look at me. Now. !!!
```

And how many flanking characters there should be:

```php
$climate->flank('Look at me. Now.', '!', 5);
/// !!!!! Look at me. Now. !!!!!
```

As with the other method, you can style this output as well:

```php
$climate->blink()->flank('Look at me. Now.');
$climate->blinkFlank('Look at me. Now.');
```

## Breaks

The `br` method does exactly that, inserts a line break:

```php
$climate->br();
```

For ease of use, the `br` method is chainable:

```php
$climate->br()->out('I have moved down a line.');
```

## Draw

This would all feel a bit incomplete without ASCII art, obviously. So here we go.

There are a few pre-defined choices:

+ passed
+ failed
+ bender
+ fancy-bender
+ 404

To draw one of them:

```php
$climate->draw('bender');
```

would result in:

```asciidoc
     ( )
      H
      H
     _H_
  .-'-.-'-.
 /         \
|           |
|   .-------'._
|  / /  '.' '. \
|  \ \ @   @ / /
|   '---------'
|    _______|
|  .'-+-+-+|
|  '.-+-+-+|
|    """""" |
'-.__   __.-'
     """
```

And of course, as with all of the methods, you may style it however you want:

```php
$climate->blue()->draw('bender');
$climate->backgroundRedDraw('bender');
$climate->blinkDraw('bender');
```

But not everyone's art taste is the same. So you can add your own art by just telling CLImate the directory in which it is located.

For example, let's say you this was your art collection:

```
/home
  /important
    /art
      dog.txt
      cat.txt
      rabbit.txt
      mug.txt
```

Just let CLImate know where it is via the full path:

```php
$climate->addArt('/home/important/art');
```

and now you can use anything in that directory:

```php
$climate->draw('dog');
$climate->red()->draw('cat');
$climate->boldDraw('mug');
```

You can keep using the `addArt` method to add as many directories as you'd like.

Bonus: If you've got some time on your hands, you can style your art using the style tags, as in the case of 'fancy-bender':

```asciidoc
<blue>     ( )</blue>
<blue>      H</blue>
<blue>      H</blue>
<blue>     _H_</blue>
<blue>  .-'-.-'-.</blue>
<blue> /         \</blue>
<blue>|           |</blue>
<blue>|   .-------'._</blue>
<blue>|  /</blue> <white>/  '.' '.</white> <blue>\</blue>
<blue>|  \</blue> <white>\</white> <black><blink>@</blink>   <blink>@</blink></black> <white>/</white> <blue>/</blue>
<blue>|   '---------'</blue>
<blue>|    _______|</blue>
<blue>|  .'</blue><black>-+-+-+</black><blue>|</blue>
<blue>|  '.</blue><black>-+-+-+</black><blue>|</blue>
<blue>|    """""" |</blue>
<blue>'-.__   __.-'</blue>
<blue>     """</blue>
```

resulting in:

![Fancy Bender](http://joe.codes/images/climate/fancy-bender.gif)

## Laravel Users

Use Laravel? Treat time. Add these lines to your `app/config/app.php`:

```php
'providers' => [
  '...',
  'JoeTannenbaum\CLImate\CLImateServiceProvider'
];
```

```php
'aliases' => [
  '...',
  'CLImate' => 'JoeTannenbaum\CLImate\Facade\CLImate'
];
```

You can now any of the above methods via Laravel's facades:

```php
CLImate::error('Ruh roh.');
CLImate::comment('Just so you know.');
CLImate::whisper('Not so important, just a heads up.');
CLImate::shout('This. This is important.');
CLImate::info('Nothing fancy here. Just some info.');
```

## Credits

Much love to [Damian Makki](https://dribbble.com/damianmakki) for the logo.
