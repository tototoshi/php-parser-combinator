<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\Failure;
use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class StringParser extends AbstractParser implements ParserInterface
{

    private $value;

    public function __construct($value, callable $transformer = null)
    {
        $this->value = $value;

    }

    public function parse($input)
    {
        $trimmed_input = $this->ltrimWhitespace($input);
        if (strpos($trimmed_input, $this->value) === 0) {
            $transformer = $this->getTransformer();
            $value = $transformer(array($this->value));
            return new Success(
                new ParsedValue($value),
                substr($input, strlen($this->value)),
                $this->getTransformer()
            );
        } else {
            $expected = $this->value;
            $actual = substr($input, 0, strlen($this->value));
            return new Failure("$expected is expected but $actual found.", $input);
        }
    }
}
