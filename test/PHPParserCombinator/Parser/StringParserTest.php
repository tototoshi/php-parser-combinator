<?php
namespace PHPParserCombinator\Parser;

class StringParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $p = new StringParser('a');
        $this->assertEquals('a', $p->parse('a')->get());
    }

}
