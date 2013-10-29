<?php
namespace PHPParserCombinator\Parser;

class EmptyParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $input = 'a';
        $p = new EmptyParser();
        $this->assertEquals(array(), $p->parse($input)->get());
    }

}
