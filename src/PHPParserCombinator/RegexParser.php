<?php
namespace PHPParserCombinator;


class RegexParser extends Parser
{
    private $regex;

    private $callback;

    public function __construct($regex, Callable $callback = null)
    {
        $this->regex = $regex;
        if ($callback === null) {
            $this->callback = Transformer::asIs();
        } else {
            $this->callback = $callback;
        }
    }

    public function parse($input)
    {
        if (preg_match($this->regex, $input, $matches, $flags = 0, $offset = 0) === 1) {
            if (strpos($input, $matches[0]) === 0) {
                $transformer = $this->callback;
                return new Success($transformer($matches[0]), substr($input, strlen($matches[0])));
            } else {
                return new Failure('Pattern of ' . $this->regex . ' is expected but $input found', $input);
            }

        } else {
            return new Failure('Pattern of ' . $this->regex . ' is expected but ' . $input . ' found', $input);
        }
    }
}