---
layout: layout
title: Draw
---

Draw
==============

This would all feel a bit incomplete without ASCII art, obviously.

There are a few pre-defined choices:

+ passed
+ failed
+ bender
+ fancy-bender
+ 404

To draw some art:

~~~.language-php
$climate->draw('bender');
~~~

which results in:

~~~
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
~~~

## Adding Art

But not everyone's art taste is the same. So you can add your own art by just telling CLImate the directory in which it is located.

For example, let's say you this was your art collection:

~~~
/home
  /important
    /art
      dog.txt
      cat.txt
      rabbit.txt
      mug.txt
~~~

Just let CLImate know where it is via the full path:

~~~.language-php
$climate->addArt('/home/important/art');
~~~

and now you can use anything in that directory:

~~~.language-php
$climate->draw('dog');
$climate->red()->draw('cat');
$climate->boldDraw('mug');
~~~

You can keep using the `addArt` method to add as many directories as you'd like.

## Bonus

If you've got some time on your hands, you can make your art come to life using the style tags, as in the case of 'fancy-bender':

~~~
<blue>     ( )</blue>
<blue>      H</blue>
<blue>      H</blue>
<blue>     _H_</blue>
<blue>  .-'-.-'-.</blue>
<blue> /         \</blue>
<blue>|           |</blue>
<blue>|   .-------'._</blue>
<blue>|  /<white>/  '.' '.</white> \</blue>
<blue>|  \<white>\ <black><blink>@   @</blink></black> /</white> /</blue>
<blue>|   '---------'</blue>
<blue>|    _______|</blue>
<blue>|  .'<black>-+-+-+</black>|</blue>
<blue>|  '.<black>-+-+-+</black>|</blue>
<blue>|    """""" |</blue>
<blue>'-.__   __.-'</blue>
<blue>     """</blue>
~~~

resulting in:

![Fancy Bender](/img/fancy-bender.gif)
