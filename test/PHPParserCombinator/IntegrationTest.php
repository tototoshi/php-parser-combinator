<?php
namespace PHPParserCombinator;

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
            $p->parse("hogemogepiyobuzz")->getValue()
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
            $parser_a->next($parser_b_c)->parse($input)->getValue()
        );
    }

    public function testParseIgnoringSpace()
    {
        $p1 = new StringParser("hoge");
        $p2 = new StringParser("moge");
        $p3 = new RegexParser("/poyo/");
        $p4 = new RegexParser("/piyo/");
        $p5 = new StringParser("buzz");
        $option = array('skipWhitespace' => true);
        $p = $p1->next($p2, $option)->next($p3->orElse($p4), $option)->next($p5, $option);
        $this->assertEquals(
            array('hoge', 'moge', 'piyo', 'buzz'),
            $p->parse("hogemogepiyo buzz")->getValue()
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
            $p->parse('hoge@example.com')->getValue()
        );
    }


}
