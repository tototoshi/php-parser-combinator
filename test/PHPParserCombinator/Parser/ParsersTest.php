<?php
namespace PHPParserCombinator\Parser;

use Symfony\Component\Yaml\Parser;

class ParsersTest extends \PHPUnit_Framework_TestCase
{

    public function testWithParserSetting()
    {
        $p = Parsers::reg('/a/');

        Parsers::withParserSetting(array('skipWhitespace' => true), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertTrue($p->parse(' a')->isSuccess());
        });

        Parsers::withParserSetting(array('skipWhitespace' => false), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertFalse($p->parse(' a')->isSuccess());
        });

        $p = Parsers::s('a');

        Parsers::withParserSetting(array('skipWhitespace' => true), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertTrue($p->parse(' a')->isSuccess());
        });

        Parsers::withParserSetting(array('skipWhitespace' => false), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertFalse($p->parse(' a')->isSuccess());
        });
    }

    public function testShortcut()
    {
        $p = Parsers::s('a')
            ->next(Parsers::rep(Parsers::s('b')))
            ->next(Parsers::reg('/c/'))
            ->next(Parsers::repN(3, Parsers::s('d')))
            ->next(Parsers::repsep(Parsers::s('e'), Parsers::s(',')));

        $this->assertEquals(
            array('a', array('b', 'b'), 'c', array('d', 'd', 'd'), array('e', 'e')),
            $p->parse('abbcddde,e')->get()
        );
    }

    public function testRepsep()
    {
        $input = 'a,a,a';
        $parser_a = Parsers::repsep(Parsers::s('a'), Parsers::s(','));
        $this->assertEquals(
            array(array('a', 'a', 'a')),
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
            array('a'),
            $parser_a->parse($input)->get()
        );
    }

}
