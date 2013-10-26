<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\Failure;
use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;
use PHPParserCombinator\Transformer\Transformer;

class StringParser extends Parser implements ParserInterface
{

    private $value;

    public function __construct($value, Callable $transformer = null)
    {
        $this->value = $value;

    }

    public function parse($input)
    {
        if (strpos($input, $this->value) === 0) {
            $transformer = $this->getTransformer();
            $value = $transformer($this->value);
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
