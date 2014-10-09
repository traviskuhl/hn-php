# hn-php
[![Build Status](https://travis-ci.org/traviskuhl/hn-php.svg?branch=master)](https://travis-ci.org/traviskuhl/hn-php)

https://github.com/HackerNews/API

## Use
```
{
    "require": {
        "traviskuhl/hn-php": "dev-master"
    }
}
```

## Example
```php
 $client = new hn\Client();

 // fetch a story
 $story = $client->item(8243523);
 echo $story->title; // Yahoo stopping all new development of YUI

 // same for a poll
 $poll = $client->item(126809);
 echo $poll->title; // Poll: What would happen if News.YC had explicit support for polls?

 // fetch a user
 $user = $client->user('pg');
 echo $user->bio; // Bug fixer.

```
