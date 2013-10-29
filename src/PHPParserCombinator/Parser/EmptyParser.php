<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\Failure;
use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class EmptyParser extends AbstractParser implements ParserInterface
{

    public function __construct()
    {
    }

    public function parse($input)
    {
        $transformer = $this->getTransformer();
        $value = array();
        $value = $transformer($value);
        return new Success(new ParsedValue($value), $input);
    }
}
