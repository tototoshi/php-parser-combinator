<?php
namespace PHPParserCombinator\Result;

class ParsedValueTest extends \PHPUnit_Framework_TestCase
{

    public function testAppend()
    {
        $pv = new ParsedValue('a');
        $this->assertEquals(array('a', 'b'), $pv->append(new ParsedValue('b'))->get());
    }

}
