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

    public function testRep1()
    {
        $p = Parser::rep1(Parser::s('ab'));

        $this->assertEquals(array(array('ab', 'ab')), $p->parse('abab')->get());
        $this->assertEquals(array(array('ab')), $p->parse('ab')->get());
        $this->assertFalse($p->parse('a')->isSuccess());
    }

    public function testRepsep()
    {
        $parser_a = Parser::repsep(Parser::s('a'), Parser::s(','));
        $this->assertEquals(array(array('a', 'a', 'a')), $parser_a->parse('a,a,a')->get());
        $this->assertEquals(array(array('a')), $parser_a->parse('a')->get());
        $this->assertEquals(array(array()), $parser_a->parse('')->get());
    }

    public function testRep1sep()
    {
        $parser_a = Parser::rep1sep(Parser::s('a'), Parser::s(','));
        $this->assertEquals(array(array('a', 'a', 'a')), $parser_a->parse('a,a,a')->get());
        $this->assertEquals(array(array('a')), $parser_a->parse('a')->get());
        $this->assertFalse($parser_a->parse('')->isSuccess());
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
