<?php
namespace PHPParserCombinator\Parser;

class NotParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $p_not_a = Parser::not(Parser::s('a'));
        $p_b = Parser::s('b');
        $this->assertEquals(array(), $p_not_a->parse('b')->get());
        $this->assertEquals(array('b'), $p_not_a->next($p_b)->parse('b')->get());
        $this->assertFalse($p_not_a->parse('a')->isSuccess());
    }

}
