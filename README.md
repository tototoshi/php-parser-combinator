# PHP Parser Combinator

wip.

## Example

```php
    $git = Parsers::s('git');
    $at = Parsers::s('@');
    $github = Parsers::s("github.com");
    $colon = Parsers::s(':');
    $user = Parsers::reg('/[a-zA-Z0-9]+/');
    $slash = Parsers::s('/');
    $repository = Parsers::reg('/[a-zA-Z-_0-9]+/');
    $ext = Parsers::s('.git');

    $parser = $git
        ->next($at)
        ->next($github)
        ->next($colon)
        ->next($user)
        ->next($slash)
        ->next($repository)
        ->next($ext);

    $result = $parser->parse("git@github.com:tototoshi/php-parser-combinator.git")->get();
    $this->assertEquals(
        array('tototoshi', 'php-parser-combinator'),
        array($result[4], $result[6])
    );
```