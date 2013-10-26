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
        $p1 = new StringParser("hoge");
        $p2 = new StringParser("moge");
        $p3 = new RegexParser("/poyo/");
        $p4 = new RegexParser("/piyo/");
        $p5 = new StringParser("buzz");
        $p = $p1->next($p2);
        $pp = $p3->orElse($p4);
        $ppp = $pp->next($p5);
        $this->assertEquals(
            array('hoge', 'moge', 'piyo', 'buzz'),
            $p->next($ppp)->parse("hogemogepiyobuzz")->getValue()
        );
    }


}
