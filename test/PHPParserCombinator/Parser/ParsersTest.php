<?php
namespace PHPParserCombinator\Parser;

use Symfony\Component\Yaml\Parser;

class TestParser extends Parsers {

    public static function parse($input)
    {
        return
            self::s('a')
                ->next(self::rep(self::s('b')))
                ->next(self::reg('/c/'))
                ->next(self::repN(3, self::s('d')))
                ->next(self::repsep(self::s('e'), self::s(',')))
                ->parse($input);
    }
}

class ParsersTest extends \PHPUnit_Framework_TestCase
{

    public function testShortcut()
    {
        $this->assertEquals(
            array('a', array('b', 'b'), 'c', array('d', 'd', 'd'), array('e', 'e')),
            TestParser::parse('abbcddde,e')->get()
        );
    }

    public function testRepsep()
    {
        $input = 'a,a,a';
        $parser_a = Parsers::repsep(Parsers::s('a'), Parsers::s(','));
        $this->assertEquals(
            array('a', 'a', 'a'),
            $parser_a->parse($input)->get()
        );
    }

    public function testBetween()
    {
        $input = '((a))';
        $parser_a = Parsers::between(
            Parsers::s('('),
            Parsers::between(
                Parsers::s('('),
                Parsers::s('a'),
                Parsers::s(')')
            ),
            Parsers::s(')')
        );
        $this->assertEquals(
            'a',
            $parser_a->parse($input)->get()
        );
    }

}
