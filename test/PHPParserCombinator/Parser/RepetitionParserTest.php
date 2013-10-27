<?php
namespace PHPParserCombinator\Parser;

class RepetitionParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParse()
    {
        $input = 'aaa';
        $parser_a = new RepetitionParser(new StringParser("a"));
        $this->assertEquals(
            array(array('a', 'a', 'a')),
            $parser_a->parse($input)->get()
        );
    }

    public function testParseNFailure()
    {
        $input = 'aaa';
        $options = array('times' => 4);
        $parser_a = new RepetitionParser(new StringParser("a"), $options);
        $this->assertFalse($parser_a->parse($input)->isSuccess());
    }

    public function testParseNSuccess()
    {
        $input = 'aaa';
        $options = array('times' => 3);
        $parser_a = new RepetitionParser(new StringParser("a"), $options);
        $this->assertEquals(
            array(array('a', 'a', 'a')),
            $parser_a->parse($input)->get()
        );
    }

}
