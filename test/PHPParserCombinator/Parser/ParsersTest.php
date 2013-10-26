<?php
namespace PHPParserCombinator\Parser;

class TestParser extends Parsers {

    public static function parse($input)
    {
        return
            self::s('a')
                ->next(self::rep(self::s('b')))
                ->next(self::reg('/c/'))
                ->next(self::repN(3, self::s('d')))
                ->parse($input);
    }
}

class ParsersTest extends \PHPUnit_Framework_TestCase
{

    public function testShortcut()
    {
        $this->assertEquals(
            array('a', array('b', 'b'), 'c', array('d', 'd', 'd')),
            TestParser::parse('abbcddde,e')->get()
        );
    }

}
