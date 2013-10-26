<?php
namespace PHPParserCombinator;

class TestParser extends Parsers {

    public static function parse($input)
    {
        return
            self::s('a')
                ->next(self::rep(self::s('b')))
                ->next(self::reg('/c/'))
                ->parse($input);
    }
}

class ParsersTest extends \PHPUnit_Framework_TestCase
{

    public function testShortcut()
    {
        $this->assertEquals(
            array('a', array('b', 'b'), 'c'),
            TestParser::parse('abbc')->getValue()
        );
    }

}
