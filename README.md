# PHP Parser Combinator

wip.

## Example

```php
    $git = Parsers::s('git')->setIgnoreResult(true);
    $at = Parsers::s('@')->setIgnoreResult(true);
    $github = Parsers::s("github.com")->setIgnoreResult(true);
    $colon = Parsers::s(':')->setIgnoreResult(true);
    $user = Parsers::reg('/[a-zA-Z0-9]+/');
    $slash = Parsers::s('/')->setIgnoreResult(true);
    $repository = Parsers::reg('/[a-zA-Z-_0-9]+/');
    $ext = Parsers::s('.git')->setIgnoreResult(true);

    $parser = $git
        ->next($at)
        ->next($github)
        ->next($colon)
        ->next($user)
        ->next($slash)
        ->next($repository)
        ->next($ext);

    $this->assertEquals(
        array('tototoshi', 'php-parser-combinator'),
        $parser->parse("git@github.com:tototoshi/php-parser-combinator.git")->getValue()
    );
```