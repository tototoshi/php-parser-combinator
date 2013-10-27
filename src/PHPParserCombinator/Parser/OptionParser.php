<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class OptionParser extends Parser implements ParserInterface {

    private $parser;

    function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function parse($input)
    {
        $result = $this->parser->parse($input);
        if ($result->isSuccess()) {
            return new Success(
                new ParsedValue(array($result->get())), $result->getRest());
        } else {
            return new Success(new ParsedValue(array(array())), $result->getRest());
        }
    }

}