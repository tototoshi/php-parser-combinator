<?php
namespace PHPParserCombinator\Parser;

class PTest extends \PHPUnit_Framework_TestCase
{

    public function testAlias()
    {
        $this->assertEquals(array('a'), P::s('a')->parse('a')->get());
    }

}
