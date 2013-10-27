<?php
namespace PHPParserCombinator\Parser;

class NotParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $p = Parsers::not(Parsers::s('a'));
        $this->assertEquals(array(), $p->parse('b')->get());
        $this->assertFalse($p->parse('a')->isSuccess());
    }

}
