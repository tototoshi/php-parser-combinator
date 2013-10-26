<?php
namespace PHPParserCombinator;

class RepetitionParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $input = 'aaa';
        $parser_a = new RepetitionParser(new StringParser("a"));
        $this->assertEquals(
            array(array('a', 'a', 'a')),
            $parser_a->parse($input)->getValue()
        );
    }

}
