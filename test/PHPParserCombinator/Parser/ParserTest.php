<?php
namespace PHPParserCombinator\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{

    public function testWithParserSetting()
    {
        $p = Parser::reg('/a/');

        Parser::withParserSetting(array('skipWhitespace' => true), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertTrue($p->parse(' a')->isSuccess());
        });

        Parser::withParserSetting(array('skipWhitespace' => false), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertFalse($p->parse(' a')->isSuccess());
        });

        $p = Parser::s('a');

        Parser::withParserSetting(array('skipWhitespace' => true), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertTrue($p->parse(' a')->isSuccess());
        });

        Parser::withParserSetting(array('skipWhitespace' => false), function () use ($p) {
            $this->assertTrue($p->parse('a')->isSuccess());
            $this->assertFalse($p->parse(' a')->isSuccess());
        });
    }

    public function testShortcut()
    {
        $p = Parser::s('a')
            ->next(Parser::rep(Parser::s('b')))
            ->next(Parser::reg('/c/'))
            ->next(Parser::repN(3, Parser::s('d')))
            ->next(Parser::repsep(Parser::s('e'), Parser::s(',')));

        $this->assertEquals(
            array('a', array('b', 'b'), 'c', array('d', 'd', 'd'), array('e', 'e')),
            $p->parse('abbcddde,e')->get()
        );
    }

    public function testRepsep()
    {
        $input = 'a,a,a';
        $parser_a = Parser::repsep(Parser::s('a'), Parser::s(','));
        $this->assertEquals(
            array(array('a', 'a', 'a')),
            $parser_a->parse($input)->get()
        );
    }

    public function testBetween()
    {
        $input = '((a))';
        $parser_a = Parser::between(
            Parser::s('('),
            Parser::between(
                Parser::s('('),
                Parser::s('a'),
                Parser::s(')')
            ),
            Parser::s(')')
        );
        $this->assertEquals(
            array('a'),
            $parser_a->parse($input)->get()
        );
    }

}
