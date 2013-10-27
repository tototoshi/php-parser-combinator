<?php
namespace PHPParserCombinator\Result;

class ParsedValueTest extends \PHPUnit_Framework_TestCase
{

    public function testAppend()
    {
        $pv = new ParsedValue(array('a'));
        $pv->append(new ParsedValue(array('b')));
        $this->assertEquals(array('a', 'b'), $pv->get());
    }

}
