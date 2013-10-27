<?php
namespace PHPParserCombinator\Parser;

use PHPParserCombinator\Result\Failure;
use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class RegexParser extends Parser implements ParserInterface
{
    private $regex;

    public function __construct($regex)
    {
        $this->regex = $regex;
    }

    public function parse($input)
    {
        $trimmed_input = $this->ltrimWhitespace($input);

        if (preg_match($this->regex, $trimmed_input, $matches, $flags = 0, $offset = 0) === 1) {
            if (strpos($trimmed_input, $matches[0]) === 0) {
                $transformer = $this->getTransformer();
                return new Success(
                    new ParsedValue($transformer(array($matches[0]))),
                    substr($trimmed_input, strlen($matches[0]))
                );
            } else {
                return new Failure('Pattern of ' . $this->regex . ' is expected but $input found', $input);
            }

        } else {
            return new Failure('Pattern of ' . $this->regex . ' is expected but ' . $input . ' found', $input);
        }
    }
}