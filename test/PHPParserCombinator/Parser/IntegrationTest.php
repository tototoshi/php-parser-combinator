<?php
namespace PHPParserCombinator\Parser;

use PHPParserCombinator\Transformer\Transformer;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $p1 = new StringParser("hoge");
        $p2 = new StringParser("moge");
        $p3 = new RegexParser("/poyo/");
        $p4 = new RegexParser("/piyo/");
        $p5 = new StringParser("buzz");
        $p = $p1->next($p2)->next($p3->orElse($p4))->next($p5);
        $this->assertEquals(
            array('hoge', 'moge', 'piyo', 'buzz'),
            $p->parse("hogemogepiyobuzz")->get()
        );
    }

    public function testParse2()
    {
        $input = 'aaabbcb';
        $parser_a = new RepetitionParser(new StringParser("a"));
        $parser_b = new StringParser("b");
        $parser_c = new StringParser("c");
        $parser_b_c = new RepetitionParser($parser_b->orElse($parser_c));
        $this->assertEquals(
            array(array('a', 'a', 'a'), array('b', 'b', 'c', 'b')),
            $parser_a->next($parser_b_c)->parse($input)->get()
        );
    }

    public function testParseIgnoringSpace()
    {
        $p1 = new StringParser("hoge");
        $p2 = new StringParser("moge");
        $p3 = new RegexParser("/poyo/");
        $p4 = new RegexParser("/piyo/");
        $p5 = new StringParser("buzz");
        $p = $p1->next($p2)->next($p3->orElse($p4))->next($p5);
        $this->assertEquals(
            array('hoge', 'moge', 'piyo', 'buzz'),
            $p->parse("hogemogepiyo buzz")->get()
        );
    }

    public function testParseEmail()
    {
        $local_part = new RegexParser("/[^@]+/");
        $at = new StringParser("@");
        $domain_part = new RegexParser("/[^@]+/");
        $p = $local_part->next($at)->next($domain_part);
        $this->assertEquals(
            array('hoge', '@', 'example.com'),
            $p->parse('hoge@example.com')->get()
        );
    }

    public function testParseGitUrl()
    {
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
    }


}
