<?php

namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\Failure;
use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class NotParser extends Parser implements ParserInterface {

    private $parser;

    function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $input
     * @return Failure|Success
     */
    public function parse($input)
    {
        $result = $this->parser->parse($input);
        if (! $result->isSuccess()) {
            return new Success(
                new ParsedValue(array()),
                $result->getRest()
            );
        } else {
            $msg = "Unexpected input. ($input)";
            return new Failure($msg, $input);
        }
    }

}