<?php
namespace PHPParserCombinator\Parser;

class DisjunctiveParserTest extends \PHPUnit_Framework_TestCase
{


    public function testParse()
    {
        $p1 = new RegexParser("/poyo/");
        $p2 = new RegexParser("/piyo/");
        $p = $p1->orElse($p2);
        $this->assertEquals(array('piyo'), $p->parse('piyo')->get());
    }

}
