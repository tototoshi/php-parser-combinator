<?php
namespace PHPParserCombinator;


class RegexParser extends Parser implements ParserInterface
{
    private $regex;

    public function __construct($regex)
    {
        $this->regex = $regex;
    }

    public function parse($input)
    {
        if (preg_match($this->regex, $input, $matches, $flags = 0, $offset = 0) === 1) {
            if (strpos($input, $matches[0]) === 0) {
                $transformer = $this->getTransformer();
                return new Success(array($transformer($matches[0])), substr($input, strlen($matches[0])));
            } else {
                return new Failure('Pattern of ' . $this->regex . ' is expected but $input found', $input);
            }

        } else {
            return new Failure('Pattern of ' . $this->regex . ' is expected but ' . $input . ' found', $input);
        }
    }
}