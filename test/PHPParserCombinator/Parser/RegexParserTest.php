<?php
namespace PHPParserCombinator\Parser;

class RegexParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $p = new RegexParser('/a/');
        $this->assertEquals(array('a'), $p->parse('a')->get());
    }

}
