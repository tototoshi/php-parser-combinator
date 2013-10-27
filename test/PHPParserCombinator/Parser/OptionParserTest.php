<?php
namespace PHPParserCombinator\Parser;

class OptionParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $http = new StringParser("http");
        $s = new OptionParser(new StringParser("s"));
        $p = $http->next($s);
        $this->assertEquals(array('http', array('s')), $p->parse('https')->get());
        $this->assertEquals(array('http', array()), $p->parse('http')->get());
    }

}
