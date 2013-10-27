# PHP Parser Combinator

wip.

## Example

```php
    $git = P::s('git');
    $at = P::s('@');
    $github = P::s("github.com");
    $colon = P::s(':');
    $user = P::reg('/[a-zA-Z0-9]+/');
    $slash = P::s('/');
    $repository = P::reg('/[a-zA-Z-_0-9]+/');
    $ext = P::s('.git');

    $parser1 = $git
        ->next($at)
        ->next($github)
        ->next($colon)
        ->next($user)
        ->next($slash)
        ->next($repository)
        ->next($ext)
        ->setTransformer(Transformer::nth(4, 6));

    $https = P::s('https');

    $parser2 = $https
        ->next($colon)
        ->next(P::repN(2, $slash))
        ->next($github)
        ->next($slash)
        ->next($user)
        ->next($slash)
        ->next($repository)
        ->next($ext)
        ->setTransformer(Transformer::nth(5, 7));

    $parser = $parser1->orElse($parser2);

    $this->assertEquals(
        array('tototoshi', 'php-parser-combinator'),
        $parser->parse("git@github.com:tototoshi/php-parser-combinator.git")->get()
    );

    $this->assertEquals(
        array('tototoshi', 'php-parser-combinator'),
        $parser->parse('https://github.com/tototoshi/php-parser-combinator.git')->get()
    );
```