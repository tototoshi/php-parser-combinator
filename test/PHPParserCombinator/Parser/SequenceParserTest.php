<?php
namespace PHPParserCombinator\Parser;

class SequenceParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $p1 = new StringParser('a');
        $p2 = new StringParser('b');
        $p3 = new StringParser('c');
        $p = $p1->next($p2)->next($p3);
        $this->assertEquals(array('a', 'b', 'c'), $p->parse('abc')->get());
    }

}
